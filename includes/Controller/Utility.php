<?php
    #####################################################################
    #
    #   File          : UTILITY
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    #####################################################################
    // DEFINE CONSTANT URL
    define('BASE_URL', 'http://www.gamecenter.dev/');
    define('LIVE', FALSE); // FALSE - DEV | TRUE - PRODUCTION

    // UTILITY - CONFIRM QUERY =================================================================
    function confirm_query($result, $query) {
        global $dbc;

        if (!$result && !LIVE) {
            die("Query {$query} \n <br> MySQL Error: " . mysqli_error($dbc));
        }
    }

    // UTILITY - CUSTOM ERROR HANDLER =================================================================
    function custom_error_handler($e_number, $e_message, $e_files, $e_line, $e_vars) {
        $message = "<p class='warning'>Some error in file: {$e_files} - in row {$e_line}: {$e_message} \n";

        if(!LIVE) {
            // In DEV
            echo "<pre>". $message ."</pre><br/>\n";
        } else {
            // LIVE in host
            echo "<p class='warning'>Oops! something went wrong, we are so sorry for the inconvenice.</p>";
        }
    }

    // call function error handler
    set_error_handler('custom_error_handler');

    // UTILITY - REDIRECT =================================================================
    function redirect_to($page = 'index.php') {
        $url = BASE_URL . $page;
        header("Location: {$url}");
        exit();
    }

    //  UTILITY - auto generate password =======================================================
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

    //  UTILITY - EXCERPT ==========================================================
    function excerpt_news_content($sanitized) {
        if (strlen($sanitized) > 100) {
            $cutString = substr($sanitized, 0, 200);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
    }

    //  UTILITY - EXCERPT ==========================================================
    function excerpt($sanitized) {
        if (strlen($sanitized) > 800) {
            $cutString = substr($sanitized, 0, 700);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
    }

    //  UTILITY - EXCERPT FEATURE ==========================================================
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

    // UTILITY - CREATE PARAGRAPH==========================================================
    function the_content($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        return str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $sanitized);
    }

    // UTILITY - VALIDATE ID ===============================================================
    function validate_id($id) {
        if (isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $val_id = $id;
            return $val_id;
        } else {
            return null;
        }
    }

    //  UTILITY - SHOW COMMENT  ===============================================================
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
