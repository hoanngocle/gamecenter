<?php
//Include file php function vs connect DB
include('includes/backend/mysqli_connect.php');
include('includes/functions.php');
include('includes/frontend/header.php');
?>
<div class="content">
    <?php
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
        $query  = "SELECT user_id, first_name, user_level FROM users WHERE (email = '{$e}' AND pass = SHA1('$p')) AND active IS NULL LIMIT 1";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            if(mysqli_num_rows($r) == 1) {

            }// END main IF
        }
    }
    ?>
    <div class="contact">
        <h2>Register</h2>
        <div class="contact-form">
            <?php if (!empty($message)) echo $message; ?>
            <div class="col-md-10 contact-grid">
                <form action="login.php" method="post">
                    <div class="register-row">                   
                        <input type="text" name="username" size="20" maxlength="60" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" tabindex='1' placeholder="Username *" />
                         <?php if (isset($errors) && in_array('username', $errors)) 
                                echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Username không được bỏ trống, độ dài từ 6 đến 24 kí tự, không được chứa kí tự đặc biệt</p>
                                                </div>"; ?>
                        
                        <br>

                        <input type="password" name="password" size="20" maxlength="60" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" tabindex='1' placeholder="Password *" />
                                <?php if (isset($errors) && in_array('password', $errors)) 
                                        echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                        <p>Password không được bỏ trống, độ dài từ 6 đến 20 kí tự</p>
                                                    </div>"; ?>

                        <br>

                        <div class="submit">
                            <input type="submit" name=submit" value="Login" >
                            <input type="reset" name=reset" value="Reset" >
                        </div>
                    </div>
                </form>
                <div class="clearfix"> </div>
            </div>
        </div><!--end content-->
        <div class="clearfix"> </div>
    </div>

    <!---->
    <?php include('includes/frontend/footer.php'); ?>	