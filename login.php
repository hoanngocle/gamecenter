<?php
    session_start();
    include('/includes/backend/mysqli_connect.php'); 
    include('/includes/functions.php');
  
        if(isset($_POST['username']) && isset($_POST['password'])){
            $username = mysqli_real_escape_string($dbc, strip_tags($_POST['username']));
            $password = mysqli_real_escape_string($dbc, $_POST['password']);

            $result = login_user($username, $password);
                if(mysqli_num_rows($result) == 1) {
                    list($uid, $fullname, $user_level, $bio) = mysqli_fetch_array($result, MYSQLI_NUM);
                    $_SESSION['uid'] = $uid;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['bio'] = $bio;
                    $_SESSION['user_level'] = $user_level;               
                    $_SESSION['LAST_ACTIVITY'] = time();
                }       
            }
 
   