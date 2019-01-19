<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once '../model/connect.php';

    if (isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE username = '$username' AND password = md5('$password')";
        $res = mysqli_query($conn,$sql);
        
        $rows = mysqli_num_rows($res);
        if ($rows > 0)
        {
            $_SESSION['usernameAdmin'] = $username; // Khởi tạo Session cho admin
            while($row = mysqli_fetch_assoc($conn,$res)) {
                $_SESSION['id-Admin'] = $row['id'];
            }

            header('Location:order-list.php');
        } 
        else 
        {
            $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không hợp lệ!';
            
            header('Location:../admin/login.php?error=wrong');
            die("");
            exit();
        }
    }
    //làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
    //mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
    //    $idad = strip_tags($idad);
    //    $idad = addslashes($idad);
    //    $username = addslashes($_POST['username']);
?>
 