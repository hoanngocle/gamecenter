<!--#####################################################################
    #
    #   File          : Banner - Banner index in website
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<!-- ================================== BANNER [start] ========================================== -->
<div class="banner">
    <div class="container">
        <div class="wmuSlider example1">
            <div class="wmuSliderWrapper">
                <?php
                // get banner
                $result = get_banner();
                if (mysqli_num_rows($result) > 0) {
                    while ($images = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                <article style="position: absolute; width: 100%; opacity: 0;">
                    <div class="banner-wrap">
                        <div class="banner-top">
                            <img style="width: 390px; height: 344px;" src="images/gallery/<?= $images['image']; ?>" class="img-responsive" alt="<?= $images['image']; ?>">
                        </div>
                        <div class="banner-top banner-bottom">
                            <img style="width: 612px; height: 344px;" src="images/gallery/big_<?= $images['image']; ?>" class="img-responsive" alt="<?= $images['image']; ?>">
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </article>
                <?php
                    }
                }
                ?>
            </div>
            <ul class="wmuSliderPagination"></ul>
        </div>
        <script src="js/jquery.wmuSlider.js"></script>
        <script>
            $('.example1').wmuSlider({
                pagination: true,
                nav: false,
            });
        </script>
    </div>
</div>
<!-- ================================== BANNER [end] ========================================== -->