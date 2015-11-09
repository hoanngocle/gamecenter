<?php
    // Show comment from Database
    $result = show_comment($nid);
    if (($count = mysqli_num_rows($result)) > 0) {
        ?>		
        <div class='single-middle'>
            <h3><?= $count ?> Comment</h3>
        <?php
        while (list($author, $comment, $user_id, $date) = mysqli_fetch_array($result, MYSQLI_NUM)) {
        ?>
            <div class='media'>
                <div class='media-left'>
                    <img class='media-object' src='images/avatar/co.png' alt=''>
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
    }
    ?>

    <?php 
        if(isset($_SESSION['uid'])){
    ?> 
    <div class="single-bottom">
        <h3>Leave A Comment</h3>
        <form name="comment-form" id="comment-form" action="comment.php" method="POST">
            <div id="comment">
                <input type="hidden" id="newid" name="newid" value="<?= $_GET['nid']?>">
                <textarea id="comment" name="comment"  rows="4" style="min-height: 90px" tabindex="3" id="comment" name="comment" placeholder="Write a comment..."></textarea>
                <button type="submit" class="btn btn-success btn-lg btn-block" style="margin: auto; width: 20%;">Send</button>
            </div>
        </form>
    <script type="text/javascript" src="/js/comment.js"></script> 
    </div>           
    <?php
        }
    ?>
    