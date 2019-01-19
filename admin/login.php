<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    $href = '../';
    require_once $href.'model/connect.php';

    $prd = 0;
    if (isset($_SESSION['cart'])) {
        $prd = count($_SESSION['cart']);
    }
    if(isset($_GET['error'])) {
        $error = 'Vui lòng kiểm tra lại tên đăng nhập và mật khẩu của bạn!';
    }else 
    $error = '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fashion MyLiShop</title>
    <meta name="viewport" content = "width=device-width, initial-scale =1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="Hôih My">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="<?php echo $href?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $href?>css/font-awesome.min.css">
    <script src="<?php echo $href?>js/jquery.js"></script>
    <script src="<?php echo $href?>js/bootstrap.min.js"></script>
    <script src="<?php echo $href?>js/jquery-1.9.1.min.js"></script>
    <!-- Bootstrap Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $href?>css/style.css">
</head>
<body>
    <div class="container" style="margin-top: 150px">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-danger">
                    <!-- panel-heading -->
                    <div class="panel-heading">
                        <center><h4><strong> ĐĂNG NHẬP VÀO TÀI KHOẢN</strong></h4></center>
                        <p style="color: red"><?php echo $error;?></p>
                    </div><!-- /panel-heading -->
                    
                    <!-- panel-body -->
                    <div class="panel-body">
                        <form  action="login_back.php" method="POST">
                            <div class="row">
                                <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user fa-lg"></i>
                                            </span> 
                                            <input class="form-control" placeholder="Username" name="username" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock fa-lg"></i>
                                            </span>
                                            <input class="form-control" placeholder="Password" name="password" type="password" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-info btn-lg btn-block" name="submit" value="Đăng nhập">
                                    </div>
                                </div><!-- /col -->
                            </div><!-- /row -->
                        </form>
                    </div><!-- /panel-body -->

                    <div class="panel-footer ">
                        <center> <img src="../images/logohong.png" width="200px;" height="110px;"></center>
                    </div><!-- /panel-footer -->

                </div><!-- /panel panel-danger -->
            </div><!-- /col -->
        </div><!-- /row -->
    </div><!-- /container -->
</body>
</html>
