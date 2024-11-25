<?php
include 'koneksi.php';
session_start();  // Start session to store messages

// Proses menambah kendaraan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kendaraan = $_POST['nama_kendaraan'];
    $plat_nomor = $_POST['plat_nomor'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $harga = $jenis_kendaraan == 'mobil' ? 3000 : 2000;

    // Foto Kendaraan - Menyimpan URL gambar
    $foto_kendaraan = $_FILES['foto_kendaraan']['name'];
    $target = "uploads/" . basename($foto_kendaraan);
    move_uploaded_file($_FILES['foto_kendaraan']['tmp_name'], $target);

    // Simpan URL gambar di database
    $foto_url = "http://yourdomain.com/" . $target;

    if (mysqli_query($conn, "INSERT INTO vehicles (nama_kendaraan, plat_nomor, jenis_kendaraan, foto_kendaraan, harga) 
                        VALUES ('$nama_kendaraan', '$plat_nomor', '$jenis_kendaraan', '$foto_url', '$harga')")) {
        $_SESSION['success_message'] = "Kendaraan berhasil ditambahkan!";
    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan, kendaraan gagal ditambahkan!";
    }

    // Redirect ke halaman tambah kendaraan untuk menampilkan notifikasi
    header('Location: tambah_kendaraan.php');
    exit();
}

// Menampilkan data kendaraan dari database
$query = "SELECT * FROM vehicles";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan - E-Parking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('uploads/bgDavinci.jpeg') no-repeat center center fixed; 
            background-size: cover; 
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            margin-top: 60px;
        }
        h1 {
            color: #2d3e50;
            font-weight: 600;
            text-align: center;
            margin-bottom: 40px;
        }
        .form-control, .btn {
            border-radius: 12px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 12px 24px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .vehicle-card {
            background-color: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .vehicle-card:hover {
            transform: translateY(-5px);
        }
        .vehicle-card img {
            border-radius: 12px;
            width: 100%;
            max-width: 250px;
            margin-bottom: 15px;
        }
        .vehicle-card h4 {
            color: #007bff;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .vehicle-card p {
            font-size: 1rem;
            color: #6c757d;
        }
        .vehicle-card .price {
            font-size: 1.2rem;
            color: #28a745;
            font-weight: 600;
        }
        .mt-5 {
            margin-top: 30px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group .input-group-text {
            background-color: #007bff;
            color: white;
        }
        .input-group .form-control {
            border-radius: 12px;
        }

        /* Notification Styles */
        .alert {
            font-size: 1rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Tambah Kendaraan</h1>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php elseif (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Form untuk Tambah Kendaraan -->
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_kendaraan">Nama Kendaraan</label>
            <input type="text" name="nama_kendaraan" id="nama_kendaraan" class="form-control" placeholder="Nama Kendaraan" required>
        </div>
        <div class="form-group">
            <label for="plat_nomor">Plat Nomor</label>
            <input type="text" name="plat_nomor" id="plat_nomor" class="form-control" placeholder="Plat Nomor" required>
        </div>
        <div class="form-group">
            <label for="jenis_kendaraan">Jenis Kendaraan</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-car"></i></span>
                </div>
                <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control" required>
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="foto_kendaraan">Foto Kendaraan</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                </div>
                <input type="file" name="foto_kendaraan" id="foto_kendaraan" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-4">Tambah Kendaraan</button>
    </form>

    <!-- Button Kembali ke Dashboard -->
    <a href="dashboard.php" class="btn btn-secondary btn-block mt-4">Kembali ke Dashboard</a>

    <!-- Menampilkan Kendaraan yang sudah ditambah -->
    <h2 class="mt-5">Daftar Kendaraan</h2>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="vehicle-card">
            <img src="<?php echo $row['foto_kendaraan']; ?>" alt="Foto Kendaraan">
            <h4><?php echo $row['nama_kendaraan']; ?></h4>
            <p>Plat Nomor: <?php echo $row['plat_nomor']; ?></p>
            <p>Jenis Kendaraan: <?php echo ucfirst($row['jenis_kendaraan']); ?></p>
            <p class="price">Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
        </div>
    <?php endwhile; ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
