<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pakaian";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk data pengeluaran
$sqlPengeluaran = "SELECT * FROM pengeluaran";
$resultPengeluaran = $conn->query($sqlPengeluaran);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengeluaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Data Pengeluaran</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Pengeluaran</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultPengeluaran->num_rows > 0) {
                    while ($row = $resultPengeluaran->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['jenis_pengeluaran']}</td>
                                <td>" . number_format($row['jumlah'], 2, ',', '.') . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
            <a href="laporan_penjualan.php" class="btn btn-primary" style="margin-left: 10px;">Laporan Penjualan</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
