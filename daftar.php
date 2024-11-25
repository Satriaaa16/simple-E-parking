<?php
include 'koneksi.php';

$successMessage = ''; // Variabel untuk menampilkan pesan sukses
$errorMessage = ''; // Variabel untuk menampilkan pesan error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah ada di database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Username sudah terdaftar
        $errorMessage = 'Akun dengan username ini sudah terdaftar. Silakan login.';
    } else {
        // Jika username belum terdaftar, lakukan pendaftaran
        $passwordHash = password_hash($password, PASSWORD_BCRYPT); // Enkripsi password

        // Query untuk memasukkan data pengguna baru ke database
        if (mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')")) {
            $successMessage = 'Akun berhasil didaftarkan! Silakan login.';
        } else {
            $errorMessage = 'Terjadi kesalahan saat pendaftaran.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
       body {
            font-family: 'Roboto', sans-serif;
            background: url('uploads/bgDavinci.jpeg') no-repeat center center fixed; /* Ganti 'your-wallpaper.jpg' dengan nama file wallpaper Anda */
            background-size: cover; /* Agar gambar memenuhi layar */
            height: 100vh;
            margin: 0;
        }
        
    
        .container {
            max-width: 450px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #1d63c2;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control, .btn {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #1d63c2;
            border: none;
            padding: 14px;
            font-size: 16px;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
        }
        .form-text {
            font-size: 14px;
            color: #888;
            text-align: center;
        }
        .form-text a {
            color: #1d63c2;
            text-decoration: none;
        }
        .alert-success {
            color: #fff;
            background-color: #28a745;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-danger {
            color: #fff;
            background-color: #dc3545;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Pengguna Baru</h2>

    <!-- Menampilkan pesan sukses jika ada -->
    <?php if ($successMessage): ?>
        <div class="alert-success"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <!-- Menampilkan pesan error jika ada -->
    <?php if ($errorMessage): ?>
        <div class="alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
    <p class="form-text">Sudah punya akun? <a href="index.php">Masuk di sini</a></p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
