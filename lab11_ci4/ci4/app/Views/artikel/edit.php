<?= $this->include('template/admin_header'); ?>

<div class="main-form">
    <h2><?= $title; ?></h2>
    <form action="" method="post">
        <p>
            <input type="text" name="judul" value="<?= $data['judul']; ?>">
        </p>
        <p>
            <textarea name="isi" cols="50" rows="10"><?= $data['isi']; ?></textarea>
        </p>
        <p>
            <input type="submit" value="Kirim" class="btn btn-large">
        </p>
        <p>
        <label for="id_kategori">Kategori:</label>
        <select name="id_kategori" id="id_kategori" required style="padding: 5px; margin-bottom: 10px;">
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" <?= ($data['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    </form>
</div>

<?= $this->include('template/admin_footer'); ?>