<!--#####################################################################
    #
    #   File          : REGISTER ACCOUNT
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
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
        $datepost = $_POST['dateofbirth'];
        $date = DateTime::createFromFormat('d-m-Y', $datepost);
        $dateofbirth = $date->format('Y-m-d H:i:s');

        $checkuser = checkUsername($username);
        $checkemail = checkEmail($email);
        if(mysqli_num_rows($checkuser) > 0 ){
            echo json_encode(['status' => 'USER']);
        } else if (mysqli_num_rows($checkemail) > 0){
            echo json_encode(['status' => 'EMAIL']);
        } else {
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
                $body = "Hi, <br>
                        Thanks for registering on Game Magazine.<br>
                        You can activate your account on the following link: <br>";
                $body .= BASE_URL . "activate.php?e=" . urlencode($email) . "&t={$token}";
                $body .= "<br>
                        All the best,<br>
                        GameMagazine.com<br>";
                $mail = new PHPMailer();
                sendmail($email, $subject, $body);

                echo json_encode(['status' => 'OK']);
            }else {
                echo json_encode(['status' => 'FAIL']);
            }
        }
    }