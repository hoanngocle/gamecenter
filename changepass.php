<?php
    #####################################################################
    #
    #   File          : CHANG PASS
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
    include('/includes/backend/mysqli_connect.php');
    include('/includes/functions.php');

    if (isset($_POST['oldpass'])) {
        $oldpass = mysqli_real_escape_string($dbc, strip_tags($_POST['oldpass']));
        $newpass = mysqli_real_escape_string($dbc, strip_tags($_POST['newpass']));
        $result = checkOldPass($oldpass, $_SESSION['uid']);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $rs2 = changePass($newpass, $_SESSION['uid']);
            if (mysqli_affected_rows($dbc) == 1) {
                echo json_encode(['status' => 'OK']);
            } else {
                echo json_encode(['status' => 'FAIL']);
            }
        } else {
            echo json_encode(['status' => 'CHECK FAIL']);
        }
    }
