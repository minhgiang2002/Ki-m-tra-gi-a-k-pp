<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa thông tin nhân viên</title>
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
    </style>
</head>
<body>

<div class="container">
    <h2>Chỉnh sửa thông tin nhân viên</h2>

    <?php
    // Kiểm tra nếu có mã nhân viên được chuyển đến từ trang danh sách nhân viên
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        // Lấy mã nhân viên từ tham số truyền qua URL
        $id = $_GET['id'];

        // Kết nối đến cơ sở dữ liệu
        include 'db_connect.php';

        // Truy vấn thông tin nhân viên dựa trên mã nhân viên
        $sql = "SELECT * FROM NhanVien WHERE MaNV='$id'";
        $result = $conn->query($sql);

        // Kiểm tra nếu có kết quả trả về từ truy vấn
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="process_edit_employee.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['MaNV']; ?>">

                <label for="TenNV">Tên nhân viên:</label>
                <input type="text" id="TenNV" name="TenNV" value="<?php echo $row['TenNV']; ?>" required>

                <label for="Phai">Phái:</label>
                <select id="Phai" name="Phai" required>
                    <option value="NU" <?php if ($row['Phai'] == 'NU') echo 'selected'; ?>>Nữ</option>
                    <option value="NAM" <?php if ($row['Phai'] == 'NAM') echo 'selected'; ?>>Nam</option>
                </select>

                <label for="NoiSinh">Nơi sinh:</label>
                <input type="text" id="NoiSinh" name="NoiSinh" value="<?php echo $row['NoiSinh']; ?>">

                <label for="MaPhong">Mã phòng:</label>
                <input type="text" id="MaPhong" name="MaPhong" value="<?php echo $row['MaPhong']; ?>" required>

                <label for="Luong">Lương:</label>
                <input type="number" id="Luong" name="Luong" value="<?php echo $row['Luong']; ?>" required>

                <input type="submit" value="Lưu thông tin">
            </form>
        <?php } else {
            echo "Không tìm thấy nhân viên.";
        }

        // Đóng kết nối
        $conn->close();
    } else {
        echo "Không có mã nhân viên được chỉ định.";
    }
    ?>
</div>

</body>
</html>
