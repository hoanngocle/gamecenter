<?php
    include('includes/backend/mysqli_connect.php');
    include('includes/functions.php');
    include('includes/frontend/header.php');
?>

<!--content-->
    <div class="container">
        <div class="content-top">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">Action</h2></a>
            <div class="wrap">	
                <div class="main">
                    <ul id="og-grid" class="og-grid">
                        <?php
                        $result = get_games_by_type('Action');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                                ?>
                                <li>
                                    <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                        <img class="img-responsive" src="images/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
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
        <script src="js/grid.js"></script>
        <script>
            $(function () {
                Grid.init();
            });
        </script>
    </div>

    <div class="container">
        <div class="content-top">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">MMORPG</h2></a>
            <div class="wrap">	
                <div class="main">
                    <ul id="og-grid" class="og-grid">
                        <?php
                        $result = get_games_by_type('MMORPG');
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                                ?>
                                <li>
                                    <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                        <img class="img-responsive" src="images/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
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
        <script src="js/grid.js"></script>
        <script>
            $(function () {
                Grid.init();
            });
        </script>
    </div>

    <div class="container">
        <div class="content-top">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">NEW GAMES</h2></a>
            <div class="wrap">	
                <div class="main">
                    <ul id="og-grid" class="og-grid">
                        <?php
                        $result = get_games();
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                                ?>
                                <li>
                                    <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                        <img class="img-responsive" src="images/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
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
        <script src="js/grid.js"></script>
        <script>
            $(function () {
                Grid.init();
            });
        </script>
    </div>

    <div class="container">
        <div class="content-top">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">NEW GAMES</h2></a>
            <div class="wrap">	
                <div class="main">
                    <ul id="og-grid" class="og-grid">
                        <?php
                        $result = get_games();
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                                ?>
                                <li>
                                    <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                        <img class="img-responsive" src="images/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
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
        <script src="js/grid.js"></script>
        <script>
            $(function () {
                Grid.init();
            });
        </script>
    </div>

    <div class="container">
        <div class="content-top">
            <a href="gallery.php" style="text-decoration:none;"><h2 class="new" style="padding-bottom: 14px">NEW GAMES</h2></a>
            <div class="wrap">	
                <div class="main">
                    <ul id="og-grid" class="og-grid">
                        <?php
                        $result = get_games();
                        if (mysqli_num_rows($result) > 0) {
                            while ($games = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $content = excerpt_features($games['content']);
                                ?>
                                <li>
                                    <a href="single.php?nid=<?= $games['news_id']; ?>" data-largesrc="images/<?= $games['image']; ?>" data-title="<?= $games['title']; ?>" data-description="<?= $content ?>...">
                                        <img class="img-responsive" src="images/<?= $games['image']; ?>" alt="img<?= $games['image']; ?>"/>
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
        <script src="js/grid.js"></script>
        <script>
            $(function () {
                Grid.init();
            });
        </script>
    </div>

<?php include('includes/frontend/footer.php'); ?>