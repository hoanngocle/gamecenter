<!--#####################################################################
    #
    #   File          : PLAYLIST VIDEO
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
<div class="container">
    <div class="content-top" style="padding-top: 1.3em">
        <div class="video_embed" style="width: 125%; height: 510px; left: -150px; position: relative;">
            <div class="col-lg-8" id="embed_player" style="left: 19%; margin: auto ;" >
                <?php
                    if(isset($_GET['vid'])){
                        $vid = $_GET['vid'];
                        $result = get_video_by_id($vid);
                        if(mysqli_num_rows($result) > 0 ){
                            $video = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        }
                    }
                ?>
                <video id="example_video_1" class="video-js vjs-default-skin" controls
                    preload="auto" width="854" height="480"
                    poster=""
                    data-setup='{"techOrder":["youtube"], "src":"<?= $video['url_video'] ?>"}' >
                </video>
            </div>
        </div>
        <div class="title-video-player col-lg-8">
            <div class="title-video-player col-lg-12" style="float: left; margin-bottom: 1vw; background-color: #F1F1F1">
                <h3 style="margin-bottom: 1vw; padding-top: 1vw; "><?= $video['title'] ?></h3>
                <div class="col-lg-2" style="width: 12%; margin: 0 0 1vw -1vw;">
                    <img id="img_video" src="../images/avatar/ava_admin.jpg">
                </div>
                <div class="col-lg-10">
                    <p class="text-des"><a href="#"><?= $video['name']; ?></a> in <a href="#"><?= $video['type_name']; ?></a></p>
                    <p class="text-des"><?= $video['date'] ?></p>
                </div>
            </div>
            <div class="col-lg-12"  style=" background-color: #F1F1F1; margin-bottom: 1vw;">
                <h3 style="margin-bottom: 1vw; padding-top: 1vw;  "><?= $lang['ADD_VIDEO_FORM_DES'] ?></h3>
                <p class="text-des" style="font-size: 1em;"><?= $video['description']; ?></p>
            </div>
            <div class="col-lg-12"  style=" background-color: #F1F1F1; ">
                <h3 style="margin-bottom: 1vw; padding-top: 1vw;  "><?= $lang['Comments'] ?></h3>
                <p class="text-des" style="font-size: 1em;">
                    For most young people, playing games on a computer, video game console, or handheld device is just a regular part of the day. Most are able to juggle the multiple demands of school, sports, work or chores, and family life. Gaming becomes an addiction when it starts to interfere with a person's relationships or their pursuit of other goals, such as good grades or being a contributing member of a sports team.<br>
<br>
                    Computer and video games, especially the massive multi-online role-playing games (or MMORPGs) such as "World of Warcraft," allow players to behave very differently from their normal persona. A shy child can suddenly became gregarious; a passive child can become aggressive. <br>
<br>
                    Young people, who often feel powerless in their daily lives, suddenly have the ability to command armies, drive (and crash) cars, and wreak havoc on a virtual world with no real-life consequences. This is seductive! <br>
<br>
 </p>
            </div>
        </div>

        <div class="col-lg-4" style="float: right;  margin-bottom: 30px; background-color: #F1F1F1">
            <ul>
             <?php
                $result = get_thumbnail_row();
                if (mysqli_num_rows($result) > 0 ) {
                    while ($video = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            ?>
                <li class="item-row-1" style="width: 100%; padding-left: 0px;">
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