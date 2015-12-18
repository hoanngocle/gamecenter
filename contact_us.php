<!--#####################################################################
    #
    #   File          : CONTACT US
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
	include('includes/backend/mysqli_connect.php');
	include('includes/functions.php');
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		// create variable error
		$errors = array();
        $uid = $_SESSION['uid'];

		// validate title
		if (empty($_POST['name'])) {
			$errors[] = "title";
		} else {
			$name = mysqli_real_escape_string($dbc, strip_tags($_POST['name']));
		}


		// validate content
		if (empty($_POST['email'])) {
			$errors[] = 'email';
		}else {
			$email = $_POST['email'];
		}

        // validate status
        if (isset($_POST['title'])) {
            $title = $_POST['title'];
        }else{
            $errors[] = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
        }

        // validate content
        if (isset($_POST['content'])) {
        	$content = $_POST['content'];
        }else{
        	$errors[] = 'content';
        }

        var_dump($_POST);die;

		if (empty($errors)) {
            $mail = new PHPMailer();
            sendmail($email, $title, $content);
		} else {
			$error = $lang['AD_REQUIRED'];
		}
	} // END main IF submit condition
 	include('includes/frontend/header.php');
?>
    <div class="contact">
		<div class="container">
			<h2><?= $lang['FRONT_CONTACT']?></h2>
			<div class="contact-form">
				<div class="col-md-8 contact-grid">
					<form id="contact" action="" method="post" enctype="multipart/form-data">
						<input type="text" id="name" name="name" maxlength="150" placeholder="<?= $lang['CONTACT_US_NAME'] ?>" value="<?php if(isset($title)) : echo $title; endif; ?>">
						<input type="text" id="email" name="email" maxlength="150" placeholder="<?= $lang['CONTACT_US_EMAIL'] ?>" value="<?php if(isset($title)) : echo $title; endif; ?>">
						<input type="text" id="title" name="title" maxlength="150" placeholder="<?= $lang['CONTACT_US_TITLE'] ?>" value="<?php if(isset($title)) : echo $title; endif; ?>">
						<textarea cols="77" rows="6" value=" <?php if(isset($content)) {echo $content;} ?>" ><?php if(isset($content)) {echo $content;}  else {echo "{$lang['CONTACT_US_CONTENT']}";}  ?></textarea>
						<div class="send">
						<input type="submit" value="Send">
							<button class="send-contact" type="submit"><?= $lang['Send']?></button>
						</div>
					</form>
				</div>
				<div class="col-md-4 contact-in">
					<div class="address-more">
					<h4><?= $lang['FRONT_Administrator']?></h4>
						<p>Học viện Công nghệ</p>
						<p>Bưu chính Viễn thông</p>
						<p>D11CNPM4</p>
					</div>
					<div class="address-more">
					<h4><?= $lang['FRONT_Address']?></h4>
						<p>Tel:1115550001</p>
						<p>Fax:190-4509-494</p>
						<p>Email:<a href="game.magazine@gmail.com"> game.magazine@gmail.com</a></p>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<div class="map">
            <iframe src="https://www.google.com/maps/d/embed?mid=zWzk9_XzVYpk.kfh3vY2i3qf0" width="640" height="480"></iframe>
        </div>
    </div>
<?php include('includes/frontend/footer.php'); ?>

