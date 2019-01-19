<?php
    require_once("../model/connect.php");
    include 'header.php';
    error_reporting(2);

    if (isset($_GET['notDeletes'])) {
        echo "<script type=\"text/javascript\">alert(\"Không thể xóa cái đơn hàng đã được giao!\");</script>";
    }

    if (isset($_GET['deleteSuccess'])) {
        echo "<script type=\"text/javascript\">alert(\"Đơn hàng đã được xóa!\");</script>";
    }

    // Cập nhật orders đã chuyển hàng cho khách hàng (status=1)
    $status = 0;
    if (isset($_GET['idStatus']))
    {
        $idStatus = $_GET['idStatus'];
        if (isset($_POST['updateStatus']))
        {
            if (isset($_POST['status'])) {
                $status = 1;
            }
        }
            $sql = "UPDATE orders SET status = $status WHERE id = $idStatus";
            $res = mysqli_query($conn,$sql);
    }

    // orders chưa được cập nhật
    $sql = "SELECT * FROM view_order_list WHERE status= 0 GROUP BY idOrder";
    $res = mysqli_query($conn,$sql);
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Đơn đặt hàng mới </h1>
            </div>
            <!--/.col-lg-12--> 
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>Mã hàng</th>
                        <th>Tổng tiền</th>
                        <th>Thông tin khách hàng</th>
                        <th>Chuyển hàng</th>
                        <th>Chi tiết</th>
                        <th>Xóa </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($res)
                    {
                        while ($row = mysqli_fetch_assoc($res))
                        {
                            ?>
                            <tr class="odd gradeX" align="center">
                                <td>
                                    <a href="order-detail.php?idOrderDetail=<?php echo $row['idOrder']; ?>"><?php echo $row['idOrder']; ?></a>
                                </td>
                                <td>
                                    <?php
                                        $sqlOrderProduct = "SELECT * FROM view_order_list WHERE idOrder =" . $row['idOrder'];
                                        $resOrderPr = mysqli_query($conn,$sqlOrderProduct);
                                        if ($resOrderPr)
                                        {
                                            $total = 0;
                                            $totalAllSale = 0;
                                            $totalPay = 0;
                                            while ($rowOP = mysqli_fetch_assoc($resOrderPr))
                                            {
                                                // Giảm giá 1%: "giá bán * giá sp /100"
                                                $salePrice = $rowOP['saleprice'] * $rowOP['price'] / 100;

                                                // Tổng tiền giảm của 1 sp: "tổng giảm giá * số lượng"
                                                $totalSalePrice = $salePrice * $rowOP['quantity'];

                                                // Tổng giá của sản phẩm: "số lượng * giá - tổng giảm giá"
                                                $totalPriceProduct = $rowOP['quantity'] * $rowOP['price'] - $totalSalePrice;

                                                // Tổng giảm giá của các sản phẩm: "tổng giảm + tổng giảm giá từng sản phẩm"
                                                $totalAllSale = $totalAllSale + $totalSalePrice;

                                                // Tổng tiền của 1 sản phẩm: "tổng tiền + số lượng * giá"
                                                $total = $total + $rowOP['quantity'] * $rowOP['price'];

                                                // Tổng tiền người dùng phải trả: "tổng tiền sản phẩm - tổng giảm giá"
                                                $totalPay = $total - $totalAllSale;
                                            }
                                        }
                                        echo number_format($totalPay);
                                    ?><sup>đ</sup>
                                </td>
                                <td >
                                    <?php
                                        echo '<span style="float:left;"> Mã khách hàng: ' . $row['idUser'] . '</span></br>';
                                        echo '<span style="float:left"> Họ và tên: ' . $row['fullname'] . '</span></br>';
                                        echo '<span style="float:left"> Địa chỉ: ' . $row['address'] . ' </span></br>';
                                    ?>
                                </td>
                                <td>
                                    <form action="order-list.php?idStatus=<?php echo $row['idOrder']; ?>" method="POST">
                                        <div class="row">
                                            <div class ="col-lg-2 col-md-2 col-sm-2"></div>
                                            <div class ="col-lg-3 col-md-3 col-sm-3">
                                                <label class="checkbox">
                                                    <?php
                                                        if ($row['status'] == 1) {
                                                    ?>    
                                                            <input value="<?php echo $row['status'] ?>" type="checkbox" checked="" name="status">
                                                    <?php
                                                        } else {
                                                    ?>
                                                            <input value="<?php echo $row['status'] ?>" type="checkbox" name="status">
                                                    <?php
                                                        }
                                                    ?>

                                                </label>
                                            </div>
                                            <div class ="col-lg-5 col-md-5 col-sm-6">
                                                <button style="background: transparent;" type="submit" name ="updateStatus" class="btn btn-md"> Cập nhật </button>
                                            </div>
                                            <div class ="col-lg-1 col-md-1"></div>
                                        </div>
                                    </form>
                                </td>

                                <td class="center">
                                    <a href="order-detail.php?idOrderDetail=<?php echo $row['idOrder']; ?>" title="Chỉnh Sửa"><i class="fa fa-pencil fa-lg"></i></a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="order-delete.php?deleteAllIdOrderSame=<?php echo $row['idOrder']; ?>&statusOrder=<?php echo $row['status'] ?>" title="Xóa"><i class ="fa fa-trash-o fa-lg"></i></a>
                                </td>
                            </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
        <!--  /.row -->
    </div>
    <!--  /.container-fluid -->
</div>
<!-- /#page-wrapper -->