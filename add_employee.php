<!DOCTYPE html>
<html>
<head>
    <title>Thêm nhân viên mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select {
            height: 40px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Thêm nhân viên mới</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="MaNV">Mã nhân viên:</label><br>
        <input type="text" id="MaNV" name="MaNV" required><br>
        
        <label for="TenNV">Tên nhân viên:</label><br>
        <input type="text" id="TenNV" name="TenNV" required><br>
        
        <label for="Phai">Phái:</label><br>
        <select id="Phai" name="Phai" required>
            <option value="NU">Nữ</option>
            <option value="NAM">Nam</option>
        </select><br>
        
        <label for="NoiSinh">Nơi sinh:</label><br>
        <input type="text" id="NoiSinh" name="NoiSinh"><br>
        
        <label for="MaPhong">Mã phòng:</label><br>
        <select id="MaPhong" name="MaPhong" required>
            <?php
                // Kết nối đến cơ sở dữ liệu
                $conn = new mysqli("localhost", "root", "", "QL_NHANSU");

                // Kiểm tra kết nối
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Truy vấn các mã phòng từ cơ sở dữ liệu
                $sql = "SELECT MaPhong, TenPhong FROM PhongBan";
                $result = $conn->query($sql);

                // Hiển thị các mã phòng trong một dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["MaPhong"] . "'>" . $row["TenPhong"] . "</option>";
                    }
                }

                // Đóng kết nối
                $conn->close();
            ?>
        </select><br>
        
        <label for="Luong">Lương:</label><br>
        <input type="number" id="Luong" name="Luong" min="0" required><br>
        
        <input type="submit" value="Thêm nhân viên">
    </form>

    <?php
    // Kiểm tra xem dữ liệu đã được gửi từ biểu mẫu hay chưa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $MaNV = $_POST["MaNV"];
        $TenNV = $_POST["TenNV"];
        $Phai = $_POST["Phai"];
        $NoiSinh = $_POST["NoiSinh"];
        $MaPhong = $_POST["MaPhong"];
        $Luong = $_POST["Luong"];

        // Kết nối đến cơ sở dữ liệu
        $conn = new mysqli("localhost", "root", "", "QL_NHANSU");

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Tạo câu lệnh SQL để thêm nhân viên mới vào cơ sở dữ liệu
        $sql = "INSERT INTO NhanVien (MaNV, TenNV, Phai, NoiSinh, MaPhong, Luong) VALUES ('$MaNV', '$TenNV', '$Phai', '$NoiSinh', '$MaPhong', $Luong)";

        // Thực thi câu lệnh SQL và kiểm tra kết quả
        if ($conn->query($sql) === TRUE) {
            echo "<div class='message'>Thêm nhân viên thành công</div>";
        } else {
            echo "<div class='message'>Lỗi: " . $sql . "<br>" . $conn->error . "</div>";
        }

        // Đóng kết nối
        $conn->close();
    }
    ?>
</div>

</body>
</html>
