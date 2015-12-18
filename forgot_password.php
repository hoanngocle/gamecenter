<!--#####################################################################
    #
    #   File          : FORGOT PASSWORD
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    include('/includes/backend/mysqli_connect.php');
    include('/includes/functions.php');
    include('/includes/PHPMailer/send_mail.php');

    if (isset($_POST['email'])) {
        $email = mysqli_real_escape_string($dbc, $_POST['email']);
        $query = "SELECT user_id FROM tblusers WHERE email = '{$email}'";
        $rs = mysqli_query($dbc, $query);
        confirm_query($rs, $query);

        if (mysqli_num_rows($rs) == 1) {
            list($uid) = mysqli_fetch_array($rs, MYSQLI_NUM);
            $password = genPassword8Char();
            $query = "UPDATE tblusers SET password = SHA1('$password') WHERE user_id = {$uid} LIMIT 1";
            $result = mysqli_query($dbc, $query);
            confirm_query($result, $query);

            if (mysqli_affected_rows($dbc) == 1) {
                $subject = 'Retrieve password in GameCenter!';
                $body = "Your password has been temporarily changed to:<br>"
                        . "New password: {$password}.<br>"
                        . "Please use this email address and the new password. Make sure you change it later.";
                $mail = new PHPMailer();
                sendmail($email, $subject, $body);
                echo json_encode(['status' => 'OK']);
            }
        } else {
            echo json_encode(['status' => 'FAIL']);;
        }
    }