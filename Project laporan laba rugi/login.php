<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db = 'pakaian';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if ($password == $user['password']) {
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container" style="background-color: rgba(255, 255, 255, 0.773); border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); padding: 20px; width: 500px; box-sizing: border-box;">
        <div style="display: flex; align-items: center;">
            <img src="logoitr.png" alt="Logo" style="max-width: 160px; height: auto; margin-right: 9px;">
            <div style="flex: 1;">
                <h1>Institut Teknologi Rokan Hilir</h1>
                <p>kampusnya orang sukses</p>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            </div>
        </div>
        <form method="POST" action="" style="display: flex; flex-direction: column; margin-top: 8px;">
            <div style="margin-bottom: 10px;">
                <label for="username">Username:</label>
                <input type="text" name="username" required style="width: 100%; padding: 12px; border: 2px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="password">Password:</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 2px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="width: 100%; padding: 12px; background-color: #2575fc; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; font-weight: bold;">Login</button>
        </form>
        <div style="margin-top: 30px; text-align: right; font-size: 13px; font-family: poppins;">
            M.Fauzan
        </div>
    </div>
</body>
</html>

