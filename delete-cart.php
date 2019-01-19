<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    require_once("model/connect.php");

    // Hủy giỏ hàng:
    if (isset($_GET["idCancel"]))
    {
        $idCancel = $_GET["idCancel"];
        if ($idCancel == 0)
        {
            unset($_SESSION["cart"]);
            header("location:index.php");
        }
    }

    if (isset($_GET["id"]))
    {
        $id = $_GET["id"];
        // id = 0 là đặt hàng
        if ($id == 0)
        {
            $infor = $_SESSION["infor"];
            $total = $_SESSION["total"];

            // Khi khách hàng đã có tài khoản click vào mua sản phẩm
            if (isset($_SESSION["username"]))
            {
                $iduser = $_SESSION["id-user"];
                // Chèn vào bảng order:
                $ins = "INSERT INTO orders (total, date_order, user_id) VALUES ($total, now(), $iduser);";
                $resOrders = mysqli_query($conn,$ins);

                $sqlUser = "SELECT * FROM users WHERE id = " . $iduser;
                $resUser = mysqli_query($conn,$sqlUser);
                while ($row = mysqli_fetch_assoc($resUser))
                {
                    $name = $row["username"];
                    $email = $row["email"];
                    $address = $row["address"];
                    $phone = $row["phone"];
                }

                $selectSP = "SELECT * FROM orders WHERE user_id = " . $iduser;
                $result = mysqli_query($conn,$selectSP);
                while ($row = mysqli_fetch_assoc($result))
                {
                    $idOrder = $row["id"];
                }
            }

            // Khi khách hàng chưa có user click vào mua sản phẩm
            if (isset($_POST["checkout_submit"]))
            {
                $fullname = $_SESSION["name_cus"];
                $email = $_SESSION["email_cus"];
                $address = $_SESSION["address"];
                $phone = $_SESSION["phone_cus"];

                // Chèn vào bảng users:
                $sql = "INSERT INTO users (username, password, fullname, email, address, phone) VALUES ('', '','$fullname','$email','$address','$phone')";
                $resCus = mysqli_query($conn,$sql);

                $sel = "SELECT id FROM users ORDER BY id";
                $result = mysqli_query($conn,$sel);
                while ($row = mysqli_fetch_assoc($result))
                {
                    $user_id = $row["id"];
                }
                // Chèn vào bảng order:
                $ins = "INSERT INTO orders (total, date_order, user_id) VALUES ($total, now(), $user_id);";
                $resOrders = mysqli_query($conn,$ins);
                $flag = true;
                if (!$resOrders) {
                    $flag = false;
                }

                $selectSP = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
                $res = mysqli_query($conn,$selectSP);
                while ($row = mysqli_fetch_assoc($res)) {
                    $idOrder = $row["id"];
                }
            }

            // Cart in header
            if (isset($_SESSION["cart"]))
            {
                foreach ($_SESSION["cart"] AS $id => $prd)
                {
                    $sql = "SELECT * FROM products WHERE id = $id";
                    $res = mysqli_query($conn,$sql);
                    if (!$res) {
                        echo "Không thể chọn!";
                    }
                    else {
                        while ($row = mysqli_fetch_assoc($res))
                        {
                            // Số lượng sản phẩm
                            $quantityProduct = $_SESSION["cart"][$row["id"]];
                            $sql = "INSERT INTO product_order (product_id, order_id, quantity) VALUES('$id', '$idOrder', '$quantityProduct');";
                            $resProductOrder = mysqli_query($conn,$sql);
                        }
                    }
                }
            }

            // Gọi thư viện gửi email:
            include('class.smtp.php');
            include "class.phpmailer.php"; 
            $nFrom = "Mylishop's Shop";    //mail duoc gui tu dau, thuong de ten cong ty ban
            $mFrom = 'my.hoih@student.passerellesnumeriques.org';  //dia chi email cua ban 
            $mPass = 'hoihmy039745020027121998';       //mat khau email cua ban
            $nTo = $name; //Ten nguoi nhan
            $mTo = $email;   //dia chi nhan mail
            $mail = new PHPMailer();
            $title = 'THÔNG TIN MUA HÀNG TỪ MYLISHOP';   //Tieu de gui mail
            $body = 'NỘI DUNG ĐƠN HÀNG:' . "<br/>"."<br/>".
            $body .= "Tên khách hàng: " . $name . "\n";
            $body .= "Số điện thoại: " . $phone . "\n";
            $body .= "Địa chỉ: " . $address . "\n";
            $body .= "Thông tin sản phẩm: " . $infor;
            $body .= "Tổng số tiền: " . $total;
            $body .= "\n\n\n Cảm ơn quý khách đã tin tưởng dùng sản phẩm của chúng tôi! Hy vọng quý khách có thể ghé qua của hàng nhiều hơn, sẽ có nhiều ưu đãi cho khách hàng là thành viên của shop ạ.";
            
            $mail->IsSMTP();
            $mail->CharSet  = "utf-8";
            $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;    // enable SMTP authentication
            $mail->SMTPSecure = "ssl";   // sets the prefix to the servier
            $mail->Host       = "smtp.gmail.com";    // sever gui mail.
            $mail->Port       = 465;       // cong gui mail de nguyen

            // xong phan cau hinh bat dau phan gui mail
            $mail->Username   = $mFrom;  // khai bao dia chi email
            $mail->Password   = $mPass;              // khai bao mat khau
            $mail->SetFrom($mFrom, $nFrom);
            $mail->AddReplyTo('my.hoih@student.passerellesnumeriques.org', 'Hôih My'); //khi nguoi dung phan hoi se duoc gui den email nay
            $mail->Subject    = $title;// tieu de email 
            $mail->MsgHTML($body);// noi dung chinh cua mail se nam o day.
            $mail->AddAddress($mTo, $nTo);
            
            // thuc thi lenh gui mail 
            if(!$mail->Send()) {
                echo "<script type=\"text/javascript\">alert(\"Gửi email lỗi! Vui lòng kiểm tra lại.\");</script>";
            } else {
                echo "<script type=\"text/javascript\">alert(\"Email của bạn đã được gửi đi hãy kiếm tra hộp thư đến để xem kết quả! Cảm ơn.\");</script>";
            }


            // Xóa hết cart:
            unset($_SESSION["cart"]);
            unset($_SESSION["name_cus"]);
            unset($_SESSION["email_cus"]);
            unset($_SESSION["address"]);
            unset($_SESSION["phone_cus"]);
?>
            <script type="text/javascript">
                window.location = 'orderSuccess.php?idOrderDetail=<?php echo $idOrder; ?>';
            </script>
<?php
        }
        // Nếu có id sản phẩm được chọn thì xóa theo id của nó
        else
        {
            unset($_SESSION["cart"][$id]);
            header("location:view-cart.php");
        }
    }
?>