<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}



// Ambil data log aktivitas
$query = "SELECT log_aktivitas.id, users.username, log_aktivitas.aktivitas, log_aktivitas.waktu 
          FROM log_aktivitas 
          JOIN users ON log_aktivitas.user_id = users.id
          ORDER BY log_aktivitas.waktu DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas - E-Parking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            font-weight: 600;
            text-align: center;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }
        .alert-warning {
            background-color: #ffcc00;
            color: black;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Log Aktivitas Pengguna</h1>

    <?php
    // Memeriksa apakah ada log aktivitas
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-striped table-bordered mt-4'>";
        echo "<thead class='thead-dark'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                </tr>
              </thead>
              <tbody>";

        // Menampilkan log aktivitas
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['aktivitas'] . "</td>";
            echo "<td>" . $row['waktu'] . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>Tidak ada aktivitas yang tercatat.</div>";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
