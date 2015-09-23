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


        if (preg_match('/^[\w\'.-]{6,24}$/i', trim($_POST['username']))) {
            $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        } else {
            $errors[] = 'username';
        }


        if (preg_match('/^[\w\'.-]{6,24}$/', trim($_POST['password']))) {
                // Neu mat khau mot phu hop voi mat khau hai, thi luu vao csdl
                $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            
        } else {
            $errors[] = 'password';
        }

        if ($username && $password) {
            // Neu moi thu deu day du, truy van csdl
            $result = checkUsernameAndEmail($username, $email);

            if (mysqli_num_rows($result) == 0) {
                // Luc nay email van con trong, cho phep nguoi dung dang ky

                } else {
                    redirect_to('404.php');
                }
            } else {
                // Email da ton tai, phai dang ky bang email khac.
                $message = "<p class='warning'>Email đăng ký đã tồn tại</p>";
            }
            // Neu mot trong cac truong bi thieu gia tri
            $error = "Tất cả các trường đều phải được nhập đầy đủ!";

    }// END main IF
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