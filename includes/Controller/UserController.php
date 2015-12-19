<?php
    // FRONT-END : check exist username and email
    function checkUsernameAndEmail($username, $email) {
        global $dbc;

        $query = "SELECT user_id "
                . "FROM tblusers "
                . "WHERE email = '{$email}' OR username = '{$username}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : get token ========================================
    function getToken($token) {
        global $dbc;

        $query = "SELECT * FROM tbltokens WHERE token = '{$token}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END - LIST SHOW NEW  ===============================================================
    function get_list_user($order_by) {
        global $dbc;

        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS name, ";
        $query .= " DATE_FORMAT(date_of_birth, '%b %d %Y') AS birthday, ";
        $query .= " DATE_FORMAT(registration_date, '%b %d %Y') AS date ";
        $query .= " FROM tblusers WHERE (user_level = 1 OR user_level = 9) ";
        $query .= " ORDER BY {$order_by} ASC ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END - LOGIN ADMIN  ===============================================================
    function login_admin($username, $password) {
        global $dbc;

        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS fullname "
                . " FROM tblusers "
                . " WHERE username = '{$username}' "
                . " AND password = SHA1('$password') "
                . " AND ( user_level = 99 OR user_level= 9 )  "
                . " AND status = 1 LIMIT 1 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END - CHECK LOGIN  ===============================================================
    function is_logged_in() {
        if (!isset($_SESSION['uid'])) {
            redirect_to('admin/login-admin.php');
        }
    }

    //  FRONT-END - LOGIN USER ===============================================================
    function login_user($username, $password) {
        global $dbc;

        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS fullname ";
        $query .= " FROM tblusers WHERE username = '{$username}' AND password = SHA1('$password') ";
        $query .= " AND status = 1 LIMIT 1 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // 	FRONT-END : REGISTER ACCOUNT =====================================================
    function register($username, $password, $email, $firstname, $lastname, $dateofbirth, $gender) {
        global $dbc;

        $query = "INSERT INTO tblusers (username, password, email, first_name, last_name, date_of_birth, gender, user_level, status, registration_date) ";
        $query .= " VALUES ('{$username}', SHA1('$password'), '{$email}', '{$firstname}', '{$lastname}', '{$dateofbirth}', '{$gender}', '1', '0', NOW())";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : CHECK OLD PASS ==============================================================
    function checkOldPass($password, $user_id){
        global $dbc;

        $query = "SELECT * FROM tblusers WHERE password = SHA1('{$password}') AND user_id = '{$user_id}' LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : CHANGE PASS ==============================================================
    function changePass($password, $user_id) {
        global $dbc;

        $query = " UPDATE tblusers SET password = SHA1('{$password}') WHERE user_id = '{$user_id}' LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : GET USER BY ID ==============================================================
    function get_user_by_id($uid) {
        global $dbc;

        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS fullname ";
        $query .= " FROM tblusers WHERE user_id = {$uid} ";
        $query .= " AND status = 1 LIMIT 1 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
	}

    // FRONT-END : CHANGE STATUS USER ==============================================================
    function change_status_user($uid, $stt){
        global $dbc;

        if($stt == 1){
            $status = 0;
        }else {
            $status = 1;
        }
        $query = " UPDATE tblusers SET status = {$status} WHERE user_id = {$uid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : VALIDATE USERNAME ==============================================================
    function checkUsername($username) {
        global $dbc;

        $query = "SELECT username "
                . "FROM tblusers "
                . "WHERE username = '{$username}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : VALIDATE EMAIL ==============================================================
    function checkEmail($email) {
        global $dbc;

        $query = "SELECT username "
                . "FROM tblusers "
                . "WHERE email = '{$email}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : CHANGE PROFILE ==============================================================
    function change_profile($uid, $first_name, $last_name, $website, $bio, $dateofbirth) {
        global $dbc;
        $query = " UPDATE tblusers SET first_name = '{$first_name}', last_name = '{$last_name}', website = '{$website}',bio = '{$bio}', date_of_birth = '{$dateofbirth}', update_date = NOW() WHERE user_id = {$uid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONT-END : GET USER ==============================================================

    function get_user_by_id_list($uid) {
        global $dbc;

        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS fullname ";
        $query .= " FROM tblusers WHERE user_id = {$uid} ";
        $query .= " LIMIT 1 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }