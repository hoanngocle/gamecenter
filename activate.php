<!--#####################################################################
    #
    #   File          : ACTIVATE ACCOUNT
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
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
                            redirect_to('active_success.php');
                        } else {
                            redirect_to('active_fail.php');
                        }
                    }else {
                        echo $lang['ACTIVATE_EXPIRED'];
                    }
                }else {
                    redirect_to();
                }
            } else {
                redirect_to();
            }
            ?>
        </div>
    </div>
<?php include('includes/frontend/footer.php'); ?>