<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>

    <article class="entry">
        <h2><?= $artikel['judul']; ?></h2>
        <p><strong>Kategori:</strong> <?= isset($artikel['nama_kategori']) ? $artikel['nama_kategori'] : 'Umum'; ?></p>
        <hr>
        <div class="content">
            <?= $artikel['isi']; ?>
        </div>
    </article>

<?= $this->endSection(); ?>