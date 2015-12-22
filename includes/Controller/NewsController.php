<?php
    #####################################################################
    #
    #   File          : NEW CONTROLLER
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    #####################################################################
    /*  GET 1 NEW by ID
    *   FRONT-END: single.php
    *   BACK-END : show_game ; show_news
    */
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

    //  FRONTEND - GET 8 NEW GAME - index.php =================================================================
    function get_new_games() {
        global $dbc;

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

    //  FRONTEND - GET GAMES =================================================================
    function get_games() {
        global $dbc;

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

    //  FRONTEND - BEST FEATURE - IMAGE =====================================================
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

    //  FRONTEND - NEWEST - bai viet moi nhat ========================================
    function get_newest_news() {
        global $dbc;

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
        $query .= " ORDER BY n.create_date DESC LIMIT 3 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  FRONTEND - HOTEST - in 1 month =============================================
    function get_hotest_news() {
        global $dbc;

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

    //  FRONTEND : TOP IN 1 WEEK ===================================================
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

    //  FRONTEND : GET NEWS BY TYPE ===============================================
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

    //  FRONTEND : GET GAME BY TYPE ===================================================
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
        $query .= " ORDER BY date DESC LIMIT 5 ";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - GET LIST NEWS ===============================================================
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

    //  BACKEND - DELETE NEWS - GAMES ============================================================
    function delete_news_games($nid) {
        global $dbc;
        $query = "DELETE FROM tblnews WHERE news_id = {$nid} LIMIT 1";

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

    //  FRONT-END: BLOG - NEWEST  ============================================================
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

    //  FRONT-END: BLOG - TOP MONTH  ============================================================
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

    //  FRONT-END: BLOG - TOP WEEK  ============================================================
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

    //  FRONT-END: BLOG - BY TYPE  ==============================================================
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

    //  BACK-END: CHANGE STATUS - NEWS ==============================================================
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

    //  FRONT-END: SEARCH NEWS ==============================================================
    function search($keyword) {
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
        $query .= " INNER JOIN tblcategories AS cat ";
        $query .= " USING ( cat_id ) ";
        $query .= " WHERE MATCH( title, content ) AGAINST('{$keyword}' WITH QUERY EXPANSION ) LIMIT 5";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END: ADD NEWS ==============================================================
    function addNews($uid, $type_id, $title, $myAvatar, $myBanner, $content, $status) {
        global $dbc;

        $query = "INSERT INTO tblnews ( user_id, type_id, title, image, banner, content, status, create_date) "
                . "VALUES ({$uid}, {$type_id}, '{$title}','{$myAvatar}','{$myBanner}','{$content}', '{$status}', NOW())";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END: VALIDATE - IMG NEWS ==============================================================
    function checkImgGame($img) {
        global $dbc;

        $query = "SELECT image "
                . "FROM tblnews "
                . "WHERE image = '{$img}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END: VALIDATE - BANNER NEWS ==============================================================
    function checkBannerGame($banner) {
        global $dbc;

        $query = "SELECT banner "
                . "FROM tblnews "
                . "WHERE banner = '{$banner}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END: GET NEWS ==============================================================
    function get_news_item($nid) {
        global $dbc;

        $query = "SELECT * FROM tblnews WHERE news_id = {$nid}";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END: GET GAME ==============================================================
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

    //  BACKEND - ADD GAME ===============================================================
    function addGames($uid, $type_id, $title, $myAvatar, $myBanner, $content, $status) {
        global $dbc;

        $query = "INSERT INTO tblnews ( user_id, type_id, title, image, banner, content, status, create_date) "
                . "VALUES ({$uid}, {$type_id}, '{$title}','{$myAvatar}','{$myBanner}','{$content}', '{$status}', NOW())";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    
    //  BACKEND - ADD GAME ===============================================================
    function get_last_rc() {
        global $dbc;
        $query = "SELECT news_id FROM tblnews ORDER BY news_id DESC LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    } 

