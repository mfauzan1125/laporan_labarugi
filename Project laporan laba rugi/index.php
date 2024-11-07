<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pakaian";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];

    // Menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO pakaian (kode, nama, jenis, harga, tanggal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $kode, $nama, $jenis, $harga, $tanggal);

    if ($stmt->execute()) {
        $successMessage = "Data berhasil disimpan!";
    } else {
        echo "<div style='color: red;'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Ambil data
$sql = "SELECT * FROM pakaian";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pakaian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>DATA PAKAIAN</h1>
        
        <?php if ($successMessage): ?>
            <div style="color: green; font-weight: bold; margin-top: 10px;">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="kode">Kode Pakaian:</label>
                <input type="text" id="kode" name="kode" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama Pakaian:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="jenis">Jenis:</label>
                <select id="jenis" name="jenis" class="form-control" required>
                    <option value="baju">BAJU</option>
                    <option value="celana">CELANA</option>
                    <option value="aksesoris">AKSESORIS</option>
                </select>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">SAVE</button>
        </form>

        <br><br>
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
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['kode']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['jenis']}</td>
                                <td>" . number_format($row['harga'], 2, ',', '.') . "</td>
                                <td>{$row['tanggal']}</td> <!-- Tampilkan tanggal -->
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a href="penjualan.php" class="btn btn-secondary">Tampilkan Total Belanja</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
