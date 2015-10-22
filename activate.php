<?php
    //Include file php function vs connect DB
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');
    include('includes/frontend/header.php');
    ?>
    <div class="four">
        <div class="container">	
            <?php
            if (isset($_GET['e'], $_GET['t']) && filter_var($_GET['e'], FILTER_VALIDATE_EMAIL) && strlen($_GET['t']) == 40) {
                $email = mysqli_real_escape_string($dbc, $_GET['e']);
                $t = mysqli_real_escape_string($dbc, $_GET['t']);
                $now = date('Y-m-d H:i:s');
                $rs = getToken($t);
                
                if ($news = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                    $token = $news['token'];
                    $expired_date = $news['expired_date'];
                    
                    if ($token == $t && $expired_date > $now) {
                        $q = "UPDATE tblusers SET status = 1 WHERE email = '{$email}'";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);
                        
                        if (mysqli_affected_rows($dbc) == 1) {
                            echo "<p class='success'>Tài khoản của bạn đã được kích hoạt thành công. Bạn có thể click vào <a href='" . BASE_URL . "/login.php'> đây </a> để đăng nhập ngay.</p>";
                        } else {
                            echo "<p class='warning'>Tài khoản của bạn vẫn chưa được kích hoạt thành công. Rất xin lỗi bì sự bất tiện này/</p>";
                        }
                        
                    }else {
                        echo "Tai khoan da qua han de kich hoat!";
                    }
                    
                }else {
                    redirect_to();
                }
                
            } else {
                // Thong tin khong dung, hoac khong hop le, chuyen huong nguoi dung ve trang index
                redirect_to();
            }
            ?>
        </div>
    </div>
    <!---->
<?php include('includes/frontend/footer.php'); ?>	