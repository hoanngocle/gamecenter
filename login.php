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
        $first_name = $last_name = $username = $email = $reemail = $password = $repassword = FALSE;

        if (preg_match('/^[\w\'.-]{2,60}$/i', trim($_POST['first_name']))) {
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
        } else {
            $errors[] = 'first name';
        }

        if (preg_match('/^[\w\'.-]{2,60}$/i', trim($_POST['last_name']))) {
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
        } else {
            $errors[] = 'last name';
        }

        if (preg_match('/^[\w\'.-]{6,24}$/i', trim($_POST['username']))) {
            $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        } else {
            $errors[] = 'username';
        }

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            if ($_POST['email'] == $_POST['reemail']) {
                // Neu email  phu hop voi reemail, thi luu vao csdl
                $email = mysqli_real_escape_string($dbc, $_POST['email']);
            } else {
                // Neu email khong phu hop voi nhau
                $errors[] = 'email not match';
            }
        } else {
            $errors[] = 'email';
        }

        if (preg_match('/^[\w\'.-]{6,24}$/', trim($_POST['password']))) {
            if ($_POST['password'] == $_POST['repassword']) {
                // Neu mat khau mot phu hop voi mat khau hai, thi luu vao csdl
                $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            } else {
                // Neu mat khau khong phu hop voi nhau
                $errors[] = "password not match";
            }
        } else {
            $errors[] = 'password';
        }

        if ($first_name && $last_name && $username && $email && $password) {
            // Neu moi thu deu day du, truy van csdl
            $result = checkUsernameAndEmail($username, $email);

            if (mysqli_num_rows($result) == 0) {
                // Luc nay email van con trong, cho phep nguoi dung dang ky
                $status = 0;

                // Chen gia tri vao CSDL
                $query = "INSERT INTO tblusers (username, password, email, first_name, last_name, status, registration_date)
                        VALUES ('{$username}', SHA1('$password'), '{$email}', '{$first_name}', '{$last_name}', '{$status}', NOW())";
                $result = mysqli_query($dbc, $query);
                confirm_query($result, $query);

                if (mysqli_affected_rows($dbc) == 1) {
                    $expired_date = date("Y-m-d H:i:s", time() + 259200);
                    $token = sha1(uniqid(rand(), true));

                    $result = checkUsernameAndEmail($username, $email);
                    $user = mysql_fetch_array($result, MYSQLI_ASSOC);
                    $user_id = $user['user_id'];

                    $querytoken = "INSERT INTO tbltokens (token, expired_date, user_id)"
                            . "VALUES ('$token', '{$expired_date}', '{$user_id}')";
                    $result2 = mysqli_query($dbc, $querytoken);
                    confirm_query($result2, $querytoken);

                    // Neu dien thong tin thanh cong, thi gui email kich hoat cho nguoi dung
                    $to = $_POST['email'];
                    $subject = 'Kích hoạt tài khoản tại GameCenter!';
                    $body = "Cảm ơn bạn đã đăng ký thành công ở website Game Center. Một email kích hoạt đã được gửi tới địa chỉ email mà bạn cung cấp. 
                            Hãy click vào đường link để kích hoạt tài khoản \n\n ";
                    $body .= BASE_URL . "/activate.php?e=" . urlencode($email) . "&t={$token}";
                    if (mail($to, $subject, $body, 'FROM: localhost')) {
                        redirect_to('success_active.php');
                    } else {
                        redirect_to('error_active.php');
                    }
                } else {
                    redirect_to('404.php');
                }
            } else {
                // Email da ton tai, phai dang ky bang email khac.
                $message = "<p class='warning'>Email đăng ký đã tồn tại</p>";
            }
        } else {
            // Neu mot trong cac truong bi thieu gia tri
            $error = "Tất cả các trường đều phải được nhập đầy đủ!";
        }
    }// END main IF
    ?>
    <div class="contact">
        <h2>Register</h2>
        <div class="contact-form">
            <?php if (!empty($message)) echo $message; ?>
            <div class="col-md-10 contact-grid">
                <form action="register.php" method="post">
                    <div class="register-row">
                        
                       
                        <input type="text" name="username" size="20" maxlength="60" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" tabindex='1' placeholder="Username *" />
                         <?php if (isset($errors) && in_array('username', $errors)) 
                                echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Username không được bỏ trống, độ dài từ 6 đến 24 kí tự, không được chứa kí tự đặc biệt</p>
                                                </div>"; ?>
                        
                        <br>

                            </label> 
                        <input type="text" name="email" id="email" size="20" maxlength="255" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8'); ?>" tabindex='1' placeholder="Email * "/>  
                        <?php if (isset($errors) && in_array('email', $errors))
                                echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Email nhập phải đúng định dạnh demo@mail.abc </p>
                                                </div>"; ?>
                        
                    <br>
                    
                    <input type="text" name="reemail" id="email" size="20" maxlength="255" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8'); ?>" tabindex='1' placeholder="Confirm Email *" /> 
                     <?php if (isset($errors) && in_array('email', $errors)) 
                             echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Email nhập lại phải trùng nhau</p>
                                                </div>"; ?>
                        
                    <br>

                    <input type="password" name="password" size="20" maxlength="60" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" tabindex='1' placeholder="Password *" />
                            <?php if (isset($errors) && in_array('password', $errors)) 
                                    echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Password không được bỏ trống, độ dài từ 6 đến 20 kí tự</p>
                                                </div>"; ?>
                    
                    <br>
                       
                    <input type="password" name="repassword" size="20" maxlength="60" value="<?php if (isset($_POST['repassword'])) echo $_POST['repassword']; ?>" tabindex='1' placeholder="Confirm Password *"/>
                        <?php if (isset($errors) && in_array('password not match', $errors)) 
                                echo " <div class='alert alert-warning' style='font-size: 16px; padding: 5px 5px 5px 12px; margin-top: 15px'>
                                                    <p>Password nhập lại phải trùng nhau</p>
                                                </div>";
                        ?>
                    </div>
                    <br>

                    <div class="send">
                        <input type="submit" name=submit" value="Register" >
                        <input type="reset" name=reset" value="Reset" >
                    </div>
                </form>
                <div class="clearfix"> </div>
            </div>
        </div><!--end content-->
        <div class="clearfix"> </div>
    </div>

    <!---->
    <?php include('includes/frontend/footer.php'); ?>	