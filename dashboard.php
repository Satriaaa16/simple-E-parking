<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Query untuk mengambil data kendaraan dari database
$query = "SELECT * FROM vehicles"; // sesuaikan dengan nama tabel Anda
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Parking</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CDN -->
    <style>
        /* Custom styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: url('uploads/bgDavinci.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
        }

        header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        
        header h1 {
            font-size: 36px;
            font-weight: 700;
        }

        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 16px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            width: 90%;
            max-width: 1200px;
            margin-bottom: 100px;
        }

        h2 {
            color: #007bff;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            max-height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 16px;
            color: #555;
        }

        .sidebar {
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            padding-top: 10px;
        }

        .sidebar .list-group-item {
            background-color: transparent;
            color: white;
            border: none;
        }

        .sidebar .list-group-item:hover {
            background-color: #0056b3;
        }

        .sidebar .list-group-item.active {
            background-color: #0056b3;
        }

        .sidebar .list-group-item i {
            margin-right: 10px;
        }

        .icon-container {
            margin-top: 10px;
            font-size: 24px;
            color: #007bff;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Dashboard E-Parking</h1>
    </header>

    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="tambah_kendaraan.php" class="list-group-item list-group-item-action"><i class="fas fa-car"></i> Tambah Kendaraan</a>
                    <a href="pembayaran.php" class="list-group-item list-group-item-action"><i class="fas fa-credit-card"></i> Pembayaran</a>
                    <a href="daftar.php" class="list-group-item list-group-item-action"><i class="fas fa-user-plus"></i> Tambah User</a>
                    <a href="logout.php" class="list-group-item list-group-item-action"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h2>Daftar Kendaraan</h2>
                <div class="row">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $foto_kendaraan = $row['foto_kendaraan'];
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card">';
                            if (!empty($foto_kendaraan)) {
                                echo '<img src="uploads/' . $foto_kendaraan . '" class="card-img-top" alt="' . $row['nama_kendaraan'] . '">';
                            } else {
                                echo '<img src="uploads/default.jpg" class="card-img-top" alt="Default Image">';
                            }
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row['nama_kendaraan'] . '</h5>';
                            echo '<p class="card-text">Plat Nomor: ' . $row['plat_nomor'] . '</p>';
                            echo '<p class="card-text">ID: ' . $row['id'] . '</p>';

                            // Menampilkan ikon berdasarkan jenis kendaraan
                            echo '<div class="icon-container">';
                            if ($row['jenis_kendaraan'] == 'motor') {
                                echo '<i class="fas fa-motorcycle"></i>'; // Ikon motor
                            } else if ($row['jenis_kendaraan'] == 'mobil') {
                                echo '<i class="fas fa-car"></i>'; // Ikon mobil
                            }
                            echo '</div>';

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='col-12'><div class='alert alert-warning text-center'>Tidak ada data kendaraan.</div></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 E-Parking - All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
