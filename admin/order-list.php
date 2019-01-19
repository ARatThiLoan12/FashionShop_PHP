<?php
    require_once '../model/connect.php';
    error_reporting(E_ALL ^ E_DEPRECATED);
    include 'header.php';
    error_reporting(2);

    // $fail = $success = '';

    // $notDelete = '';
    if (isset($_GET['notDeletes']))
    {
        // $notDelete = "Không thể xóa cái đơn hàng đã được giao!";
        echo "<script type=\"text/javascript\">alert(\"Không thể xóa cái đơn hàng đã được giao!\");</script>";
    }

    // $deleteSucces = '';  
    if (isset($_GET['deleteSuccess']))
    {
        // $deleteSucces = "Đơn hàng đã được xóa!";
        echo "<script type=\"text/javascript\">alert(\"Đơn hàng đã được xóa!\");</script>";
    }


    // Cập nhật orders đã chuyển hàng cho khách hàng
    $status = 0;
    if (isset($_GET['idStatus']))
    {
        $idStatus = $_GET['idStatus'];
        if (isset($_POST['updateStatus']))
        {
            if (isset($_POST['status']))
            {
                $status = 1;
            }
            $sql = "UPDATE orders SET status = $status WHERE id = $idStatus";
            $res = mysqli_query($conn,$sql);
        }
    }

    // phân trang, $num_rec_per_page: số trang sẽ được hiển thị là 10
    // $num_rec_per_page = 10;
    // if (isset($_GET['page']))
    // {
    //     $page = $_GET['page'];
    // }
    // else {
    //     $page = 1;
    // }
    // // Trang bắt đầu
    // $start_from = ($page - 1) * $num_rec_per_page;

    // $sql = "SELECT * FROM view_order_list GROUP BY IdOrder LIMIT $start_from, $num_rec_per_page";
    // $result = mysqli_query($conn,$sql);

    // // 
    // $sql1 = "SELECT * FROM view_order_list";
    // $result_full = mysqli_query($conn,$sql1);

    // $total_records = mysqli_num_rows($result_full);  //count number of records
    // $total_pages = ceil($total_records / $num_rec_per_page);
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="page-header"> Danh sách đơn đặt hàng </h1>
                <p><?php echo $notDelete . $deleteSuccess; ?></p>
                
                <!-- Phân trang -->
                <!-- <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php
                            echo "<ul class= 'pagination pagination-sm'><li><a href='order-list.php?page=1'>" . '|<' . "</a> </li>"; // Goto 1st page  

                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo "<li><a href='order-list.php?page=" . $i . "'>" . $i . "</a> </li>";
                            };
                            echo "<li><a href='order-list.php?page=$total_pages'>" . '>|' . "</a> </li></ul>";
                        ?>
                    </div>
                </div> -->
                <!--/.col-lg-12--> 

                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th> Mã hàng </th>
                            <th> Tổng tiền </th>
                            <th> Thông tin khách hàng </th>
                            <th> Chuyển hàng </th>
                            <th> Chi tiết </th>
                            <th> Xóa </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM view_order_list GROUP BY IdOrder";
                            $result = mysqli_query($conn,$sql);
                            if ($result)
                            {
                                while ($row = mysqli_fetch_assoc($result))
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
                                                        // Giảm giá 0.01%: "giá bán * giá sp /100"
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
                                        <td>
                                            <?php
                                                echo '<span style="float:left;"> Mã khách hàng: ' . $row['idUser'] . '</span></br>';
                                                echo '<span style="float:left"> Họ và tên: ' . $row['fullname'] . '</span></br>';
                                                echo '<span style="float:left"> Địa chỉ: ' . $row['address'] . ' </span></br>';
                                            ?>
                                        </td>
                                        <td>
                                            <!-- Nếu admin check vào update checkbox thì là đã chuyển hàng cho khách hàng -->
                                            <form action="order-list.php?idStatus=<?php echo $row['idOrder']; ?>" method="POST">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <label class="checkbox">
                                                            <?php
                                                                if ($row['status'] == 1)
                                                                {
                                                            ?>
                                                                    <input  value="<?php echo $row['status'] ?>" type="checkbox" checked="" name="status">
                                                            <?php
                                                                } else
                                                                {
                                                            ?>
                                                                   <input  value="<?php echo $row['status'] ?>" type="checkbox" name="status">
                                                            <?php
                                                                }
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <button style="background: transparent;" type="submit" name="updateStatus" class="btn btn-md"> Cập nhật </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                        <td class="center">
                                            <a href="order-detail.php?idOrderDetail=<?php echo $row['idOrder']; ?>" title="Chỉnh sửa"><i class="fa fa-pencil fa-lg"></i></a>
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa order này không?')" href="order-delete.php?deleteAllIdOrderSame=<?php echo $row['idOrder']; ?>&statusOrder=<?php echo $row['status']; ?>" title="Xóa"><i class ="fa fa-trash-o fa-lg"></i></a>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--  /.col -->
        </div>
        <!--  /.row -->
    </div>
    <!-- ./container-fluid -->
</div>
    <!-- /#page-wrapper -->