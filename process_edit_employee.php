<?php
// Kiểm tra nếu có dữ liệu được gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các trường có được gửi không và không trống
    if (isset($_POST['id']) && isset($_POST['TenNV']) && isset($_POST['Phai']) && isset($_POST['NoiSinh']) && isset($_POST['MaPhong']) && isset($_POST['Luong'])) {
        // Lấy dữ liệu từ form
        $id = $_POST['id'];
        $tenNV = $_POST['TenNV'];
        $phai = $_POST['Phai'];
        $noiSinh = $_POST['NoiSinh'];
        $maPhong = $_POST['MaPhong'];
        $luong = $_POST['Luong'];

        // Kết nối đến cơ sở dữ liệu
        include 'db_connect.php';

        // Cập nhật thông tin nhân viên trong cơ sở dữ liệu
        $sql = "UPDATE NhanVien SET TenNV='$tenNV', Phai='$phai', NoiSinh='$noiSinh', MaPhong='$maPhong', Luong='$luong' WHERE MaNV='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật thông tin nhân viên thành công.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }

        // Đóng kết nối
        $conn->close();
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
} else {
    // Nếu không phải là phương thức POST, chuyển hướng về trang chính
    header("Location: index.php");
    exit();
}
?>
