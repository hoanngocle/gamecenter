<?php
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');
    include('/includes/PHPMailer/send_mail.php');
    
    if (isset($_POST)) {
        
        $firstname = mysqli_real_escape_string($dbc, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($dbc, $_POST['lastname']);
        $username = mysqli_real_escape_string($dbc, $_POST['username']);
        $email = mysqli_real_escape_string($dbc, $_POST['email']);
        $password = mysqli_real_escape_string($dbc, $_POST['password']);
        $gender = $_POST['gender'];
        $date = DateTime::createFromFormat('d-m-Y', '22-10-2015');
        $dateofbirth = $date->format('Y-m-d H:i:s');
   
        $rs = register($username, $password, $email, $firstname, $lastname, $dateofbirth, $gender);
        if (mysqli_affected_rows($dbc) == 1) {
            $expired_date = date("Y-m-d H:i:s", time() + 259200);
            $token = sha1(uniqid(rand(), true));

            // get user_id
            $result = checkUsernameAndEmail($username, $email);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $user_id = $user['user_id'];

            //insert token to db
            $querytoken = "INSERT INTO tbltokens (token, expired_date, user_id)"
                    . "VALUES ('$token', '{$expired_date}', '{$user_id}')";
            $result2 = mysqli_query($dbc, $querytoken);
            confirm_query($result2, $querytoken);

            // send mail active
            $subject = 'Thank for registering in GameCenter!';
            $body = "Cảm ơn bạn đã đăng ký thành công ở website Game Center.<br>
                    Một email kích hoạt đã được gửi tới địa chỉ email mà bạn cung cấp. <br>
                    Hãy click vào đường link để kích hoạt tài khoản <br>";

            $body .= BASE_URL . "activate.php?e=" . urlencode($email) . "&t={$token}";
            $mail = new PHPMailer();
            sendmail($email, $subject, $body);

            echo json_encode(['status' => 'OK']);
        }else {
            echo json_encode(['status' => 'FAIL']);
        }
    }