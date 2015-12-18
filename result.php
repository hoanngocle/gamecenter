<!--#####################################################################
    #
    #   File          : RESULT SEARCH
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');
    include('includes/frontend/header.php');
?>
<div class="blog">
    <div class="container">
        <h2><?= $lang['FRONT_RESULT'] ?> <?php if(isset($_GET['keyword'])) echo ": " .$_GET['keyword']; ?></h2>
        <div class="single-inline">
            <?php
            if (isset($_GET['keyword'])) {
                $keyword = $_GET['keyword'];

                $posts = array(); // create array to save data
                $title = "Search";

                $result = search($keyword);
                if (mysqli_num_rows($result) > 0) {
                    while ($news= mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $posts = array(
                            'news_id' => $news['news_id'],
                            'banner' => $news['banner'],
                            'day' => $news['day'],
                            'month' => $news['month'],
                            'title' => $news['title'],
                            'post_by' => $news['name'],
                            'type_name' => $news['type_name'],
                            'content' => $news['content'],
                        );
            ?>
            <div class="blog-to">
                <div class="blog-top">
                    <div class="blog-left">
                        <b><?= $posts['day'] ?></b>
                        <span><?= $posts['month'] ?></span>
                    </div>
                    <div class="top-blog">
                        <a class="fast" href="single.php?nid=<?= $posts['news_id'] ?>"><?= $posts['title'] ?></a>
                        <p><?= $lang['FRONT_VIDEO_POST_BY']?><a href="single.php?nid=<?= $posts['news_id'] ?>"><?= $posts['post_by'] ?></a> in <a href="#"><?= $posts['type_name'] ?></a></p>
                        <p class="sed"><?php echo excerpt($posts['content']) ?></p>
                        <br>
                        <a  href="single.php?nid=<?= $posts['news_id'] ?>" class="more"><?= $lang['READ_MORE']?><span> </span></a>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo $lang['FRONT_VIDEO_NEW_SINGLE'];
                }
            } else {
                redirect_to('404.php');
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/frontend/footer.php'); ?>