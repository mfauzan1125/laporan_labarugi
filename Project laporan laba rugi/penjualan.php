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

// Query untuk data pakaian
$sqlPakaian = "SELECT kode, nama, jenis, harga, tanggal FROM pakaian";
$resultPakaian = $conn->query($sqlPakaian);

$totalHarga = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $conn->query("DELETE FROM pakaian");
    echo "<div style='color: green; font-weight: bold;'>Semua data pakaian berhasil direset!</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Total Data Pakaian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Total Penjualan</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Pakaian</th>
                    <th>Nama Pakaian</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultPakaian->num_rows > 0) {
                    while ($row = $resultPakaian->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['kode']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['jenis']}</td>
                                <td>" . number_format($row['harga'], 2, ',', '.') . "</td>
                                <td>{$row['tanggal']}</td> <!-- Tampilkan tanggal -->
                              </tr>";
                        $totalHarga += $row['harga'];
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Total Harga: <?php echo number_format($totalHarga, 2, ',', '.'); ?></h3>

        <form action="" method="post" style="margin-top: 20px;">
            <button type="submit" name="reset" class="btn btn-danger">RESET DATA</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="index.php" class="btn btn-secondary">Tambah Belanja Anda</a>
            <br><br>
            <br><br>
            <br><br>
            <br><br>
            <br><br>
            <br><br>
            <a href="pengeluaran.php" class="btn btn-primary">Lihat Data Pengeluaran</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
