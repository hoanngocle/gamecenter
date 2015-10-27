<?php

    session_start();
    include('/includes/backend/mysqli_connect.php');
    include('/includes/functions.php');
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($dbc, strip_tags($_POST['username']));
        $password = mysqli_real_escape_string($dbc, $_POST['password']);

        $result = login_user($username, $password);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $_SESSION['uid'] = $user['user_id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['user_level'] = $user['user_level'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['LAST_ACTIVITY'] = time();
            
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['status' => 'FAIL']);
        }
    }
