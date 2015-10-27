<?php

    session_start();
    $author = $_SESSION['fullname'];
    $uid = $_SESSION['uid'];
    // Validate comment
    if (!empty($_POST['comment'])) {
        $comment = mysqli_real_escape_string($dbc, $_POST['comment']);

        $query = "INSERT INTO tblcomment (news_id, author, comment, comment_date, user_id) VALUES ({$nid}, '{$author}','{$comment}', NOW(), {$uid})";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        // kiem tra xem co them thanh cong hay khong
        if (mysqli_affected_rows($dbc) == 1) {
            // Success
        } else { // Error
            $messages = "<p class='error'>Please fill all the required fields!</p>";
        }

    }
    