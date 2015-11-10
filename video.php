
<?php
    //Include file php function vs connect DB
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');

    include('includes/frontend/header.php');
?>
<div class="container">
     <div class="content-top">       
        <div class="video_embed" style="width: 125%; height: 510px; left: -150px; position: relative;">
            <div class="col-lg-8" id="embed_player" style="margin: auto" >
                <video style=" left: 33%;"id="example_video_1" class="video-js vjs-default-skin" controls 
                    preload="auto" width="854" height="480"
                    poster="" 
                    data-setup='{"techOrder":["youtube"], "src":"<?= $url_video ?>"}' >
                </video>      
            </div>  
        </div>
         <div class="col-lg-6" style="float: left">
             meo
             
         </div>
         <div class="col-lg-4" style="float: right">
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