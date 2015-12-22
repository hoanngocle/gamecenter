<?php
    #####################################################################
    #
    #   File          : ALL FUNCTION
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    #####################################################################
    session_start();
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];

        $_SESSION['lang'] = $lang;
        setcookie('lang', $lang, time() + (3600 * 24 * 30));

    } else if(isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else if(isset($_COOKIE['lang'])) {
        $lang = $_COOKIE['lang'];
    } else {
        $lang = 'en';
    }

    switch ($lang) {
        case 'en':
            $lang_file = 'lang.en.php';
            break;

        case 'vi':
            $lang_file = 'lang.vi.php';
            break;

        default:
            $lang_file = 'lang.en.php';
    }
    include_once 'languages/' . $lang_file;

    // INCLUDE CONTROLLER
    include('Controller/Utility.php');
    include('Controller/ImageController.php');
    include('Controller/NewsController.php');
    include('Controller/TagController.php');
    include('Controller/TypeController.php');
    include('Controller/VideoController.php');
    include('Controller/UserController.php');