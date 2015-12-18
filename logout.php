<!--#####################################################################
    #
    #   File          : LOGOUT - USER
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'Logout';
	include('/includes/backend/mysqli_connect.php');
	include('/includes/functions.php');

    if(isset($_SESSION['fullname'])) {

        $_SESSION = array(); // Xoa het array cua SESSION
        session_destroy(); // Destroy session da tao
        setcookie(session_name(),'', time()-36000); // Xoa cookie cua trinh duyet

        header("Refresh:0");
    }else {
        redirect_to();
    }
