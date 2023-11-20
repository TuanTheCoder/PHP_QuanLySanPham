<?php
include "dbconnect.php";
include "function.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ SẢN PHẨM</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


<header>
    <h2>TRANG QUẢN LÝ SẢN PHẨM</h2>
    <nav>
        <a href=index.php>Trang chủ</a> |
        <a href=details.php>Tra cứu chi tiết</a> |
        <a href=add.php>Thêm sản phẩm</a> |
        <a href=delete.php>Xóa sản phẩm</a>
    </nav>
</header>

<div class="main">
    <h3>TRANG CẬP NHẬT THÔNG TIN SẢN PHẨM</h3>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $getDetail = getChiTiet($id);
        if (isset($getDetail) && (count($getDetail) < 1)) {
            echo '<p>ID sản phẩm trong URL không tồn tại, vui lòng bấm vào <a href=index.php>đây</a> để quay lại trang chủ!</p>';
        } else {
            echo ' <form id="form_1" action="" method="post">
                    <label for="ten_sp">Tên sản phẩm:</label><br>
                    <input type="text" id="ten_sp" name="ten_sp" maxlength="255"><br>
                    <label for="type">Loại:</label><br>
                    <input type="number" id="type" name="type" min="1" ><br>
                    <label for="price">Giá:</label><br>
                    <input type="number" id="price" name="price" min="1" ><br>
                    <label for="mota">Mô tả:</label><br>
                    <input type="text" id="mota" name="mota" maxlength="255"><br>
                    <input type="submit" value="Submit">
                    </form>
                    ';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = trim($_POST['ten_sp']);
                $type = trim($_POST['type']);
                $price = trim($_POST['price']);
                $mota = trim($_POST['mota']);
                if (empty($name) || strlen($name) > 255) {
                    echo "Tên sản phẩm phải trong giới hạn 0-255 ký tự và không được bỏ trống.<br>";
                }
                if (empty($type)) {
                    echo "Loại không được phép bỏ trống.<br>";
                }
                if (!is_numeric($price) || $price <= 0) {
                    echo "Giá phải là 1 số nguyên và lớn hơn 0.<br>";
                }
                capnhatSanPham($id, $name, $type, $price, $mota);
            }
        }
    } else {
        echo '<p> Để tiến hành cập nhật dữ liệu cần có ID trong URL, vui lòng bấm vào <a href=index.php>đây</a> để quay lại trang chủ!</p>';
    }

    ?>




</div>
<footer> & 0306221391 - PHẠM ANH TUẤN - CDTH22D </footer>
</body>
</html>