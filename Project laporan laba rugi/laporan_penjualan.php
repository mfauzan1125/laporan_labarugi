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

$penjualan = [];
$totalHarga = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $date = $_POST['date'];
    
    if ($type == "harian") {
        $sql = "SELECT * FROM pakaian WHERE tanggal = ?";
    } elseif ($type == "bulanan") {
        $sql = "SELECT * FROM pakaian WHERE MONTH(tanggal) = MONTH(?) AND YEAR(tanggal) = YEAR(?)";
    } else {
        $sql = "SELECT * FROM pakaian WHERE YEAR(tanggal) = ?";
    }

    $stmt = $conn->prepare($sql);

    if ($type == "harian") {
        $stmt->bind_param("s", $date);
    } else {
        $stmt->bind_param("ss", $date, $date);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $penjualan[] = $row;
        $totalHarga += $row['harga'];
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-container {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .btn-container .btn {
            font-size: 12px; 
            padding: 5px 10px;
            width: auto;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-container .btn-cetak {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-container .btn-cetak:hover {
            background-color: #414142;
        }
        .btn-container .btn-laba-rugi {
            background-color: #2b2c2d;
            color: white;
            border: none;
        }
        .btn-container .btn-laba-rugi:hover {
            background-color: #218838;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Menyembunyikan elemen form saat print menggunakan JavaScript */
        .hide-on-print {
            display: block;
        }
        .hide-on-print.print-hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Penjualan</h1>

        <form action="" method="post" class="hide-on-print">
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

        <?php if (!empty($penjualan)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pakaian</th>
                        <th>Nama Pakaian</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($penjualan as $row) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['kode']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['jenis']}</td>
                                <td>" . number_format($row['harga'], 2, ',', '.') . "</td>
                                <td>{$row['tanggal']}</td>
                              </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

            <h3>Total : <?php echo number_format($totalHarga, 2, ',', '.'); ?></h3> <!-- Menampilkan total harga -->

            <!-- Tombol Cetak Laporan dan Laporan Laba Rugi -->
            <div class="btn-container">
                <button onclick="window.print()" class="btn btn-cetak">Cetak Laporan</button>
                <a href="laporan_laba_rugi.php" class="btn btn-laba-rugi">Laporan Laba Rugi</a>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div style="color: red;">No data found for the selected period.</div>
        <?php endif; ?>

        <div style="margin-top: 30px; text-align: right; font-size: 14px;">
            Teluk Mega, 07 November 2024
        </div>
    </div>

    <script type="text/javascript">
        // Fungsi untuk menyembunyikan elemen form saat print
        function hideFormOnPrint() {
            document.querySelector('.hide-on-print').classList.add('print-hidden');
        }

        // Fungsi untuk menampilkan elemen form kembali setelah print selesai
        function showFormAfterPrint() {
            document.querySelector('.hide-on-print').classList.remove('print-hidden');
        }

        // Event listener untuk menangani print
        window.onbeforeprint = hideFormOnPrint;
        window.onafterprint = showFormAfterPrint;
    </script>
</body>
</html>

<?php
$conn->close();
?>
