<?= $this->include('template/admin_header'); ?>

<div class="main-form">
    <h2><?= $title; ?></h2>
    
    <form action="" method="post" enctype="multipart/form-data">
        <p>
            <input type="text" name="judul" placeholder="Judul Artikel" required>
        </p>
        
        <p>
            <textarea name="isi" cols="50" rows="10" placeholder="Isi Artikel" required></textarea>
        </p>

        <p>
            <label for="id_kategori">Kategori:</label><br>
            <select name="id_kategori" id="id_kategori" required style="padding: 5px; margin-bottom: 10px; width: 250px;">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="gambar">Upload Gambar:</label><br>
            <input type="file" name="gambar" id="gambar" style="margin-bottom: 20px;">
        </p>

        <p>
            <input type="submit" value="Kirim" class="btn btn-large">
        </p>
    </form>
</div>

<?= $this->include('template/admin_footer'); ?>