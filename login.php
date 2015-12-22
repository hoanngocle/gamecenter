<?php
    #####################################################################
    #
    #   File          : LOGIN
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
    include('/includes/backend/mysqli_connect.php');
    include('/includes/functions.php');

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($dbc, strip_tags($_POST['username']));
        $password = mysqli_real_escape_string($dbc, $_POST['password']);

        $result = login_user($username, $password);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $_SESSION['uid'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['date_of_birth'] = $user['date_of_birth'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['website'] = $user['website'];
            $_SESSION['bio'] = $user['bio'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['user_level'] = $user['user_level'];
            $_SESSION['LAST_ACTIVITY'] = time();

            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['status' => 'FAIL']);
        }
    }
