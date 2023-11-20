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
        <h3>TRA CỨU CHI TIẾT SẢN PHẨM</h3>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $getDetail = getChiTiet($id);
            if (isset($getDetail) && (count($getDetail) > 0)) {
                $i = 1;
                echo '
        <table>
        <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Loại</th>
            <th>Tên loại</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>';
                foreach ($getDetail as $dm) {
                    echo '<tr>
                    <td>' . $i . '</td>
                    <td>' . $dm['id'] . '</td>
                    <td>' . $dm['ten'] . '</td>
                    <td>' . $dm['loai'] . '</td>
                    <td>' . $dm['ten_loai'] . '</td>
                    <td>' . $dm['gia'] . '</td>
                    <td>' . $dm['mo_ta'] . '</td>
                    <td><a href=edit.php?id='. $dm['id'].'>Sửa</a> | <a href=delete.php?id=' . $dm['id'] . '>Xóa</a></td>
                </tr>';
                    $i++;
                }
            } else if (count($getDetail) == 0) {
                echo '<p>ID sản phẩm tra cứu không tồn tại, vui lòng bấm vào <a href=details.php>đây</a> để quay lại trang tra cứu chi tiết!</p>';
            }


        } else {
            echo '<p>Hãy nhập thông tin sản phẩm cần tra cứu bằng tên hoặc id</p>';

            echo ' <form action="" method="post">
        <label for="ten_dm">Tên sản phẩm:</label><br>
        <input type="text" name="ten_dm" id="tendm" maxlength="255">
        <label for="id_dm">ID sản phẩm:</label><br>
        <input type="number" name="id_dm" id="id_dm">
        <input type="submit" name="tracuu" value="Tra cứu">
    </form>';
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id_dm'];
            $name = $_POST['ten_dm'];
            if ($id == null && $name == null){
                echo '<p>Vui lòng nhập dữ liệu để tiến hành tra cứu!</p>';
                if (empty($name) || strlen($name) > 255) {
                    echo "Tên sản phẩm phải trong giới hạn 0-255 ký tự và không được bỏ trống.<br>";
                }
                if (!is_numeric($id) || $id <= 0) {
                    echo "ID phải là 1 số nguyên và lớn hơn 0.<br>";
                }
            }
            else{
            $getDetail = getChiTiet2($id, $name);
            if (isset($getDetail) && (count($getDetail) > 0)) {
                $i = 1;
                echo ' <br>
        <table>
        <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Loại</th>
            <th>Tên loại</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>';
                foreach ($getDetail as $dm) {
                    echo '<tr>
                    <td>' . $i . '</td>
                    <td>' . $dm['id'] . '</td>
                    <td>' . $dm['ten'] . '</td>
                    <td>' . $dm['loai'] . '</td>
                    <td>' . $dm['ten_loai'] . '</td>
                    <td>' . $dm['gia'] . '</td>
                    <td>' . $dm['mo_ta'] . '</td>
                    <td><a href=edit.php?id='. $dm['id'].'>Sửa</a> | <a href=delete.php?id=' . $dm['id'] . '>Xóa</a></td>
                </tr>';
                    $i++;
                }
                echo '</table>';
            } else if (count($getDetail) == 0) {
                echo '<p>ID sản phẩm tra cứu không tồn tại, vui lòng bấm vào <a href=details.php>đây</a> để quay lại trang tra cứu chi tiết!</p>';
            }
        }
    }

        ?>

        </table>
    </div>
    <footer> & 0306221391 - PHẠM ANH TUẤN - CDTH22D </footer>
</body>

</html>