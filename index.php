<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';
$limit = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $limit;
$sql = "SELECT NhanVien.MaNV, NhanVien.TenNV, NhanVien.Phai, NhanVien.NoiSinh, PhongBan.TenPhong, NhanVien.Luong FROM NhanVien INNER JOIN PhongBan ON NhanVien.MaPhong = PhongBan.MaPhong LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <link rel="stylesheet" href="site.css">
</head>
<body>
    <div class="header">
        <?php if(isset($_SESSION["username"])): ?>
            <p>Xin chào, <?php echo $_SESSION["username"]; ?>!</p>
            <a href="logout.php">Đăng xuất</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1 class="info">THÔNG TIN NHÂN VIÊN </h1>
        <a href="add_employee.php" class="add-button">Thêm nhân viên</a>
        <table border='1'>
            <tr class="first-column">
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Giới Tính</th>
                <th>Nơi Sinh</th>
                <th>Tên Phòng</th>
                <th>Lương</th>
                <?php if ($_SESSION["role"] == "admin"): ?> 
                <th>Action</th>
               
                        <?php endif; ?>
            </tr>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row["MaNV"]; ?></td>
                        <td><?php echo $row["TenNV"]; ?></td>
                        <td><img class="avatar" src="<?php echo ($row["Phai"] == 'NU') ? 'Image/Woman.jpg' : 'Image/Man.PNG'; ?>" alt="<?php echo ($row["Phai"] == 'NU') ? 'Woman' : 'Man'; ?>"></td>
                        <td><?php echo $row["NoiSinh"]; ?></td>
                        <td><?php echo $row["TenPhong"]; ?></td>
                        <td class="red"><?php echo $row["Luong"]; ?></td>
                        <?php if ($_SESSION["role"] == "admin"): ?> 
                            <td>
                                <div class="edit-delete-wrapper">
                                <a href="edit_employee.php?id=<?php echo $row['MaNV']; ?>"><img src="Image/but.png" alt="Sửa" width="60" height="60"></a>
                                 <a href="delete_employee.php?id=<?php echo $row['MaNV']; ?>"><img src="Image/dele.png" alt="Xoá" width="60" height="60"></a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan='6'>Không có nhân viên nào</td></tr>
            <?php endif; ?>
        </table>

        <div class="pagination">
            <?php
            // Tính tổng số trang
            $sql_count = "SELECT COUNT(*) AS total FROM NhanVien";
            $result_count = mysqli_query($conn, $sql_count);
            $row_count = mysqli_fetch_assoc($result_count);
            $total_pages = ceil($row_count["total"] / $limit);

            // Hiển thị các liên kết phân trang
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='?page=$i'>$i</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
