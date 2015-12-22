<?php
    #####################################################################
    #
    #   File          : CONTACT
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
    include('/includes/backend/mysqli_connect.php');
    include('/includes/functions.php');
    include('/includes/PHPMailer/send_mail.php');
    $author = $_SESSION['fullname'];
    $uid = $_SESSION['uid'];

    // Validate comment
    if(isset($_POST)){
        $name = $_POST['name'];
        $email = mysqli_real_escape_string($dbc, $_POST['email']);
        $title = mysqli_real_escape_string($dbc, $_POST['title']);
        $content = mysqli_real_escape_string($dbc, $_POST['content']);

        if (empty($name)){
            echo json_encode(['status' => 'NULL']);
        } else if (empty($email)){
            echo json_encode(['status' => 'NULL']);
        } else if (empty($title)){
            echo json_encode(['status' => 'NULL']);
        } else if (empty($content)){
            echo json_encode(['status' => 'NULL']);
        } else {
            $subject = $name ." " . $title ;
            $mail = new PHPMailer();
            if(sendmail($email, $subject, $content) == 'true'){
                echo json_encode(['status' => 'OK']);
            } else {
                echo json_encode(['status' => 'FAIL']);
            }
        }
    }