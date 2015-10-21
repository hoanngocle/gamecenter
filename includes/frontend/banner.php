<!--#####################################################################
    #
    #   File          : Banner - Banner index in website  
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #   Last Change   : 10/14/2015
    #
    ##################################################################### -->
<!--BEGIN of banner - slider -->
<div class="banner">
    <div class="container">	
        <div class="wmuSlider example1">
            <div class="wmuSliderWrapper">
                <?php
                $result = get_banner();

                if (mysqli_num_rows($result) > 0) {
                    // Neu co post de hien thi thi in ra
                    while ($images = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        ?>
                        <article style="position: absolute; width: 100%; opacity: 0;"> 
                            <div class="banner-wrap">
                                <div class="banner-top">
                                    <img style="width: 390px; height: 344px;" src="images/banner/<?php echo $images['image']; ?>" class="img-responsive" alt="<?php echo $images['image']; ?>">
                                </div>
                                <div class="banner-top banner-bottom">
                                    <img style="width: 612px; height: 344px;" src="images/banner/big_<?php echo $images['image']; ?>" class="img-responsive" alt="<?php echo $images['image']; ?>">
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
        <!---->
        <script src="js/jquery.wmuSlider.js"></script> 
        <script>
            $('.example1').wmuSlider({
                pagination: true,
                nav: false,
            });
        </script> 	
    </div>   
</div>
<!--END of banner - slider -->