<?php 
    session_start();
    if(!isset($_SESSION['fullname'])){
        redirect_to('admin/login_admin.php');
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title><?php if(isset($title_page)) echo $title_page ?> - Game Magazine Manager </title>
    
    <!-- Css -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style-admin.css" rel="stylesheet" />
    <link rel="shortcut icon" href="http://s16.postimg.org/9irj2l7n5/gamemagazine.png">
    <link href="../includes/video-js/video-js.css" rel="stylesheet" type="text/css">
    
    <!-- Javascript -->
    <script src="assets/js/function.js"></script>
    <script language="javascript" src="../js/ckeditor/ckeditor.js" type="text/javascript"></script>  
    <script src="../includes/video-js/video.js"></script>
    <script src="../includes/video-js/media.youtube.js"></script>
    <script src="../js/bootbox.min.js"></script>

</head>
<body>
    <header>       
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Email: </strong>hoancn1.ptit@gmail.com
                    &nbsp;&nbsp;
                    <strong>Support: </strong>+0166 702 5648
                </div>
            </div>
        </div>
    </header>
 <!-- HEADER END #####################################################################-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="assets/img/logo.png" />
                </a>
            </div>
            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media">
                                    <a class="media-left" href="#">
                                        <img src="assets/img/64-64.jpg" alt="" class="img-rounded" />
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?= $_SESSION['fullname'] ?></h4>
                                        <h5>Administration</h5>
                                    </div>
                                </div>
                                <hr />
                                <h5><strong>Personal Bio : </strong></h5>
                                <?= $_SESSION['bio'] ?>
                                <hr />
                                <center>
                                <a href="#" class="btn btn-info btn-sm">Full Profile</a>&nbsp; <a href="logout_admin.php" class="btn btn-danger btn-sm">Logout</a>
                                </center>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END ######################################################################-->
     <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="view_news.php">News </a></li>
                            <li><a href="view_games.php">Games </a></li>
                            <li><a href="view_images.php">Images </a></li>
                            <li><a href="view_videos.php">Videos </a></li>
                            <?php if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == 99) { ?>
                            <li><a href="list_user.php">User</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- MENU SECTION END #####################################################################-->