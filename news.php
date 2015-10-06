<!-- goi file chua header -->
<?php
    //Include file php function vs connect DB
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');

    include('includes/frontend/header.php');
?>

<!--content-->
<div class="review">
    <div class="container">
        <h2 >News</h2>
        <?php
        $rs = get_type();
        if (mysqli_num_rows($rs) > 0) {
            while ($types = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                $type_name = $types['type_name'];
                ?>
                <div class="review-md1">                   
                    <h3 class="new"><?= $type_name ?></h3>
                    <br><br>
                    <?php
                    $result = get_news_by_type($type_name);
                    if (mysqli_num_rows($result) > 0) {
                        while ($news = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            ?>
                            <div class="col-md-4 sed-md">
                                <div class=" col-1">
                                    <a href="single.php?nid=<?= $news['news_id'] ?>"><img class="img-responsive" style="width: 322px; height: 322px;" src="images/<?= $news['image'] ?>" alt=""></a>
                                    <h4><a href="single.php?nid=<?= $news['news_id'] ?>"><?= $news['title'] ?></a></h4>
                                    <p><?= strip_tags(excerpt_news_content($news['content'])) ?>...</p>
                                </div>
                            </div>
                    
                            <?php
                        }
                    }
                    ?>
                    </div>
            <?php 
                }
            }
            ?>          
                <div class="clearfix"> </div>
            </div>
        </div>
    <!-- goi file chua header -->
<?php include('includes/frontend/footer.php'); ?>