<!--#####################################################################
    #
    #   File          : CHANGE PROFILE - AJAX
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');

    if (isset($_POST)) {
        $uid = $_SESSION['uid'];
        $first_name = mysqli_real_escape_string($dbc, $_POST['firstname']);
        $last_name = mysqli_real_escape_string($dbc, $_POST['lastname']);
        $website = mysqli_real_escape_string($dbc, $_POST['website']);
        $bio = mysqli_real_escape_string($dbc, $_POST['bio']);
        $datepost = $_POST['dateofbirth'];
        $date = DateTime::createFromFormat('d-m-Y', $datepost);
        $dateofbirth = $date->format('Y-m-d H:i:s');

        $result = change_profile($uid, $first_name, $last_name, $website, $bio, $dateofbirth);
        if (mysqli_affected_rows($dbc) == 1) {

            echo json_encode(['status' => 'OK']);
        }else {
            echo json_encode(['status' => 'FAIL']);
        }
    }