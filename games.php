<!--#####################################################################
    #
    #   File          : GAMES
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
<!--content-->
    <div class="container">
        <div class="review" style="padding: 1em">
            <h2 ><?= $lang['GAME']?></h2>
        </div>
        <div class="content-game">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px"><?= $lang['GAME_ACTION']?></h2></a>
            <div class="wrap">
                <div class="main">
                    <ul id="og-grid" class="image-game">
                        <?php
                        $result = get_games_by_type('Action');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                        ?>
                        <li>
                            <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/news/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                <img class="img-responsive" src="images/news/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                        <div class="clearfix"> </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-game">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px"><?= $lang['GAME_ADVENTURE']?></h2></a>
            <div class="wrap">
                <div class="main">
                    <ul id="og-grid" class="image-game">
                        <?php
                        $result = get_games_by_type('Adventure');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                        ?>
                        <li>
                            <a href="single.php?nid=<?= $games['news_id']; ?>" >
                                <img class="" src="images/news/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                        <div class="clearfix"> </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-game">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">&nbsp;&nbsp;<?= $lang['GAME_SPORT']?>&nbsp;&nbsp;&nbsp;</h2></a>
            <div class="wrap">
                <div class="main">
                    <ul id="og-grid" class="image-game">
                        <?php
                        $result = get_games_by_type('Sport');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                        ?>
                        <li>
                            <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/news/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                <img class="img-responsive" src="images/news/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                        <div class="clearfix"> </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-game">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px"><?= $lang['GAME_RACING'] ?></h2></a>
            <div class="wrap">
                <div class="main">
                    <ul id="og-grid" class="image-game">
                        <?php
                        $result = get_games_by_type('Racing');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                        ?>
                        <li>
                            <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/news/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                <img class="img-responsive" src="images/news/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                        <div class="clearfix"> </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-game">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px"><?= $lang['GAME_STRATEGY']?></h2></a>
            <div class="wrap">
                <div class="main">
                    <ul id="og-grid" class="image-game">
                        <?php
                        $result = get_games_by_type('Strategy');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                        ?>
                        <li>
                            <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/news/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                <img class="img-responsive" src="images/news/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                        <div class="clearfix"> </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php include('includes/frontend/footer.php'); ?>