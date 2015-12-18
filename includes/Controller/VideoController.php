<?php
    // FRONT-END : GET FIRST THUMBNAIL IN VIDEO
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

    // FRONTEND : GET ROW THUMBNAIL IN VIDEO  ========================================
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

    //  BACK-END - LIST SHOW VIDEO  ==============================================================
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

    //  BACK-END : DELETE VIDEO  ===================================================================
    function delete_videos($vid) {
        global $dbc;

        $query = "DELETE FROM tblvideos WHERE video_id = {$vid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

   	//  BACK-END : EDIT - VIDEO ===================================================================
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

    //  BACK-END - GET VIDEO BY ID =====================================================================
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

    //  BACK-END : get information video youtube =====================================================================
    function get_youtube($id){

        $youtube = "http://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=". $id ."&format=json";

        $curl = curl_init($youtube);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return json_decode($return, true);

        }

    //  BACK-END : get thumbnail from url youtube =====================================================================
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

    //  BACK-END : CHANGE STATUS VIDEO =============================================================
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

    //  BACK-END : VALIDATE - checkID video =====================================================================
    function checkIDVideo($url) {
        global $dbc;

        $query = " SELECT * FROM tblvideos WHERE url_video = '{$url}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACK-END : ADD Video =====================================================================
    function addVideo($uid, $type_id, $title, $description, $thumbnail, $url_video, $status) {
        global $dbc;

        $query = "INSERT INTO tblvideos (user_id, title, type_id, description, thumbnail, url_video, status, create_date ) "
                . "VALUES ({$uid}, '{$title}', {$type_id}, '{$description}', '{$thumbnail}', '{$url_video}', '{$status}', NOW())";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
	}

    //  BACK-END : get VIDEO item =====================================================================
    function get_video_item($vid) {
        global $dbc;

        $query = "SELECT * FROM tblvideos WHERE video_id = {$vid}";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
