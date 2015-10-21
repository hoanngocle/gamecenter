
<?php
    //Include file php function vs connect DB
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');

    include('includes/frontend/header.php');
?>
<div class="container">
     <div class="content-top">
        <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">NEW GAMES</h2></a>
        <div class="col-lg-8">
            <video id="example_video_1" class="video-js vjs-default-skin" controls 
                    preload="auto" width="720" height="405"
                    poster="" 
                    data-setup='{"techOrder":["youtube"], "src":"<?= $url_video ?>"}' >
                </video>
        
        </div>
        <div class="col-lg-4">
            <ul>
             <?php 
                $result = get_thumbnail_row();
                if (mysqli_num_rows($result) > 0 ) {
                    while ($video = mysqli_fetch_array($result, MYSQLI_ASSOC)){             
            ?>
                <li class="item-row-1" style="width: 100%; padding-left: 0px">
                <div class="col-lg-5">
                    <a href="playlist.php?vid=<?= $video['video_id'] ?>" ><img src="images/thumbnails/<?= $video['thumbnail']?>" alt="<?= $video['title']?>" width="120" height="90"></a>
                </div>
                <div class="col-lg-7">
                    <h5 class="title-video-row1"><?= $video['title']?></h5>
                </div>
            
            </li>
            <?php 
                    }
                }                                       
            ?> 
            </ul>
        </div>
     </div>
</div>
<?php include('includes/frontend/footer.php'); ?>