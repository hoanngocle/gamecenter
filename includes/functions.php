<?php
    session_start();

    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];

        $_SESSION['lang'] = $lang;
        setcookie('lang', $lang, time() + (3600 * 24 * 30));
        
    } else if (isSet($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else if (isSet($_COOKIE['lang'])) {
        $lang = $_COOKIE['lang'];   
    } else {
        $lang = 'vi';
    }

    switch ($lang) {
        case 'en':
            $lang_file = 'lang.en.php';
            break;

        case 'vi':
            $lang_file = 'lang.vi.php';
            break;

        default:
            $lang_file = 'lang.vi.php';
    }
    include_once 'languages/' . $lang_file;

// xac dinh hang so cho dia chi tuyet doi
    define('BASE_URL', 'http://www.gamecenter.dev/');
    define('LIVE', FALSE); // FALSE la dang trong qua trinh phat trien | TRUE la dang trong production
    // INCLUDE - CONFIRM  =================================================================
    function confirm_query($result, $query) {
        global $dbc;
        if (!$result && !LIVE) {
            die("Query {$query} \n <br> MySQL Error: " . mysqli_error($dbc));
        }
    }

    // Tao function de bao loi rieng
    function custom_error_handler($e_number, $e_message, $e_files, $e_line, $e_vars) {
        $message = "<p class='warning'>Có lỗi xảy ra ở file {$e_files} tại dòng {$e_line}: {$e_message} \n";


        if(!LIVE) {
            // In DEV
            echo "<pre>". $message ."</pre><br/>\n";
        } else {
            // LIVE in host
            echo "<p class='warning'>Oops! something went wrong, we are so sorry for the inconvenice.</p>";
        }
    }// End

    // use our custom handler
    set_error_handler('custom_error_handler');

    
    
    // INCLUDE - REDIRECT =================================================================

    function redirect_to($page = 'index.php') {
        $url = BASE_URL . $page;
        header("Location: {$url}");
        exit();
    }

    // INCLUDE - REDIRECT =================================================================   
    function genPassword8Char($length = 8) {
        $password = '';
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        while ($i < $length) {
            $password .= substr($str, mt_rand(0, strlen($str) - 1), 1);
            $i++;
        }
        return $password;
    }

    // INCLUDE - EXCERPT ==========================================================
    // ham cat chu cuoi cung cua phan content thanh doan van ngan
    function excerpt_news_content($sanitized) {
        if (strlen($sanitized) > 100) {
            $cutString = substr($sanitized, 0, 200);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
    }

    // ham cat chu cuoi cung cua phan content thanh doan van ngan
    function excerpt($sanitized) {
        if (strlen($sanitized) > 800) {
            $cutString = substr($sanitized, 0, 700);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
    }

    // INCLUDE - EXCERPT FEATURE ==========================================================
    // ham cat chu cuoi cung cua phan content thanh doan van ngan
    function excerpt_features($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        if (strlen($sanitized) > 600) {
            $cutString = substr($sanitized, 0, 500);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
    }

    // INCLUDE - Tao paragraph ID ==========================================================
    // Tao paragraph tu CSDL
    function the_content($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        return str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $sanitized);
    }

    // INCLUDE - VALIDATE ID ===============================================================
    // ham kiem tra xem GET co gia tri hay ko, $id co hop le, la dang so hay ko
    function validate_id($id) {
        if (isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $val_id = $id;
            return $val_id;
        } else {
            return null;
        }
    }

    // End validate_id
    // INCLUDE - GET 1 NEW by ID ===========================================================
    function get_news_by_id($nid) {
        global $dbc;
        $query = "SELECT n.news_id, n.title, n.content, n.banner, n.image, t.type_name, n.status, ";
        $query .= " DATE_FORMAT( n.create_date, '%b') AS month, ";
        $query .= " DATE_FORMAT( n.create_date, '%d') AS day, ";
        $query .= " DATE_FORMAT( n.create_date, '%b %d, %Y') AS date, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING ( user_id ) ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " WHERE n.news_id={$nid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }


    // CLIENT SITE [start]==================================================================
    // FRONTEND - BANNER ==================================================================
    function get_banner() {
        global $dbc;
        // Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
        $query = " SELECT i.image_id, i.image, i.title, t.type_name, ";
        $query .= " DATE_FORMAT(create_date, '%b %d, %y') AS date ";
        $query .= " FROM tblimages as i";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING (type_id) ";
        $query .= " WHERE t.type_name = 'Banner' ";
        $query .= " ORDER BY date LIMIT 0, 3";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND - NEW GAME =================================================================
    function get_new_games() {
        global $dbc;
        // Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
        $query = " SELECT n.news_id, n.title, n.content, n.image, t.type_name, c.cat_name,  ";
        $query .= " DATE_FORMAT(create_date, '%b %d, %y') AS date ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " INNER JOIN tblcategories AS c ";
        $query .= " USING ( cat_id ) ";
        $query .= " WHERE c.cat_name = 'Games' ";
        $query .= " ORDER BY date LIMIT 0, 8";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND - NEW GAME BY TYPE=================================================================
    function get_games() {
        global $dbc;
        // Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
        $query = " SELECT n.news_id, n.title, n.content, n.image, t.type_name, c.cat_name,  ";
        $query .= " DATE_FORMAT(create_date, '%b %d, %y') AS date ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " INNER JOIN tblcategories AS c ";
        $query .= " USING ( cat_id ) ";
        $query .= " WHERE c.cat_name = 'Games' ";
        $query .= " ORDER BY date LIMIT 4";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND - BEST FEATURE - IMAGE =====================================================
    function get_features() {
        global $dbc;
        $query = "SELECT n.news_id, n.title, n.content, t.type_name,  ";
        $query .= " DATE_FORMAT( n.create_date, '%b') AS month, ";
        $query .= " DATE_FORMAT( n.create_date, '%d') AS day, ";
        $query .= " DATE_FORMAT( n.create_date, '%b %d, %Y') AS date ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " WHERE t.type_name = 'Feature' LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND - LASTEST - NEW - bai viet moi nhat ========================================
    function get_newest_news() {
        global $dbc;
        // Query lay gia tri tu co so du lieu ra
        $query = "SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.create_date, '%d %b, %Y') AS date, cat.cat_name,  ";
        $query .= " COUNT(c.comment_id) AS count ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id)";
        $query .= " INNER JOIN tblcategories AS cat";
        $query .= " USING (cat_id)";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY date DESC LIMIT 0, 3 ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND - HOTEST - NEW - comment nhieu nhat ========================================
    function get_hotest_news() {
        global $dbc;
        // Query lay gia tri tu co so du lieu ra
        $query = "SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.create_date, '%d %b, %Y') AS date, cat.cat_name,  ";
        $query .= " COUNT(c.comment_id) AS count ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id)";
        $query .= " INNER JOIN tblcategories AS cat";
        $query .= " USING (cat_id)";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 AND n.create_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY count DESC LIMIT 0, 3 ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_topweek_news() {
        global $dbc;
        $query = "SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.create_date, '%d %b, %Y') AS date, cat.cat_name,  ";
        $query .= " COUNT(c.comment_id) AS count ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id)";
        $query .= " INNER JOIN tblcategories AS cat";
        $query .= " USING (cat_id)";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 AND n.create_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK) ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY count DESC LIMIT 0, 3 ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }


    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_type_news() {
        global $dbc;
        $query = "SELECT * "
                . "FROM tbltypes "
                . "WHERE cat_id = 1 "
                . "ORDER BY type_id ASC LIMIT 0, 3 ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }


        // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_type_by_id($tid) {
        global $dbc;
        $query = "SELECT * FROM tbltypes WHERE cat_id = 3 AND type_id = '{$tid}' ORDER BY type_id ASC";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }


        // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_news_by_type($type) {
        global $dbc;
        $query = " SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.create_date, '%d %b, %Y') AS date, n.content, cat.cat_name ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id)";
        $query .= " INNER JOIN tblcategories AS cat";
        $query .= " USING (cat_id)";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 AND t.type_name = '{$type}' ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY date DESC LIMIT 0, 3 ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

        // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================

    function get_games_by_type($type) {
        global $dbc;
        $query = " SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.create_date, '%d %b, %Y') AS date, n.content, cat.cat_name ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id)";
        $query .= " INNER JOIN tblcategories AS cat";
        $query .= " USING (cat_id)";
        $query .= " WHERE cat.cat_name = 'Games' AND n.status = 1 AND t.type_name = '{$type}' ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY date DESC LIMIT 4 ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_tag_by_id($nid) {
        global $dbc;
        $query = " SELECT d.tag_id, d.news_id, t.keyword";
        $query .= " FROM tbltag_data AS d ";
        $query .= " INNER JOIN tbltags AS t";
        $query .= " USING (tag_id)";
        $query .= " WHERE  d.news_id = '{$nid}' ";

        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_first_image_gallery() {
        global $dbc;
        $query = " SELECT * "
                . "FROM tblimages AS i "
                . "INNER JOIN tbltypes AS t "
                . "WHERE i.type_id = t.type_id and T.type_id != 17 "
                . "AND i.status = 1 AND t.cat_id = 3 "
                . "ORDER BY i.create_date LIMIT 1";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_image_row() {
        global $dbc;
        $query = " SELECT * "
                . "FROM tblimages AS i "
                . "INNER JOIN tbltypes AS t "
                . "WHERE i.type_id = t.type_id and T.type_id != 17 "
                . "AND i.status = 1 AND t.cat_id = 3 "
                . "ORDER BY i.create_date LIMIT 1,6";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_image_by_type_id($type_id) {
        global $dbc;
        $query = " SELECT i.image_id, i.image, t.type_name "
                . "FROM tblimages AS i "
                . "INNER JOIN tbltypes AS t "
                . "USING ( type_id ) "
                . "WHERE type_id = '{$type_id}' AND status = 1 "
                . "ORDER BY create_date LIMIT 6 ";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_first_thumbnail() {
        global $dbc;
        $query = " SELECT * "
                . " FROM tblvideos AS v "
                . " INNER JOIN tbltypes AS t "
                . " WHERE v.type_id = t.type_id  "
                . " AND v.status = 1 AND t.cat_id = 4 "
                . " ORDER BY v.create_date LIMIT 1";
 
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : POPULAR - NEW - chu de duoc yeu thich ========================================
    function get_thumbnail_row() {
        global $dbc;
        $query = " SELECT * "
                . " FROM tblvideos AS v "
                . " INNER JOIN tbltypes AS t "
                . " WHERE v.type_id = t.type_id  "
                . " AND v.status = 1 AND t.cat_id = 4 "
                . " ORDER BY v.create_date LIMIT 1,6";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : check exist username and email ========================================
    function checkUsernameAndEmail($username, $email) {
        global $dbc;
        $query = "SELECT user_id "
                . "FROM tblusers "
                . "WHERE email = '{$email}' OR username = '{$username}'";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // FRONTEND : get token ========================================
    function getToken($token) {
        global $dbc;
        $query = "SELECT * FROM tbltokens WHERE token = '{$token}'";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // ADMIN SITE [start] ======================================================================
    //  BACKEND - LIST SHOW NEW  ===============================================================
    function get_all_news($order_by) {
        global $dbc;
        $query = "SELECT n.news_id, t.type_name, n.title, n.content, n.status, c.cat_name, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
        $query .= " DATE_FORMAT(n.create_date, '%b %d %Y') AS date ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING(user_id) ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id) ";
        $query .= " INNER JOIN tblcategories AS c";
        $query .= " USING (cat_id) ";
        $query .= " WHERE cat_id = 1 ";
        $query .= " ORDER BY {$order_by} ASC ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - LIST SHOW GAME  ===============================================================
    function get_all_games($order_by) {
        global $dbc;
        $query = "SELECT n.news_id, t.type_name, n.title, n.content, n.status, c.cat_name, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
        $query .= " DATE_FORMAT(n.create_date, '%b %d %Y') AS date ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING(user_id) ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING (type_id) ";
        $query .= " INNER JOIN tblcategories AS c";
        $query .= " USING (cat_id) ";
        $query .= " WHERE cat_id = 2 ";
        $query .= " ORDER BY {$order_by} ASC ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - LIST SHOW IMAGE  ==============================================================
    function get_all_images($order_by) {
        global $dbc;
        $query = " SELECT i.image_id, t.type_name, i.image, i.title, i.status,  ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
        $query .= " DATE_FORMAT(i.create_date, '%b %d %Y') AS date ";
        $query .= " FROM tblimages AS i ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING(user_id) ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING(type_id) ";
        $query .= " ORDER BY {$order_by} ASC ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - LIST SHOW VIDEO  ==============================================================
    function get_all_videos($order_by) {
        global $dbc;
        $query = " SELECT v.video_id, t.type_name, v.url_video, v.thumbnail, v.title, v.description, v.status,  ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
        $query .= " DATE_FORMAT(v.create_date, '%b %d %Y') AS date ";
        $query .= " FROM tblvideos AS v ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING(user_id) ";
        $query .= " INNER JOIN tbltypes AS t";
        $query .= " USING(type_id) ";
        $query .= " ORDER BY {$order_by} ASC ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - LIST SHOW NEW  ===============================================================
    function get_list_user() {
        global $dbc;
        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS name, ";
        $query .= " DATE_FORMAT(date_of_birth, '%b %d %Y') AS birthday, ";
        $query .= " DATE_FORMAT(registration_date, '%b %d %Y') AS date ";
        $query .= " FROM tblusers WHERE (user_level = 1 OR user_level = 9) ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - DELETE NEWS - GAMES ============================================================
    function delete_news_games($nid) {
        global $dbc;
        $query = "DELETE FROM tblnews WHERE news_id = {$nid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - DELETE IMAGE  ===================================================================
    function delete_images($iid) {
        global $dbc;
        $query = "DELETE FROM tblimages WHERE image_id = {$iid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - DELETE VIDEO  ===================================================================
    function delete_videos($vid) {
        global $dbc;
        $query = "DELETE FROM tblvideos WHERE video_id = {$vid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - EDIT - NEWS - GAMES  ============================================================
    function edit_news_games($nid, $title, $type_id, $myAvatar, $myBanner, $content, $status) {
        global $dbc;
        $query = "UPDATE tblnews SET ";
        $query .=" title = '{$title}', ";
        $query .=" type_id = '{$type_id}', ";
        $query .=" image = '{$myAvatar}', ";
        $query .=" banner = '{$myBanner}', ";
        $query .=" content = '{$content}', ";
        $query .=" status = '{$status}', ";
        $query .=" user_id = 1, ";
        $query .=" update_date = NOW() ";
        $query .=" WHERE news_id = {$nid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - EDIT - IMAGE ===================================================================
    function edit_image($iid, $title, $type_id, $myImage, $status) {
        global $dbc;
        $query = "UPDATE tblimages SET ";
        $query .=" title = '{$title}', ";
        $query .=" type_id = '{$type_id}', ";
        $query .=" image = '{$myImage}', ";
        $query .=" status = '{$status}', ";
        $query .=" user_id = 1, ";
        $query .=" update_date = NOW() ";
        $query .=" WHERE image_id = {$iid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - EDIT - VIDEO ===================================================================
    function edit_video($vid, $type_id, $title, $description, $status) {
        global $dbc;
        $query = "UPDATE tblvideos SET ";
        $query .=" title = '{$title}', ";
        $query .=" type_id = '{$type_id}', ";
        $query .=" title = '{$title}', ";
        $query .=" description = '{$description}', ";
        $query .=" status = '{$status}', ";
        $query .=" user_id = 1, ";
        $query .=" update_date = NOW() ";
        $query .=" WHERE video_id = {$vid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - SHOW IMAGE =====================================================================
    function get_image_by_id($iid) {
        global $dbc;
        $query = "SELECT i.image_id, t.type_name, i.image, i.title, i.status, ";
        $query .=" DATE_FORMAT( i.create_date, '%b %d, %Y') AS date, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $query .=" FROM tblimages AS i ";
        $query .=" INNER JOIN tblusers AS u ";
        $query .=" USING ( user_id ) ";
        $query .=" INNER JOIN tbltypes AS t ";
        $query .=" USING ( type_id ) ";
        $query .=" WHERE i.image_id= {$iid} ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }


    //  BACKEND - SHOW VIDEO =====================================================================	
    function get_video_by_id($vid) {
        global $dbc;
        $query = "SELECT v.video_id, t.type_name, v.title, v.thumbnail, v.url_video, v.description, v.status, ";
        $query .=" DATE_FORMAT( v.create_date, '%b %d, %Y') AS date, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $query .=" FROM tblvideos AS v ";
        $query .=" INNER JOIN tblusers AS u ";
        $query .=" USING ( user_id ) ";
        $query .=" INNER JOIN tbltypes AS t ";
        $query .=" USING ( type_id ) ";
        $query .=" WHERE v.video_id= {$vid} ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }


    //  BACKEND - get id youtube =====================================================================	
    function youtube_id_from_url($url) {
        $pattern = '%^# Match any youtube URL
                (?:https?://)?  # Optional scheme. Either http or https
                (?:www\.)?      # Optional www subdomain
                (?:             # Group host alternatives
                  youtu\.be/    # Either youtu.be,
                | youtube\.com  # or youtube.com
                  (?:           # Group path alternatives
                    /embed/     # Either /embed/
                  | /v/         # or /v/
                  | /watch\?v=  # or /watch\?v=
                  )             # End path alternatives.
                )               # End host alternatives.
                ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
                $%x'
        ;
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches;
        }
        return false;
    }

    //  BACKEND - get id youtube =====================================================================	
    function save_thumbnail_from_url($url, $name) {
        $ch = curl_init($url);
        $fp = fopen('../images/thumbnails/' . $name . '.jpg', 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        return $name . '.jpg';
    }

    //  BACKEND - LIST SHOW NEW  ===============================================================
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

    //  BACKEND - LIST SHOW NEW  ===============================================================
    function is_logged_in() {
        if (!isset($_SESSION['uid'])) {
            redirect_to('admin/login-admin.php');
        }
    }

    //  BACKEND - LIST SHOW NEW  ===============================================================
    function login_user($username, $password) {
        global $dbc;
        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS fullname ";
        $query .= " FROM tblusers WHERE username = '{$username}' AND password = SHA1('$password') ";
        $query .= " AND status = 1 LIMIT 1 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  FRONTEND - SHOW COMMENT  ===============================================================
    function show_comment($nid) {
        global $dbc;
        $query = " SELECT author, comment, user_id, "
                . " DATE_FORMAT(comment_date, '%b %d, %y') AS date "
                . " FROM tblcomment "
                . " WHERE news_id ='{$nid}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // Register - 
    function register($username, $password, $email, $firstname, $lastname, $dateofbirth, $gender) {

        global $dbc;

        $query = "INSERT INTO tblusers (username, password, email, first_name, last_name, date_of_birth, gender, status, registration_date) ";
        $query .= " VALUES ('{$username}', SHA1('$password'), '{$email}', '{$firstname}', '{$lastname}', '{$dateofbirth}', '{$gender}', '0', NOW())";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // Change Pass - 
    function checkOldPass($password, $user_id){
        global $dbc;
        $query = "SELECT * FROM tblusers WHERE password = SHA1('{$password}') AND user_id = '{$user_id}' LIMIT 1";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    
    function changePass($password, $user_id) {
        global $dbc;
        $query = " UPDATE tblusers SET password = SHA1('{$password}') WHERE user_id = '{$user_id}' LIMIT 1";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;   
    }
    
    function get_user_by_id($uid) {
        global $dbc;
        $query = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS fullname ";
        $query .= " FROM tblusers WHERE user_id = {$uid} ";
        $query .= " AND status = 1 LIMIT 1 ";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
}

    function get_newest($start, $display) {
        global $dbc;
        
        $query = "SELECT n.news_id, n.title, n.content, n.banner, n.image, t.type_name, n.status, ";
        $query .= " DATE_FORMAT( n.create_date, '%b') AS month, ";
        $query .= " DATE_FORMAT( n.create_date, '%d') AS day, ";
        $query .= " DATE_FORMAT( n.create_date, '%b %d, %Y') AS date, ";
        $query .= " COUNT(c.comment_id) AS count, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING ( user_id ) ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " INNER JOIN tblcategories AS cat ";
        $query .= " USING ( cat_id ) ";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY n.create_date DESC LIMIT {$start}, {$display} ";
        
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    function get_topmonth($start, $display) {
        global $dbc;
        
        $query = "SELECT n.news_id, n.title, n.content, n.banner, n.image, t.type_name, n.status, ";
        $query .= " DATE_FORMAT( n.create_date, '%b') AS month, ";
        $query .= " DATE_FORMAT( n.create_date, '%d') AS day, ";
        $query .= " DATE_FORMAT( n.create_date, '%b %d, %Y') AS date, ";
        $query .= " COUNT(n.news_id) AS record, ";
        $query .= " COUNT(c.comment_id) AS count, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING ( user_id ) ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " INNER JOIN tblcategories AS cat ";
        $query .= " USING ( cat_id ) ";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 AND n.create_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY count DESC LIMIT  {$start}, {$display}";
        
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    
    function get_top_week($start, $display) {
        global $dbc;
        
        $query = "SELECT n.news_id, n.title, n.content, n.banner, n.image, t.type_name, n.status, ";
        $query .= " DATE_FORMAT( n.create_date, '%b') AS month, ";
        $query .= " DATE_FORMAT( n.create_date, '%d') AS day, ";
        $query .= " DATE_FORMAT( n.create_date, '%b %d, %Y') AS date, ";
        $query .= " COUNT(n.news_id) AS record, ";        
        $query .= " COUNT(c.comment_id) AS count, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING ( user_id ) ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " INNER JOIN tblcategories AS cat ";
        $query .= " USING ( cat_id ) ";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 AND n.create_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY count DESC LIMIT  {$start}, {$display} ";
        
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    function get_news_type($type, $start, $display) {
        global $dbc;
        
        $query = "SELECT n.news_id, n.title, n.content, n.banner, n.image, t.type_name, n.status, ";
        $query .= " DATE_FORMAT( n.create_date, '%b') AS month, ";
        $query .= " DATE_FORMAT( n.create_date, '%d') AS day, ";
        $query .= " DATE_FORMAT( n.create_date, '%b %d, %Y') AS date, ";
        $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id, ";
        $query .= " COUNT(n.news_id) AS record, ";
        $query .= " COUNT(c.comment_id) AS count ";
        $query .= " FROM tblnews AS n ";
        $query .= " INNER JOIN tblusers AS u ";
        $query .= " USING ( user_id ) ";
        $query .= " INNER JOIN tbltypes AS t ";
        $query .= " USING ( type_id ) ";
        $query .= " INNER JOIN tblcategories AS cat ";
        $query .= " USING ( cat_id ) ";
        $query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
        $query .= " WHERE cat.cat_name = 'News' AND n.status = 1 AND t.type_name = '{$type}' ";
        $query .= " GROUP BY n.title ";
        $query .= " ORDER BY n.create_date DESC LIMIT  {$start}, {$display} ";
             
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;

    }
        
    
    function get_type() {
        global $dbc;
        
        $query = "SELECT t.type_id, t.type_name, c.cat_name FROM tbltypes AS t INNER JOIN tblcategories AS c USING (cat_id)";
                 
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
}

    function get_tag() {
        global $dbc;
        
        $query = "SELECT * FROM tbltags ORDER BY tag_id ASC";
                 
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
}

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
    
    function change_status_news($nid, $stt){
        global $dbc;
        
        if($stt == 1){
            $status = 0;
        }else {
            $status = 1;
        }
        
        $query = " UPDATE tblnews SET status = {$status} WHERE news_id = {$nid} LIMIT 1";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;   
    }
    
        function change_status_video($vid, $stt){
        global $dbc;
        if($stt == 1){
            $status = 0;
        }else {
            $status = 1;
        }
        $query = " UPDATE tblvideos SET status = {$status} WHERE video_id = {$vid} LIMIT 1";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;   
    }
    
        function change_status_image($iid, $stt){
        global $dbc;
        if($stt == 1){
            $status = 0;
        }else {
            $status = 1;
        }
        $query = " UPDATE tblimages SET status = {$status} WHERE image_id = {$iid} LIMIT 1";
        
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;   
    }
    