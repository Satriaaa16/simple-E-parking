<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Memeriksa apakah form plat nomor telah disubmit
if (isset($_POST['submit'])) {
    $plat_nomor = $_POST['plat_nomor'];

    // Query untuk mengambil data kendaraan berdasarkan plat nomor
    $query = "SELECT * FROM vehicles WHERE plat_nomor = '$plat_nomor'";
    $result = mysqli_query($conn, $query);

    // Memeriksa apakah data kendaraan ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Kendaraan dengan plat nomor $plat_nomor tidak ditemukan.";
    }
}

// Proses pembayaran dan hapus data kendaraan
if (isset($_POST['bayar'])) {
    $plat_nomor_to_delete = $_POST['plat_nomor'];

    // Query untuk menghapus kendaraan berdasarkan plat nomor
    $delete_query = "DELETE FROM vehicles WHERE plat_nomor = '$plat_nomor_to_delete'";
    if (mysqli_query($conn, $delete_query)) {
        $success_message = "Pembayaran berhasil. Kendaraan dengan plat nomor $plat_nomor_to_delete telah dihapus.";
    } else {
        $error_message = "Terjadi kesalahan saat menghapus data kendaraan.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - E-Parking</title>
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
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-top: 60px;
        }
        h1 {
            color: #007bff;
            font-weight: 600;
            text-align: center;
        }
        .alert {
            font-weight: 600;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            width: 100%;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .form-control, .btn {
            border-radius: 12px;
        }
        .table th, .table td {
            text-align: center;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .vehicle-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        .vehicle-card img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pembayaran Kendaraan</h1>

        <form method="POST" action="pembayaran.php" class="mt-4">
            <div class="form-group">
                <label for="plat_nomor"><i class="fas fa-car"></i> Plat Nomor Kendaraan</label>
                <input type="text" name="plat_nomor" id="plat_nomor" class="form-control" placeholder="Masukkan Plat Nomor" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Cari Kendaraan</button>
        </form>

        <?php if (isset($error_message)) { ?>
            <div class="alert alert-warning mt-4"><?php echo $error_message; ?></div>
        <?php } ?>

        <?php if (isset($row)) { ?>
            <div class="vehicle-card mt-4">
                <h4><i class="fas fa-info-circle"></i> Detail Kendaraan</h4>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <td><?php echo $row['id']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama Kendaraan</th>
                        <td><?php echo $row['nama_kendaraan']; ?></td>
                    </tr>
                    <tr>
                        <th>Plat Nomor</th>
                        <td><?php echo $row['plat_nomor']; ?></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td><?php echo "Rp " . number_format($row['harga'], 0, ',', '.'); ?></td>
                    </tr>
                </table>
                
                <!-- Form untuk bayar -->
                <form method="POST" action="pembayaran.php">
                    <input type="hidden" name="plat_nomor" value="<?php echo $row['plat_nomor']; ?>">
                    <button type="submit" name="bayar" class="btn btn-custom"><i class="fas fa-credit-card"></i> Bayar & Hapus Data</button>
                </form>
            </div>
        <?php } ?>

        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success mt-4"><?php echo $success_message; ?></div>
            <a href="dashboard.php" class="btn btn-secondary btn-block mt-4"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
