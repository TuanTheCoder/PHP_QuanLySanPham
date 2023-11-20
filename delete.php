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

<body onload="confirmDelete_onLoad()">
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
        <h3>TRANG XÓA SẢN PHẨM</h3>

        <p>Hãy nhập thông tin cần thiết vào form bên dưới</p>
        <form id="luachon_add">
            <label for="chon_them">Hãy chọn loại dữ liệu mà bạn muốn xóa:</label><br>
            <select id="chon_them" onchange="showForm(this.value)">
                <option value="form_sp" selected>Xóa sản phẩm </option>
                <option value="form_loai">Xóa loại</option>
            </select>
        </form>
        <div id="div_1" style="display:none">
            <form id="form_1" action="" method="post">
                <label for="ten_sp">Tên sản phẩm:</label><br>
                <input type="text" id="ten_sp" name="ten_sp" maxlength="255"><br>
                <label for="id_sp">ID sản phẩm:</label><br>
                <input type="number" name="id_sp" id="id_sp">
                <input type="hidden" name="loai_form" value="xoa_sp">
                <input type="submit" onclick="return confirmDelete()" value="Submit">
            </form>
        </div>

        <div id="div_2" style="display:none">
            <form id="form_2" action="" method="post">
                <label for="ten_loai">Tên loại:</label><br>
                <input type="text" id="ten_loai" name="ten_loai" maxlength="255"><br>
                <label for="type">ID loại:</label><br>
                <input type="number" name="type" id="type">
                <input type="hidden" name="loai_form" value="xoa_loai">
                <input type="submit" onclick="return confirmDelete()" value="Submit">
            </form>
        </div>
        <script>
            function confirmDelete() {
                var xacnhan = confirm("Bạn có chắc muốn xóa sản phẩm này?");
                if (xacnhan == true) {
                    return true;
                } else {
                    return false;
                }
            }

        </script>
        <script>
            function showForm(value) {
                var div_1 = document.getElementById("div_1");
                var div_2 = document.getElementById("div_2");
                if (value === "form_sp") {
                    if (div_1) div_1.style.display = "block";
                    if (div_2) div_2.style.display = "none";
                } else if (value === "form_loai") {
                    if (div_1) div_1.style.display = "none";
                    if (div_2) div_2.style.display = "block";
                }
                else {
                    if (div_1) div_1.style.display = "none";
                    if (div_2) div_2.style.display = "none";
                }
            }
        </script>
        <?php
        if (isset($_GET['id']) && !isset($_GET['confirm'])) {
            $id = $_GET['id'];
            $getDetail = getChiTiet($id);
            if (isset($getDetail) && (count($getDetail) < 1)) {
                echo '<p>ID sản phẩm trong URL không tồn tại, vui lòng bấm vào <a href=details.php>đây</a> để quay lại trang tra cứu chi tiết!</p>';
            } else {
                echo '
        <script>
            function confirmDelete_onLoad() {
                var xacnhan = confirm("Bạn có chắc muốn xóa sản phẩm này?");
                if (xacnhan == true) {
                    window.location.href ="delete.php?confirm=1&id=' . $id . '";
                } else {
                    window.location.href ="details.php?id=' . $id . '";
                }
            }
        </script>';
            }
        }
        if (isset($_GET['id']) && isset($_GET['confirm'])) {
            $id = $_GET['id'];
            $name = "";
            $getDetail = getChiTiet($id);
            if (isset($getDetail) && (count($getDetail) < 1)) {
                echo '<p>ID sản phẩm trong URL không tồn tại, vui lòng bấm vào <a href=details.php>đây</a> để quay lại trang tra cứu chi tiết!</p>';
            } else {
                xoaSanPham($name, $id);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $loaiform = trim($_POST['loai_form']);
            if ($loaiform == 'xoa_sp') {
                $tensp = trim($_POST['ten_sp']);
                $id = trim($_POST['id_sp']);
                xoaSanPham($tensp, $id);
            } else if ($loaiform == 'xoa_loai') {
                $tenloai = trim($_POST['ten_loai']);
                $type = trim($_POST['type']);
                xoaLoai($tenloai, $type);
            }

        }
        ?>

    </div>
    <footer> & 0306221391 - PHẠM ANH TUẤN - CDTH22D </footer>
</body>

</html>