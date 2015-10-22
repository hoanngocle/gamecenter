    <!--#####################################################################
        #
        #   File          : Comment Form in Single page  
        #   Project       : Game Magazine Project
        #   Author        : Béo Sagittarius
        #   Created       : 07/01/2015
        #   Last Change   : 10/14/2015
        #
        ##################################################################### -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array(); //tao bien luu loi
        var_dump($_POST);die;
        $author = $_SESSION['fullname'];
        $uid = $_SESSION['uid'];
        // Validate comment
        if (!empty($_POST['comment'])) {
            $comment = mysqli_real_escape_string($dbc, $_POST['comment']);
        } else {
            $errors[] = "comment";
        }

        if (empty($errors)) {
            // neu ko co loi xay ra thi them comment vao co so du lieu

            $query = "INSERT INTO tblcomment (news_id, author, comment, comment_date, user_id) VALUES ({$nid}, '{$author}','{$comment}', NOW(), {$uid})";
            $result = mysqli_query($dbc, $query);
            confirm_query($result, $query);

            // kiem tra xem co them thanh cong hay khong
            if (mysqli_affected_rows($dbc) == 1) {
                // Success
                $messages = "<p class='success'>The category was added successfully!</p>";
            } else { // Fail
                $messages = "<p class='warning'>Could not added to the database due to a system error!</p>";
            }
        } else { // Error
            $messages = "<p class='error'>Please fill all the required fields!</p>";
        }
    } // END main IF submit condition
    ?>

    <?php
    // Show comment from Database
    $result = show_comment($nid);
    if (($count = mysqli_num_rows($result)) > 0) {
        // Neu co comment de hien thi ra trinh duyet
        ?>		
        <div class='single-middle'>
            <h3><?= $count ?> Comment</h3>
        <?php
        while (list($author, $comment, $user_id, $date) = mysqli_fetch_array($result, MYSQLI_NUM)) {
        ?>
                <div class='media'>
                    <div class='media-left'>
                        <img class='media-object' src='images/co.png' alt=''>
                    </div>
                    <div class='media-body'>
                        <h4 class='media-heading'><?= $author ?></h4>
                        <h6><?= $date ?></h6>
                        <p><?= $comment ?></p>
                    </div>
                </div>
        <?php } ?>
        </div>
        <?php
        } else {

        } // END if(mysqli_num_rows)
        ?>

    <?php if (!empty($messages)) echo $messages; ?>
    <?php 
        if(isset($_SESSION['uid'])){
        ?> 
    <div class="single-bottom">
        <h3>Leave A Comment</h3>
        <form id="comment-form" action="" method="post">
            <div id="comment">
                <textarea id="comment" name="comment"  rows="4" style="min-height: 90px"value="<?php if (isset($_POST['comment'])) {
                           echo htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8');
                       } ?>" tabindex="3" id="comment" name="comment" placeholder="Write a comment..."></textarea>
                       
                <?php
                if (isset($errors) && in_array('comment', $errors)) {
                    echo "<p class='warning'>Please fill in the comment!</p>";
                }
                ?>
            </div>
            <input type="submit" name="submit" value="Send" >

        </form>
    </div>           
    <?php
        }
    ?>
    