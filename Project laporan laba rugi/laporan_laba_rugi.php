<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pakaian";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$totalPendapatan = 0;
$totalPengeluaran = 0;
$laba = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $date = $_POST['date'];
    
    if ($type == "harian") {
        $sqlPendapatan = "SELECT SUM(harga) AS total_pendapatan FROM pakaian WHERE tanggal = ?";
        $sqlPengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE tanggal = ?";
    } elseif ($type == "bulanan") {
        $sqlPendapatan = "SELECT SUM(harga) AS total_pendapatan FROM pakaian WHERE MONTH(tanggal) = MONTH(?) AND YEAR(tanggal) = YEAR(?)";
        $sqlPengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE MONTH(tanggal) = MONTH(?) AND YEAR(tanggal) = YEAR(?)";
    } else {
        $sqlPendapatan = "SELECT SUM(harga) AS total_pendapatan FROM pakaian WHERE YEAR(tanggal) = ?";
        $sqlPengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE YEAR(tanggal) = ?";
    }

    // Total Pendapatan
    $stmtPendapatan = $conn->prepare($sqlPendapatan);
    if ($type == "harian") {
        $stmtPendapatan->bind_param("s", $date);
    } else {
        $stmtPendapatan->bind_param("ss", $date, $date);
    }
    $stmtPendapatan->execute();
    $resultPendapatan = $stmtPendapatan->get_result();

    if ($resultPendapatan->num_rows > 0) {
        $row = $resultPendapatan->fetch_assoc();
        $totalPendapatan = $row['total_pendapatan'] ?: 0;
    }

    // Total Pengeluaran
    $stmtPengeluaran = $conn->prepare($sqlPengeluaran);
    if ($type == "harian") {
        $stmtPengeluaran->bind_param("s", $date);
    } else {
        $stmtPengeluaran->bind_param("ss", $date, $date);
    }
    $stmtPengeluaran->execute();
    $resultPengeluaran = $stmtPengeluaran->get_result();

    if ($resultPengeluaran->num_rows > 0) {
        $row = $resultPengeluaran->fetch_assoc();
        $totalPengeluaran = $row['total_pengeluaran'] ?: 0;
    }

    // Hitung Laba
    $laba = $totalPendapatan - $totalPengeluaran;

    $stmtPendapatan->close();
    $stmtPengeluaran->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba Rugi</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Fungsi untuk mencetak halaman
        function printLaporan() {
            window.print();
        }

        // Fungsi untuk menyembunyikan elemen form saat print
        function hideFormOnPrint() {
            document.querySelector('.form-container').classList.add('print-hidden');
        }

        // Fungsi untuk menampilkan form setelah print selesai
        function showFormAfterPrint() {
            document.querySelector('.form-container').classList.remove('print-hidden');
        }

        // Menangani event sebelum dan sesudah print
        window.onbeforeprint = hideFormOnPrint;
        window.onafterprint = showFormAfterPrint;
    </script>
    <style>
        /* Tombol Cetak */
        .btn-cetak {
            font-size: 10px;  /* Ukuran font lebih kecil */
            padding: 4px 8px; /* Padding lebih kecil */
            background-color: #007bff; /* Warna biru */
            color: white; /* Warna teks putih */
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cetak:hover {
            background-color: #0056b3; /* Warna saat hover */
        }

        /* Tombol Kembali */
        .btn-kembali {
            font-size: 12px; /* Ukuran font lebih kecil */
            padding: 5px 10px; /* Padding tombol */
            background-color: #6c757d; /* Warna abu-abu */
            color: white; /* Warna teks putih */
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-kembali:hover {
            background-color: #5a6268; /* Warna saat hover */
        }

        /* Container untuk tombol */
        .btn-container {
            display: flex;
            justify-content: flex-end; /* Tombol berada di kanan */
            gap: 10px; /* Jarak antar tombol */
            margin-top: 20px; /* Jarak atas */
            max-width: 300px; /* Maksimum lebar container tombol */
            width: 100%; /* Menggunakan seluruh lebar layar */
        }

        /* Menyembunyikan form saat print */
        .print-hidden {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Laba Rugi</h1>

        <form action="" method="post" class="form-container">
            <div class="form-group">
                <label for="type">Pilih Tipe Laporan:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="harian">Harian</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Pilih Tanggal:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
        </form>

        <br>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="3">Laporan Laba Rugi untuk Tanggal: <?php echo date('d-m-Y', strtotime($date)); ?></th>
                    </tr>
                    <tr>
                        <th>Total Pendapatan</th>
                        <th>Total Pengeluaran</th>
                        <th>Laba</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo number_format($totalPendapatan, 2, ',', '.'); ?></td>
                        <td><?php echo number_format($totalPengeluaran, 2, ',', '.'); ?></td>
                        <td><?php echo number_format($laba, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="btn-container">
                <button onclick="printLaporan()" class="btn-cetak">Cetak Laporan</button>
                <a href="index.php" class="btn-kembali">Kembali</a>
            </div>
        <?php endif; ?>

        <div style="margin-top: 30px; text-align: right; font-size: 14px;">
            Teluk Mega, 07 November 2024
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
