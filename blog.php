<!--#####################################################################
    #
    #   File          : BLOG NEWS
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
        <h2><?php echo ucfirst($_GET['t']) ?></h2>
        <div class="single-inline">
            <?php
            if (isset($_GET['t'])) {
                $display = 4;
                $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

                $type = $_GET['t'];
                switch ($type) {
                    case 'newest':
                        $result = get_newest($start, $display);
                        break;

                    case 'topmonth':
                        $result = get_topmonth($start, $display);
                        break;

                    case 'topweek':
                        $result = get_topweek($start, $display);
                        break;

                    case 'eSport':
                        $result = get_news_type($type, $start, $display);
                        break;

                    case 'news':
                        $result = get_news_type($type, $start, $display);
                        break;

                    case 'review':
                        $result = get_news_type($type, $start, $display);
                        break;

                    default:
                        $result = get_news_type($type, $start, $display);
                        break;
                }
                $posts = array(); // create array to save data
                $title = $type;

                if (mysqli_num_rows($result) > 0) {
                    while ($news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $record = mysqli_num_rows($result);
                        $posts = array(
                            'news_id' => $news['news_id'],
                            'banner' => $news['banner'],
                            'day' => $news['day'],
                            'month' => $news['month'],
                            'title' => $news['title'],
                            'post_by' => $news['name'],
                            'type_name' => $news['type_name'],
                            'count' => $news['count'],
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
                        <p>Posted by <a href="single.php?nid=<?= $posts['news_id'] ?>"><?= $posts['post_by'] ?></a> in <a href="#"><?= $posts['type_name'] ?></a> | <a href="single.php?nid=<?= $posts['news_id'] ?>"><?= $posts['count'] ?> Comments</a></p>
                        <p class="sed"><?php echo excerpt($posts['content']) ?></p>
                        <br>
                        <a  href="single.php?nid=<?= $posts['news_id'] ?>" class="more">Readmore<span> </span></a>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <?php
                    }
                }
            } else {
                //if dont have nid, redirect user
                redirect_to('404.php');
            }
            ?>
            <!--Pagination [start]-->
            <nav>
                <ul class="pagination">
                    <?php
                    if (isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                        $page = $_GET['p'];
                    } else {
                        $record = 20;
                        if ($record > $display) {
                            $page = ceil($record / $display);
                        } else {
                            $page = 1;
                        }
                    }

                    if ($page > 1) {
                        $current_page = ($start / $display) + 1;

                        if ($current_page != 1) {
                            ?>
                            <li><a href='blog.php?t=<?= $_GET['t'] ?>&s=<?= $start - $display ?>&p=<?= $page ?>' aria-hidden="true">«</span></a></li>
                            <?php
                        }

                        for ($i = 1; $i <= $page; $i++) {
                            if ($i != $current_page) {
                                ?>
                                <li><a href="blog.php?t=<?= $_GET['t'] ?>&s=<?= $display * ($i - 1) ?>&p=<?= $page ?>"><span><?= $i ?></span></a></li>
                                <?php
                            } else {
                                ?>
                                <li><span><?= $i ?></span></li>
                                <?php
                            }
                        }

                        if ($current_page != $page) {
                            ?>
                                <li><a href='blog.php?t=<?= $_GET['t'] ?>&s=<?= $start + $display ?>&p=<?= $page ?>' aria-hidden="true"><span>»</span></a></li>

                            <?php
                        }
                    }
                    ?>
                </ul>
            </nav>
            <!--Pagination [end]-->
        </div>
    </div>
</div>
<?php include('includes/frontend/footer.php'); ?>