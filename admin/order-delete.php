<?php
    require_once("../model/connect.php");

    // Xóa từng sản phẩm trang order detail theo id orders và id products
    if (isset($_GET['idOrderDetail']))
    {
        $idOrder = $_GET['idOrderDetail'];
        if (isset($_GET['idProduct']))
        {
            $idProduct = $_GET['idProduct'];

            if (isset($_GET['idStatus']))
            {
                $idStatus = $_GET['idStatus'];
                if ($idStatus == 1)
                {
?>
                    <script type="text/javascript">
                        window.location = 'order-detail.php?idOrderDetail=<?php echo $idOrder; ?>&notDeletes=fail';
                    </script>
            <?php
                } else {
                    $deleteOrder = "DELETE FROM product_order WHERE product_id = $idProduct AND order_id = $idOrder";
                    $resOrder = mysqli_query($conn,$deleteOrder);
                }
            ?>
                <script type="text/javascript">
                    window.location = 'order-detail.php?idOrderDetail=<?php echo $idOrder; ?>';
                </script>
<?php
            }
        }
    }

    //Xóa đơn hàng chưa được chuyển (status = 0)
    if (isset($_GET['deleteAllIdOrderSame']))
    {
        $idOrderSame = $_GET['deleteAllIdOrderSame'];
        if (isset($_GET['statusOrder']))
        {
            $statusOrder = $_GET['statusOrder'];
            if ($statusOrder == 1)
            {
                header("location:order-list.php?notDeletes=fail");
                exit();

            } else {

                $deleteOrderSame = "DELETE FROM product_order WHERE order_id = $idOrderSame";
                $resDelete = mysqli_query($conn,$deleteOrderSame);

                header("location:order-list.php?deleteSuccess=success");
                exit();
            }
        ?>
<?php
        }
    }
?>