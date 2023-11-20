<?php
function getDanhmuc()
{
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM san_pham");
    $stmt->execute();
    $kq = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    $conn = disconnectDB();
    return $kq;
}
function getLoai()
{
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM loai_san_pham");
    $stmt->execute();
    $kq = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    $conn = disconnectDB();
    return $kq;
}
function getChiTiet($id)
{
    $conn = connectDB();
    $sql = 'SELECT sp.id,sp.ten,sp.loai,l.ten_loai,sp.gia,sp.mo_ta FROM san_pham sp JOIN loai_san_pham l ON sp.loai=l.id where sp.id= :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $kq = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    $conn = disconnectDB();
    return $kq;
}
function getChiTiet2($id, $name)
{
    $name = '%' . $name . '%';
    $conn = connectDB();
    if ($id == null) {
        $sql = 'SELECT sp.id,sp.ten,sp.loai,l.ten_loai,sp.gia,sp.mo_ta FROM san_pham sp JOIN loai_san_pham l ON sp.loai=l.id where sp.ten like :name';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    } else if ($name == null) {
        $sql = 'SELECT sp.id,sp.ten,sp.loai,l.ten_loai,sp.gia,sp.mo_ta FROM san_pham sp JOIN loai_san_pham l ON sp.loai=l.id where sp.id= :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    } else {
        $sql = 'SELECT sp.id,sp.ten,sp.loai,l.ten_loai,sp.gia,sp.mo_ta FROM san_pham sp JOIN loai_san_pham l ON sp.loai=l.id where sp.id= :id and sp.ten like :name';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    }
    $stmt->execute();
    $kq = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    $conn = disconnectDB();
    return $kq;
}

