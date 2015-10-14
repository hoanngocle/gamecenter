<?php 
    include('/includes/backend/mysqli_connect.php'); 
    include('/includes/functions.php');
?>    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Bat dau xu ly form
            $errors = array();
            // Mac dinh cho cac truong nhap lieu la FALSE
            $username = $password = FALSE;


            // kiem tra page name co gia tri hay khong
            if (empty($_POST['username'])) {
                $errors[] = "username";
            } else {
                $username = mysqli_real_escape_string($dbc, strip_tags($_POST['username']));
            }

            if(isset($_POST['password']) && preg_match('/^[\w]{4,20}$/', $_POST['password'])) {
                $password = mysqli_real_escape_string($dbc, $_POST['password']);
            } else {
                $errors[] = 'password';
            }

            if(empty($errors)) {

            $result = login_user($username, $password);
                if(mysqli_num_rows($result) == 1) {
                    list($uid, $fullname, $user_level, $bio) = mysqli_fetch_array($result, MYSQLI_NUM);
                    $_SESSION['uid'] = $uid;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['bio'] = $bio;
                    $_SESSION['user_level'] = $user_level;

                }       
            }
        }
 
   