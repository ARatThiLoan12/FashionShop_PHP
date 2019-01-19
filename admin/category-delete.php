<?php
    require_once '../model/connect.php';
    //Xóa danh mục theo Id
    if (isset($_GET['idCate']))
    {
        $idCate = $_GET['idCate'];
        $sql = "DELETE FROM categories WHERE id = " . $idCate;
        $result = mysqli_query($conn,$sql);

        if ($result)
        {
            header("location:category-list.php?cs=success");
        }else
        {
            header("location:category-list.php?cf=fail");
        }
    }
?>