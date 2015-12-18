<!--#####################################################################
    #
    #   File          : CONNECT TO DATABASE
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    //Connect to database
    $dbc = mysqli_connect('localhost', 'root', '', 'gamecenter');
    // if connect failed
    if (!$dbc) {
        trigger_error("Could not connect to DB: " . mysqli_connect_error());
    } else {
        // set parameter UTF-8
        mysqli_set_charset($dbc, 'utf-8');
    }
    mysqli_query($dbc, "SET NAMES utf8");
