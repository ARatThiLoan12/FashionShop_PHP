<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fashion MyLiShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Fashion MyLiShop - fashion mylishop"/>
    <meta name="description" content="Fashion MyLiShop - fashion mylishop" />
    <meta name="keywords" content="Fashion MyLiShop - fashion mylishop" />
    <meta name="author" content="Hôih My" />
    <meta name="author" content="Y Blir" />
    <link rel="icon" type="image/png" href="images/logohong.png">
    <!-- CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Custom -->
    <script src="js/mylishop.js" type="text/javascript" charset="utf-8" async defer></script>
    <script src="js/wow.js" type="text/javascript" charset="utf-8" async defer></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- button top -->
    <a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a>
    
    <!-- header -->
    <?php include 'model/header.php'; ?>
    <!-- /header -->

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.php">Trang chủ</a></li>
            <li>Thông tin mua hàng</li>
        </ul><!-- /breadcrumb -->
        <div class="row">
            <div class ="col-md-5 col-sm-6 col-xs-12">
                <div class="info-customer">
                    <h3 style="text-align: center;"><strong> THÔNG TIN MUA HÀNG </strong></h3>
                    <p style="text-align: center;">
                        <a href="user/register.php"> Đăng kí mua hàng</a>&nbsp;|&nbsp;
                        <a href="user/login.php"> Đăng nhập </a>
                    </p>
                    <!-- form mua hàng -->
                    <form name="form1" action="" method="POST">
                        <label> Họ và Tên </label> <span style="color:#f00">&#42;</span></label>
                        <div class="form-group">
                            <input type="text" class ="form-control" name="name" placeholder="Nhập họ tên của bạn" required>
                        </div>
                        <!-- /họ và tên -->

                        <label> Email </label> <span style="color:#f00">&#42;</span></label>
                        <div class="form-group">
                            <input type="email" class ="form-control" name="email" placeholder="Nhập email của bạn" required>
                        </div>
                        <!-- /email -->

                        <label> Số điện thoại </label> <span style="color:#f00">&#42;</span></label>
                        <div class="form-group">
                            <input type="text" class ="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength ="9" maxlength ="11" name="phone" placeholder="Nhập số điện thoại của bạn" required>
                        </div>
                        <!-- /số điện thoại -->

                        <label> Địa chỉ </label> <span style="color:#f00">&#42;</span></label>
                        <div class="form-group">
                            <input type="text" class ="form-control" name="address" placeholder="Nhập địa chỉ của bạn" required>
                        </div>
                        <!-- /địa chỉ -->

                        <button class ="btn btn-default btn-lg" name="register"> Đăng kí nhận hàng </button>
                    </form>
                </div><!-- /info-customer -->
            </div><!-- /col -->

            <!-- div chia khoảng cách -->
            <div class="col-md-2 hidden-sm">
            </div>

            <!-- Thông tin đơn hàng -->
            <div class ="col-md-5 col-sm-6 col-xs-12">
                <div class="show-infor">
                    <?php
                        if (isset($_POST['register']))
                        {
                            // Lấy information từ customer chưa có account
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $phone = $_POST['phone'];
                            $address = $_POST['address'];

                            // Lưu session cho tài khoản mới
                            $_SESSION['name_cus'] = $name;
                            $_SESSION['email_cus'] = $email;
                            $_SESSION['phone_cus'] = $phone;
                            $_SESSION['address'] = $address;
                    ?>
                            <h3 style="text-align: center;"><strong> THÔNG TIN ĐƠN HÀNG </strong></h3>
                            <form name="form2" action="delete-cart.php?id=0" method="POST">
                                <table class="table">
                                    <tr>
                                        <td>Tên khách hàng: </td>
                                        <td><?php echo $name; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại:</td>
                                        <td><?php echo $phone; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ: </td>
                                        <td><?php echo $address; ?></td>
                                    </tr>
                                </table>
                                <center><button class="btn" name="send"> Gửi </button></center>
                            </form>
                    <?php
                        }
                    ?>
                </div><!-- /show-infor -->
            </div><!-- /col -->
        </div><!-- /row -->
    </div><!-- /container -->

    <!-- footer -->
    <?php include 'model/footer.php'; ?>
    <!-- /footer -->

</body>
</html>