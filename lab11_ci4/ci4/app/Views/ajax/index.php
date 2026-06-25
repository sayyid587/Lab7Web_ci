<?= $this->include('template/header'); ?>

<h1>Data Artikel (Via AJAX)</h1>

<div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9;">
    <h3>Tambah Artikel Baru</h3>
    <form id="formTambah">
        <div style="margin-bottom: 10px;">
            <input type="text" name="judul" id="judul" placeholder="Judul Artikel" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <textarea name="isi" id="isi" placeholder="Isi Artikel" rows="3" required style="width: 100%; padding: 8px;"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Data</button>
    </form>
</div>

<table class="table" id="artikelTable" border="1" cellpadding="10" style="width: 100%; text-align: left;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    
    // Fungsi untuk menampilkan tulisan loading
    function showLoadingMessage() {
        $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
    }

    // Fungsi untuk memuat data via AJAX
    function loadData() {
        showLoadingMessage(); 
        
        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var tableBody = "";
                
                // Looping data dari database
                for (var i = 0; i < data.length; i++) {
                    var row = data[i];
                    tableBody += '<tr>';
                    tableBody += '<td>' + row.id + '</td>';
                    tableBody += '<td>' + row.judul + '</td>';
                    tableBody += '<td><span class="status">Aktif</span></td>';
                    tableBody += '<td>';
                    tableBody += '<a href="<?= base_url('artikel/edit/') ?>' + row.id + '" class="btn btn-primary">Edit</a> ';
                    tableBody += '<a href="#" class="btn btn-danger btn-delete" data-id="' + row.id + '">Delete</a>';
                    tableBody += '</td>';
                    tableBody += '</tr>';
                }
                
                $('#artikelTable tbody').html(tableBody);
            }
        });
    }

    // Panggil fungsi loadData saat web dibuka
    loadData();

    // Fungsi menghapus data
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "DELETE",
                success: function(data) {
                    loadData(); // Langsung refresh tabel tanpa refresh web
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting article: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }
    });

    // ==========================================
    // FUNGSI BARU: Tambah Data via AJAX
    // ==========================================
    $('#formTambah').submit(function(e) {
        e.preventDefault(); // Mencegah browser me-reload halaman
        
        // Ambil data dari form secara otomatis
        var formData = $(this).serialize();
        
        $.ajax({
            url: "<?= base_url('ajax/simpan') ?>",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if(response.status == 'Berhasil') {
                    alert('Mantap! Data berhasil ditambahkan.');
                    $('#formTambah')[0].reset(); // Kosongkan inputan form kembali
                    loadData(); // Refresh tabel secara instan buat nampilin data baru
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Gagal menyimpan data: ' + errorThrown);
            }
        });
    });

});
</script>

<?= $this->include('template/footer'); ?>