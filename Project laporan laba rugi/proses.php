<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pakaian";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$jenis = $_POST['jenis'];
$harga = $_POST['harga'];

// Insert data ke database
$sql = "INSERT INTO pakaian (kode_pakaian, nama_pakaian, jenis, harga) VALUES ('$kode', '$nama', '$jenis', '$harga')";

if ($conn->query($sql) === TRUE) {
    header("Location: penjualan.php");
    exit();
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>