<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Portal Berita' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Portal Berita</h1>
        </header>
        <nav>
            <a href="<?= base_url('/'); ?>">Home</a>
            <a href="<?= base_url('/artikel'); ?>">Artikel</a>
            <a href="<?= base_url('/about'); ?>">About</a>
            <a href="<?= base_url('/contact'); ?>">Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content') ?>
            </section>
            <aside id="sidebar">
                <?= view_cell('\App\Cells\ArtikelTerkini::render') ?>

                <div class="widget-box">
                    <h3 class="title">Widget Text</h3>
                    <p>Praktikum Pemrograman Web - Universitas Pelita Bangsa.</p>
                </div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2026 - M.Ridho Febrian</p>
        </footer>
    </div>
</body>
</html>