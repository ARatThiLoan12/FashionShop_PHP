<?php
    //goi thu vien
    include('class.smtp.php');
    include "class.phpmailer.php"; 
    $nFrom = "PNV";    //mail duoc gui tu dau, thuong de ten cong ty ban
    $mFrom = 'my.hoih@student.passerellesnumeriques.org';  //dia chi email cua ban 
    $mPass = 'hoihmy039745020027121998';       //mat khau email cua ban
    $nTo = 'Hôih My Develop'; //Ten nguoi nhan
    $mTo = 'hoihmy98@gmail.com';   //dia chi nhan mail
    $mail             = new PHPMailer();
    $body             = 'Nội dung email';   // Noi dung email
    $title = 'Đây là tiêu đề';   //Tieu de gui mail
    $mail->IsSMTP();             
    $mail->CharSet  = "utf-8";
    $mail->SMTPDebug  = 0;   // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;    // enable SMTP authentication
    $mail->SMTPSecure = "ssl";   // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";    // sever gui mail.
    $mail->Port       = 465;         // cong gui mail de nguyen
    // xong phan cau hinh bat dau phan gui mail
    $mail->Username   = $mFrom;  // khai bao dia chi email
    $mail->Password   = $mPass;              // khai bao mat khau
    $mail->SetFrom($mFrom, $nFrom);
    $mail->AddReplyTo('nguyenngocthuylinh2807@gmail.com', 'PNV'); //khi nguoi dung phan hoi se duoc gui den email nay
    $mail->Subject    = $title;// tieu de email 
    $mail->MsgHTML($body);// noi dung chinh cua mail se nam o day.
    $mail->AddAddress($mTo, $nTo);
    // thuc thi lenh gui mail 
    if(!$mail->Send()) {
        echo 'Có lỗi!';
    } else {
        echo 'Email của bạn đã được gửi đi hãy kiếm tra hộp thư đến để xem kết quả. ';
    }
?>