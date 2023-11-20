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
    <h3>TRANG THÊM SẢN PHẨM</h3>

    <p>Hãy nhập thông tin cần thiết vào form bên dưới</p>
    <form id="luachon_add">
        <label for="chon_them">Hãy chọn loại dữ liệu mà bạn muốn thêm:</label><br>
        <select id="chon_them" onchange="showForm(this.value)">
            <option value="form_sp" selected>Chỉ thêm sản phẩm </option>
            <option value="form_loai">Chỉ thêm loại</option>
            <option value="form_both">Thêm loại lẫn sản phẩm mới</option>
        </select>
    </form>
    <div id="div_1" style="display:none">
        <form id="form_1" action="" method="post">
            <label for="ten_sp">Tên sản phẩm:</label><br>
            <input type="text" id="ten_sp" name="ten_sp" maxlength="255" required><br>
            <label for="type">Loại:</label><br>
            <input type="number" id="type" name="type" min="1" required><br>
            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" min="1" required><br>
            <label for="mota">Mô tả:</label><br>
            <input type="text" id="mota" name="mota" maxlength="255"><br>
            <input type="hidden" name="loai_form" value="add_sp">
            <input type="submit" value="Submit">
        </form>
    </div>

    <div id="div_2" style="display:none">
        <form id="form_2" action="" method="post">
            <label for="ten_loai">Tên loại:</label><br>
            <input type="text" id="ten_loai" name="ten_loai" maxlength="255" required><br>
            <input type="hidden" name="loai_form" value="add_loai">
            <input type="submit" value="Submit">
        </form>
    </div>

    <div id="div_3" style="display:none">
        <form id="form_3" action="" method="post">
            <label for="ten_sp">Tên sản phẩm:</label><br>
            <input type="text" id="ten_sp" name="ten_sp" maxlength="255" required><br>
            <label for="type">Loại:</label><br>
            <input type="number" id="type" name="type" min="1" required><br>
            <label for="ten_loai">Tên loại:</label><br>
            <input type="text" id="ten_loai" name="ten_loai" maxlength="255" required><br>
            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" min="1" required><br>
            <label for="mota">Mô tả:</label><br>
            <input type="text" id="mota" name="mota" maxlength="255"><br>
            <input type="hidden" name="loai_form" value="add_both">
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        function showForm(value) {
            var div_1 = document.getElementById("div_1");
            var div_2 = document.getElementById("div_2");
            var div_3 = document.getElementById("div_3");
            if (value === "form_sp") {
                if (div_1) div_1.style.display = "block";
                if (div_2) div_2.style.display = "none";
                if (div_3) div_3.style.display = "none";
            } else if (value === "form_loai") {
                if (div_1) div_1.style.display = "none";
                if (div_2) div_2.style.display = "block";
                if (div_3) div_3.style.display = "none";
            } else if (value === "form_both") {
                if (div_1) div_1.style.display = "none";
                if (div_2) div_2.style.display = "none";
                if (div_3) div_3.style.display = "block";
            } else {
                if (div_1) div_1.style.display = "none";
                if (div_2) div_2.style.display = "none";
                if (div_3) div_3.style.display = "none";
            }
        }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loaiform = trim($_POST['loai_form']);
        if ($loaiform == 'add_both') {

            $ten_sp = trim($_POST['ten_sp']);
            $type = trim($_POST['type']);
            $ten_loai = trim($_POST['ten_loai']);
            $price = trim($_POST['price']);
            $mota = trim($_POST['mota']);
            if (empty($ten_sp) || strlen($ten_sp) > 255) {
                echo "Tên sản phẩm phải trong giới hạn 0-255 ký tự và không được bỏ trống.<br>";
            }
            if (empty($type)) {
                echo "Loại không được phép bỏ trống.<br>";
            }
            if (empty($ten_loai) || strlen($ten_loai) > 255) {
                echo "Tên loại phải trong giới hạn 0-255 ký tự và không được bỏ trống.<br>";
            }
            if (!is_numeric($price) || $price <= 0) {
                echo "Giá phải là 1 số nguyên và lớn hơn 0.<br>";
            }
        } else if ($loaiform == 'add_sp') {
            $ten_sp = trim($_POST['ten_sp']);
            $type = trim($_POST['type']);
            $ten_loai = NULL;
            $price = trim($_POST['price']);
            $mota = trim($_POST['mota']);
            if (empty($ten_sp) || strlen($ten_sp) > 255) {
                echo "Tên sản phẩm phải trong giới hạn 0-255 ký tự và không được bỏ trống.<br>";
            }
            if (empty($type)) {
                echo "Loại không được phép bỏ trống.<br>";
            }
            if (!is_numeric($price) || $price <= 0) {
                echo "Giá phải là 1 số nguyên và lớn hơn 0.<br>";
            }
        } else {
            $ten_loai = trim($_POST['ten_loai']);
            $ten_sp = NULL;
            $type = NULL;
            $price = NULL;
            $mota = NULL;
            if (empty($ten_loai) || strlen($ten_loai) > 255) {
                echo "Tên loại phải trong giới hạn 0-255 ký tự và không được bỏ trống.<br>";
            }
        }


        themsanpham($ten_sp, $type, $ten_loai, $price, $mota);
    }
    ?>


</div>
<footer> & 0306221391 - PHẠM ANH TUẤN - CDTH22D </footer>
</body>
</html>