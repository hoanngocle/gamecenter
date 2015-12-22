<?php
    #####################################################################
    #
    #   File          : TYPE CONTROLLER
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    #####################################################################

    // BACK-END : GET TYPE
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

    // BACK-END : GET TYPE BY ID ========================================
    function get_type_by_id($tid) {
        global $dbc;
        $query = "SELECT * FROM tbltypes WHERE cat_id = 3 AND type_id = '{$tid}' ORDER BY type_id ASC";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
    }

    // BACK-END : GET TYPE  ========================================
    function get_type() {
        global $dbc;

        $query = "SELECT t.type_id, t.type_name, c.cat_name FROM tbltypes AS t INNER JOIN tblcategories AS c USING (cat_id)";

        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
	}

    // BACK-END : ADD TYPE  ========================================
    function addType($type_name, $cat) {
        global $dbc;

        $query = "INSERT INTO tbltypes (type_name, cat_id) "
                . "VALUES ('{$type_name}', $cat)";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        return $result;
	}