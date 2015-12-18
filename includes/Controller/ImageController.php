<?php
	// FRONT-END - GET BANNER ==================================================================
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

    // FRONTEND : first-img in gallery - index ========================================
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

    // FRONTEND : image in row in gallery - index ========================================
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

    //  BACKEND - DELETE IMAGE  ===================================================================
    function delete_images($iid) {
        global $dbc;
        $query = "DELETE FROM tblimages WHERE image_id = {$iid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - EDIT - IMAGE ===================================================================
    function edit_image($iid, $title, $type_id, $status) {
        global $dbc;
        $query = "UPDATE tblimages SET ";
        $query .=" title = '{$title}', ";
        $query .=" type_id = '{$type_id}', ";
        $query .=" status = '{$status}', ";
        $query .=" user_id = 1, ";
        $query .=" update_date = NOW() ";
        $query .=" WHERE image_id = {$iid} LIMIT 1";

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

    //  BACKEND - CHANGE STATUS IMAGE =====================================================================
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

    //  BACKEND - VALIDATE CHECK IMAGE =====================================================================
    function checkImage($img) {
        global $dbc;
        $query = "SELECT image "
                . "FROM tblimages "
                . "WHERE image = '{$img}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND - ADD IMAGE =====================================================================
    function addImage($uid, $type_id, $title, $myImage, $status) {
        global $dbc;

        $query = "INSERT INTO tblimages (user_id, title, type_id, image, status, create_date )
						VALUES ({$uid}, '{$title}', {$type_id}, '{$myImage}', '{$status}', NOW())";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
}

    //  BACKEND - GET IMAGE ITEM =================================================================
    function get_image_item($iid) {
        global $dbc;

        $query = "SELECT * FROM tblimages WHERE image_id = {$iid}";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
