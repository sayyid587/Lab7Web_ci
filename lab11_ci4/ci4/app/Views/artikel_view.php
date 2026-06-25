<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Artikel - Web Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .navbar-brand { font-weight: bold; }
        .admin-section { background-color: #fff3cd; border-left: 5px solid #ffc107; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">MyPortal</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-light me-3">Halo, <strong><?= session()->get('user_nama'); ?></strong> (<?= session()->get('role'); ?>)</span>
                <a class="btn btn-danger btn-sm" href="<?= base_url('user/logout'); ?>">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        
        <?php if (session()->get('role') == 'admin') : ?>
            <div class="alert admin-section shadow-sm d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">Mode Administrator Aktif</h5>
                    <small>Anda memiliki akses penuh untuk mengelola konten.</small>
                </div>
                <a href="<?= base_url('admin/artikel/tambah'); ?>" class="btn btn-success">
                    + Tambah Artikel Baru
                </a>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Daftar Artikel Terbaru</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Judul Artikel</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($artikel) && is_array($artikel)): ?>
                            <?php foreach($artikel as $row): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><strong><?= $row['judul']; ?></strong></td>
                                <td><?= $row['kategori']; ?></td>
                                <td>
                                    <span class="badge <?= $row['status'] == 'terbit' ? 'bg-primary' : 'bg-secondary'; ?>">
                                        <?= $row['status']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if (session()->get('role') == 'admin') : ?>
                                        <a href="<?= base_url('admin/artikel/edit/'.$row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= base_url('admin/artikel/hapus/'.$row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    
                                    <?php else : ?>
                                        <a href="<?= base_url('artikel/detail/'.$row['id']); ?>" class="btn btn-info btn-sm text-white">Baca Selengkapnya</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada artikel yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>