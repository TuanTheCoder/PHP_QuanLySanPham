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
        <h3>DANH MỤC SẢN PHẨM</h3>
        <table>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
            <?php
            $getAll = getDanhmuc();
            if (isset($getAll) && (count($getAll) > 0)) {
                $i = 1;
                foreach ($getAll as $dm) {
                    echo '<tr>
                        <td>' . $i . '</td>
                        <td>' . $dm['id'] . '</td>
                        <td><a href=details.php?id=' . $dm['id'] . '>' . $dm['ten'] . '</a> </td>
                        <td>' . $dm['loai'] . '</td>
                        <td>' . $dm['gia'] . '</td>
                        <td>' . $dm['mo_ta'] . '</td>
                        <td><a href=edit.php?id=' . $dm['id'] . '>Sửa</a> | <a href=delete.php?id=' . $dm['id'] . '>Xóa</a></td>
                    </tr>';
                    $i++;
                }
            } ?>
        </table>
        <br>
        <h3>DANH MỤC LOẠI SẢN PHẨM</h3>
        <table>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Tên loại</th>
            </tr>
            <?PHP
            $getLoai = getLoai();
            if (isset($getLoai) && (count($getLoai) > 0)) {
                $i = 1;
                foreach ($getLoai as $type) {
                    echo '<tr>
                        <td>' . $i . '</td>
                        <td>' . $type['id'] . '</td>
                        <td>' . $type['ten_loai'] . '</td>
                    </tr>';
                    $i++;
                }
            }
            ?>

        </table>
    </div>
    <footer> & 0306221391 - PHẠM ANH TUẤN - CDTH22D </footer>
</body>

</html>