function themsanpham($name, $type, $typename, $price, $mota)
{
    try {
        $conn = connectDB();
        if ($name == null) {
            $sql = "INSERT INTO loai_san_pham (ten_loai) values (:typename)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':typename', $typename, PDO::PARAM_STR);
            $stmt->execute();
            $type = $conn->lastInsertId();
            echo "ID của loại vừa thêm là: " . $type;
        } else if ($typename == null) {
            $sql = "INSERT INTO san_pham (ten,loai,gia,mo_ta) values (:name,:type,:price,:mota)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':price', $price, PDO::PARAM_INT);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $sql1 = "INSERT INTO loai_san_pham (ten_loai) values (:typename)";
            $stmt = $conn->prepare($sql1);
            $stmt->bindValue(':typename', $typename, PDO::PARAM_STR);
            $stmt->execute();
            $type = $conn->lastInsertId();
            echo "ID của loại vừa thêm là: " . $type;
            $sql2 = "INSERT INTO san_pham (ten,loai,gia,mo_ta) values (:name,:type,:price,:mota)";
            $stmt = $conn->prepare($sql2);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':price', $price, PDO::PARAM_INT);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
            $stmt->execute();

        }

        echo "<p>Thêm dữ liệu vào database thành công! vui lòng bấm vào <a href=index.php>đây</a> để kiểm tra! </p>";
    } catch (PDOException $e) {
        echo 'Thêm thất bại. Mã lỗi là: ' . $e->getMessage();
    }
    $conn = disconnectDB();
}
function xoaSanPham($name, $id)
{
    try {
        $conn = connectDB();
        if ($name == null) {
            $sql = "DELETE FROM san_pham WHERE id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } else if ($id == null) {
            $sql = "DELETE FROM san_pham WHERE ten like :name";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $sql = "DELETE FROM san_pham WHERE ten like :name and id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }

        echo "<p>Xóa dữ liệu database thành công! vui lòng bấm vào <a href=index.php>đây</a> để kiểm tra! </p>";
    } catch (PDOException $e) {
        echo 'Xóa thất bại. Mã lỗi là: ' . $e->getMessage();
    }
    $conn = disconnectDB();
}
function xoaLoai($name, $type)
{
    try {
        $conn = connectDB();
        if ($name == null) {
            $sql1 = "DELETE FROM san_pham WHERE loai=:type";
            $stmt = $conn->prepare($sql1);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->execute();
            $sql2 = "DELETE FROM loai_san_pham WHERE id=:type";
            $stmt = $conn->prepare($sql2);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->execute();
        } else if ($type == null) {
            $sql1 = "DELETE sp, l FROM san_pham sp JOIN loai_san_pham l ON sp.loai=l.id WHERE l.ten_loai= :name";
            $stmt = $conn->prepare($sql1);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $sql2 = "DELETE FROM loai_san_pham WHERE ten_loai = :name";
            $stmt = $conn->prepare($sql2);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->execute();

        } else {
            $sql1 = "DELETE sp, l FROM san_pham sp JOIN loai_san_pham l ON sp.loai=l.id WHERE l.id = :type";
            $stmt = $conn->prepare($sql1);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->execute();
            $sql2 = "DELETE FROM loai_san_pham WHERE id=:type";
            $stmt = $conn->prepare($sql2);
            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->execute();
        }
        echo "<p>Xóa dữ liệu database thành công! vui lòng bấm vào <a href=index.php>đây</a> để kiểm tra! </p>";
    } catch (PDOException $e) {
        echo 'Xóa thất bại. Mã lỗi là: ' . $e->getMessage();
    }
    $conn = disconnectDB();
}

function capnhatSanPham($id, $name, $loai, $gia, $mota)
{
    try {
        $conn = connectDB();
        //2^4 = 16 case
        //case no null 1111
        if ($name != null && $loai != null && $gia != null && $mota != null) {
            $sql = "UPDATE san_pham SET ten=:ten,loai=:loai,gia =:gia,mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        //name null 0111
        else if ($name == null && $loai != null && $gia != null && $mota != null) {
            $sql1 = "UPDATE san_pham SET loai=:loai,gia =:gia,mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql1);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        // name va loai null 0011
        else if ($name == null && $loai == null && $gia != null && $mota != null) {
            $sql2 = "UPDATE san_pham SET gia =:gia,mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql2);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        //name, loai va gia null 0001
        else if ($name == null && $loai == null && $gia == null && $mota != null) {
            $sql3 = "UPDATE san_pham SET mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql3);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        //loai null 1011
        else if ($name != null && $loai == null && $gia != null && $mota != null) {
            $sql4 = "UPDATE san_pham SET ten=:ten,gia =:gia,mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql4);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        //loai va gia null 1001
        else if ($name != null && $loai == null && $gia == null && $mota != null) {
            $sql4 = "UPDATE san_pham SET ten=:ten,mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql4);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        //loai, gia va mota null 1000
        else if ($name != null && $loai == null && $gia == null && $mota == null) {
            $sql5 = "UPDATE san_pham SET ten=:ten WHERE id=:id";
            $stmt = $conn->prepare($sql5);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
        }
        //gia null 1101
        else if ($name != null && $loai != null && $gia == null && $mota != null) {
            $sql7 = "UPDATE san_pham SET ten=:ten,loai=:loai,mo_ta=:mota WHERE id=:id";
            $stmt = $conn->prepare($sql7);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
        }
        //gia, mota null 1100
        else if ($name != null && $loai != null && $gia == null && $mota == null) {
            $sql8 = "UPDATE san_pham SET ten=:ten,loai=:loai WHERE id=:id";
            $stmt = $conn->prepare($sql8);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
        }
        //mota null 1110
        else if ($name != null && $loai != null && $gia != null && $mota == null) {
            $sql9 = "UPDATE san_pham SET ten=:ten,loai=:loai,gia=:gia WHERE id=:id";
            $stmt = $conn->prepare($sql9);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
        }
        // loai va mota null 1010
        else if ($name != null && $loai == null && $gia != null && $mota == null) {
            $sql10 = "UPDATE san_pham SET ten=:ten,gia=:gia WHERE id=:id";
            $stmt = $conn->prepare($sql10);
            $stmt->bindValue(':ten', $name, PDO::PARAM_STR);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
        }
        // name va gia null 0101
        else if ($name == null && $loai != null && $gia == null && $mota != null) {
            $sql11 = "UPDATE san_pham SET mo_ta=:mota,loai=:loai WHERE id=:id";
            $stmt = $conn->prepare($sql11);
            $stmt->bindValue(':mota', $mota, PDO::PARAM_STR);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
        }
        //name loai mota null 0010
        else if ($name == null && $loai == null && $gia != null && $mota == null) {
            $sql2 = "UPDATE san_pham SET gia=:gia WHERE id=:id";
            $stmt = $conn->prepare($sql2);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
        }
        //name mota null 0110
        else if ($name == null && $loai != null && $gia != null && $mota == null) {
            $sql3 = "UPDATE san_pham SET loai=:loai, gia=:gia WHERE id=:id";
            $stmt = $conn->prepare($sql3);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_STR);
            $stmt->bindValue(':gia', $gia, PDO::PARAM_INT);
        }
        //nam gia mota null 0100
        else if ($name == null && $loai != null && $gia == null && $mota == null) {
            $sql4 = "UPDATE san_pham SET loai=:loai WHERE id=:id";
            $stmt = $conn->prepare($sql4);
            $stmt->bindValue(':loai', $loai, PDO::PARAM_INT);
        }
        // 4 null 0000
        else if ($name == null && $loai == null && $gia == null && $mota == null) {
            echo 'Không có dữ liệu để cập nhật!';
            exit(0);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<p>Chỉnh sửa dữ liệu database thành công! vui lòng bấm vào <a href=index.php>đây</a> để kiểm tra! </p>";
    } catch (PDOException $e) {
        echo 'Cập nhật dữ liệu thất bại. Mã lỗi là: ' . $e->getMessage();
    }
    $conn = disconnectDB();
}

?>