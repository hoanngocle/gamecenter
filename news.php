<!--#####################################################################
    #
    #   File          : NEWS
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
<div class="review">
    <div class="container">
        <h2 ><?= $lang['FRONT_MENU_NEWS'] ?></h2>
                <div class="review-md1">
                    <a href='blog.php?t=e-Sports' style="text-decoration: none"><h3 class="new" style="padding-bottom: 30px;"><?= $lang['FRONT_ESPORT']?></h3></a>
                    <?php
                    $result = get_news_by_type('e-Sports');
                    if (mysqli_num_rows($result) > 0) {
                        while ($news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    ?>
                    <div class="col-md-4 sed-md">
                        <div class=" col-1">
                            <a href="single.php?nid=<?= $news['news_id'] ?>"><img class="img-responsive" style="width: 322px; height: 322px;" src="images/news/<?= $news['image'] ?>" alt=""></a>
                            <h4><a href="single.php?nid=<?= $news['news_id'] ?>"><?= $news['title'] ?></a></h4>
                            <p><?= strip_tags(excerpt_news_content($news['content'])) ?>...</p>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="clearfix"> </div>
                <div class="review-md1">
                    <a href='blog.php?t=News' style="text-decoration: none"><h3 class="new" style="padding-bottom: 30px;"><?= $lang['FRONT_MENU_NEWS'] ?></h3></a>
                    <?php
                    $result = get_news_by_type('News');
                    if (mysqli_num_rows($result) > 0) {
                        while ($news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    ?>
                    <div class="col-md-4 sed-md">
                        <div class=" col-1">
                            <a href="single.php?nid=<?= $news['news_id'] ?>"><img class="img-responsive" style="width: 322px; height: 322px;" src="images/news/<?= $news['image'] ?>" alt=""></a>
                            <h4><a href="single.php?nid=<?= $news['news_id'] ?>"><?= $news['title'] ?></a></h4>
                            <p><?= strip_tags(excerpt_news_content($news['content'])) ?>...</p>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="clearfix"> </div>

                <div class="review-md1">
                    <a href='blog.php?t=Review' style="text-decoration: none"><h3 class="new" style="padding-bottom: 30px;"><?= $lang['FRONT_REVIEW']?></h3></a>
                    <?php
                    $result = get_news_by_type('Review');
                    if (mysqli_num_rows($result) > 0) {
                        while ($news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    ?>
                    <div class="col-md-4 sed-md">
                        <div class=" col-1">
                            <a href="single.php?nid=<?= $news['news_id'] ?>"><img class="img-responsive" style="width: 322px; height: 322px;" src="images/news/<?= $news['image'] ?>" alt=""></a>
                            <h4><a href="single.php?nid=<?= $news['news_id'] ?>"><?= $news['title'] ?></a></h4>
                            <p><?= strip_tags(excerpt_news_content($news['content'])) ?>...</p>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
<?php include('includes/frontend/footer.php'); ?>