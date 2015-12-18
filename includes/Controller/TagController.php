<?php
    // BACK-END : GET TAG BY ID
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

    //  BACKEND : EDIT TAG ===================================================================
    function edit_tag($tid, $keyword) {
        global $dbc;

        $query = "UPDATE tbltags SET ";
        $query .=" keyword = '{$keyword}' ";
        $query .=" WHERE tag_id = {$tid} LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND : GET TAG ===================================================================
    function get_tag() {
        global $dbc;

        $query = "SELECT * FROM tbltags ORDER BY tag_id ASC";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
	}

    //  BACKEND : ADD TAG ===================================================================
    function addTag($keyword) {
        global $dbc;

        $query = "INSERT INTO tbltags (keyword) "
                . "VALUES ('{$keyword}')";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    //  BACKEND : GET TAG ITEM ===================================================================
    function get_tag_item($tid) {
        global $dbc;

        $query = "SELECT * FROM tbltags WHERE tag_id = {$tid}";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    //  BACKEND : GET TAG ITEM BY KEY ===================================================================
    function get_tag_item_by_key($key) {
        global $dbc;

        $query = "SELECT keyword FROM tbltags WHERE keyword = '{$key}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    
    //  BACKEND : ADD TAG DATA ===================================================================
    function add_tag_data($nid, $tid) {
        global $dbc;

        $query = "INSERT INTO tbltag_data (news_id, tag_id) VALUES ($nid, $tid)";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    
    //  BACKEND : ADD TAG DATA ===================================================================
    function get_last_rc_tag() {
        global $dbc;

        $query = "SELECT tag_id FROM tbltags ORDER BY tag_id DESC LIMIT 1";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }
    
    //  BACKEND : GET TAG ITEM BY KEY ===================================================================
    function get_tag_id_by_key($key) {
        global $dbc;

        $query = "SELECT tag_id FROM tbltags WHERE keyword = '{$key}'";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }