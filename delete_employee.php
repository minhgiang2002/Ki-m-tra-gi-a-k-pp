<?php
include 'db_connect.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Xử lý yêu cầu xóa nhân viên
    $id = $_GET['id'];

    // Thực hiện câu lệnh SQL để xóa nhân viên từ cơ sở dữ liệu
    $sql = "DELETE FROM NhanVien WHERE MaNV='$id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Chuyển hướng về trang danh sách nhân viên sau khi xóa thành công
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
