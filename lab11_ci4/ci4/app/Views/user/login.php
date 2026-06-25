<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Warna background abu-abu muda */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-login {
            background-color: #a0a0a0; /* Menyesuaikan warna tombol di gambar */
            color: white;
            border: none;
        }
        .btn-login:hover {
            background-color: #808080;
            color: white;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2 class="mb-4 fw-bold" style="color: #444;">Sign In</h2>
        
        <form action="<?= base_url('user/login') ?>" method="post">
            <?= csrf_field() ?> <div class="mb-3 text-start">
                <label for="email" class="form-label text-muted">Email address</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            
            <div class="mb-4 text-start">
                <label for="password" class="form-label text-muted">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            
            <div class="text-start">
                <button type="submit" class="btn btn-login px-4">Login</button>
            </div>
        </form>
    </div>

</body>
</html>