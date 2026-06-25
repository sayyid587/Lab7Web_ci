<?= $this->include('template/admin_header'); ?>

<style>
    /* --- CSS TABEL & TOMBOL (TETAP SAMA) --- */
    .table { width: 100%; border-collapse: collapse; margin-top: 15px; clear: both; }
    .table th, .table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .table th { background-color: #5b9bd5; color: white; }
    .btn { padding: 6px 12px; text-decoration: none; background-color: #a6a6a6; color: white; border-radius: 4px; display: inline-block; margin-right: 5px; }
    .btn-danger { background-color: #e74c3c; }
    .btn-primary { background-color: #3498db; border: none; cursor: pointer; }

    /* --- CSS PENCARIAN & FILTER KATEGORI (TETAP SAMA) --- */
    .search-container { display: flex; justify-content: flex-start; margin-top: 20px; margin-bottom: 15px; padding-left: 12px; width: 100%; box-sizing: border-box; }
    .search-container form { margin: 0 !important; padding: 0 !important; float: none !important; display: flex; align-items: center; gap: 10px; }
    .search-container input[type="text"], .search-container select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
    .search-container input[type="text"] { width: 250px; }

    /* --- CSS PAGINATION (TETAP SAMA) --- */
    .pager-container { padding-left: 12px; margin-top: 20px; margin-bottom: 40px; }
    .pager-container nav { background: transparent !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important; }
    .pager-container ul { display: flex; list-style: none; padding: 0; margin: 0; }
    .pager-container ul li { margin-right: 5px; }
    .pager-container ul li a, .pager-container ul li span { display: inline-block; padding: 8px 15px; color: #333; background-color: #ddd; text-decoration: none; border-radius: 4px; font-weight: bold; }
    .pager-container ul li.active a, .pager-container ul li.active span { background-color: #5b9bd5 !important; color: white !important; }
    .pager-container ul li a:hover { background-color: #ccc; }
</style>

<div class="search-container">
    <form id="search-form" class="form-inline">
        <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari data artikel...">
        
        <select name="kategori_id" id="category-filter">
            <option value="">-- Semua Kategori --</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input type="submit" value="Cari" class="btn btn-primary">
    </form>
</div>

<div id="article-container"></div>
<div class="pager-container" id="pagination-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const articleContainer = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const searchForm = $('#search-form');
    const searchBox = $('#search-box');
    const categoryFilter = $('#category-filter');

    // Fungsi fetch AJAX
    const fetchData = (url) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(data) {
                renderArticles(data.artikel);
                renderPagination(data.pager, data.q, data.kategori_id);
            }
        });
    };

    // Fungsi gambar Tabel
    const renderArticles = (articles) => {
        let html = '<table class="table">';
        html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';
        
        if (articles.length > 0) {
            articles.forEach(article => {
                let isiPendek = article.isi ? article.isi.substring(0, 50) + '...' : '';
                let namaKat = article.nama_kategori ? article.nama_kategori : 'Umum';
                
                html += `
                <tr>
                    <td>${article.id}</td>
                    <td>
                        <b>${article.judul}</b>
                        <p><small>${isiPendek}</small></p>
                    </td>
                    <td>${namaKat}</td>
                    <td>${article.status}</td>
                    <td>
                        <a class="btn" href="/admin/artikel/edit/${article.id}">Ubah</a>
                        <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                    </td>
                </tr>`;
            });
        } else {
            html += '<tr><td colspan="5" style="text-align:center;">Data tidak ditemukan.</td></tr>';
        }
        
        html += '</tbody></table>';
        articleContainer.html(html);
    };

    // Fungsi gambar Pagination
    const renderPagination = (pager, q, kategori_id) => {
        if(!pager || !pager.links) return paginationContainer.html(''); 
        
        let html = '<nav><ul>';
        pager.links.forEach(link => {
            let url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}` : '#';
            html += `<li class="${link.active ? 'active' : ''}"><a href="${url}">${link.title}</a></li>`;
        });
        html += '</ul></nav>';
        
        paginationContainer.html(html);
    };

    // Saat tombol Cari diklik atau ketik Enter
    searchForm.on('submit', function(e) {
        e.preventDefault();
        const q = searchBox.val();
        const kat_id = categoryFilter.val();
        fetchData(`/admin/artikel?q=${q}&kategori_id=${kat_id}`);
    });

    // Saat dropdown kategori diubah, otomatis nyari
    categoryFilter.on('change', function() {
        searchForm.trigger('submit');
    });

    // Klik tombol pagination
    $(document).on('click', '.pager-container a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url !== '#') {
            fetchData(url);
        }
    });

    // Panggil data pertama kali
    fetchData('/admin/artikel');
});
</script>

<?= $this->include('template/admin_footer'); ?>