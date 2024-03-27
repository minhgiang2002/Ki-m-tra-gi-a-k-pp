<?php
session_start();
include 'db_connect.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
        header("Location: index.php"); // Chuyển hướng đến trang chính sau khi đăng nhập thành công
        exit();
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không chính xác.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Đăng nhập</h2>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Đăng nhập">
        </form>
    </div>
</body>
</html>
