<!--#####################################################################
    #
    #   File          : Footer - Footer index in website  
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #   Last Change   : 10/14/2015
    #
    ##################################################################### -->
<!-- Footer -->	
<div class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="footer-middle-in">
                <h6>About us</h6>
                <p style="text-align: justify">Posts and Telecommunications Institute of Technology - D11CNPM4 - Lê Ngọc Hoàn - Béo Sagittarius</p>
            </div>
            <div class="footer-middle-in">
                <h6>Information</h6>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Delivery Information</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="footer-middle-in">
                <h6>Customer Service</h6>
                <ul>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="contact.html">Site Map</a></li>
                </ul>
            </div>
            <div class="footer-middle-in">
                <h6>My Account</h6>
                <ul>
                    <?php if (isset($_SESSION['fullname'])) { ?>
                        <li><a href="#" >Hi, <?= $_SESSION['fullname'] ?></a></li>    
                        <li><a href="#" class="" role="button" data-toggle="modal" data-target="#profile-modal">Full Profile</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    <?php } else { ?>
                        <li><a href="#" >Hi, Anonymous!</a></li>
                        <li><a href="#" class="" role="button" data-toggle="modal" data-target="#login-modal">Log In</a></li>
                    <?php } ?>



                </ul>
            </div>
            <div class="footer-middle-in">
                <h6>Extras</h6>
                <ul>
                    <li><a href="#">Affiliates</a></li>
                    <li><a href="#">Specials</a></li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>	
    <!---------------------------- Form Popup [start] --------------------------> 
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <img class="img-circle" id="img_logo" src="http://bootsnipp.com/img/logo.jpg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>

                <!-- Begin # DIV Form -->
                <div id="div-forms">

                    <!-- Begin # Login Form -->
                    <form id="login-form" method="post">
                        <div class="modal-body">
                            <div id="div-login-msg">
                                <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-login-msg">Type your username and password.</span>
                            </div>
                            <input id="login_username" class="form-control" type="text" placeholder="Username ">
                            <input id="login_password" class="form-control" type="password" placeholder="Password">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Log In</button>
                            </div>
                            <div>
                                <button id="login_lost_btn" type="button" class="btn btn-link">Forgot Password?</button>
                                <button id="login_register_btn" type="button" class="btn btn-link">Sign Up</button>
                            </div>
                        </div>
                    </form>
                    <!-- End # Login Form -->

                    <!-- Begin | Forgot Password Form -->
                    <form id="lost-form" style="display:none;" method="post">
                        <div class="modal-body">
                            <div id="div-lost-msg">
                                <div id="icon-lost-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-lost-msg">Type your e-mail.</span>
                            </div>
                            <input id="lost_email" class="form-control" type="text" placeholder="E-Mail" >
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
                            </div>
                            <div>
                                <button id="lost_login_btn" type="button" class="btn btn-link">Log In</button>
                                <button id="lost_register_btn" type="button" class="btn btn-link">Sign Up</button>
                            </div>
                        </div>
                    </form>
                    <!-- End | Forgot Password Form -->

                    <!-- Begin | Register Form -->
                    <form id="register-form" style="display:none;" method="post">
                        <div class="modal-body">
                            <div id="div-register-msg">
                                <div id="icon-register-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-register-msg">Sign up your account.</span>
                            </div>
                            <div style="width: 48%; padding: 0px; float: left"><input id="register_firstname" class="form-control" type="text" placeholder="Firstname " ></div>
                            <div style="width: 48%; margin: 10px 12.7px 0 0; float: left"><input id="register_last" class="form-control" type="text" placeholder="Lastname " ></div>
                            
                            <input id="register_email" class="form-control" type="text" placeholder="E-Mail" required="">
                            <input id="register_password" class="form-control" type="password" placeholder="Password" required="">
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign Up</button>
                            </div>
                            <div>
                                <button id="register_login_btn" type="button" class="btn btn-link">Log In</button>
                                <button id="register_lost_btn" type="button" class="btn btn-link">Forgot Password?</button>
                            </div>
                        </div>
                    </form>
                    <!-- End | Register Form -->

                </div>
                <!-- End # DIV Form -->

            </div>
        </div>
    </div>
    <!-- END # MODAL LOGIN -->
    <script type="text/javascript" src="/js/login_modal.js"></script>  

    <p class="footer-class">
        Copyright © 2015 - Game Magazine. All rights reserved<br>
        Design by  <a href="http://facebook.com/beo.sagittarius.93" target="_blank">Béo Sagitarius</a>
    </p>

    <!-------------------------------- onTop Button ------------------------------->
    <div id="goTop">  	
        <script type="text/javascript">
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 100)
                        $('#goTop').fadeIn();
                    else
                        $('#goTop').fadeOut();
                });
                $('#goTop').click(function () {
                    $('body,html').animate({scrollTop: 0}, 'slow');
                });
            });
        </script>
    </div>

    <!-------------------------------- onTop Button ------------------------------->
</div> 
</body>
</html>