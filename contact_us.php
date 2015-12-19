<?php
	include('includes/backend/mysqli_connect.php');
	include('includes/functions.php');
	include('includes/frontend/header.php');
?>
    <div class="contact">
		<div class="container">
			<h2><?= $lang['FRONT_CONTACT']?></h2>
			<div class="contact-form">
				<div class="col-md-8 contact-grid">
					<form name="contact-form" id="contact-form" action="contact.php" method="POST">
						<input type="text" id="name" name="name" maxlength="150" placeholder="<?= $lang['CONTACT_US_NAME'] ?>" >
						<input type="text" id="email" name="email" maxlength="150" placeholder="<?= $lang['CONTACT_US_EMAIL'] ?>" >
						<input type="text" id="title" name="title" maxlength="150" placeholder="<?= $lang['CONTACT_US_TITLE'] ?>" value="<?php if(isset($title)) : echo $title; endif; ?>">
						<textarea cols="77" rows="6" name="content" value=" <?php if(isset($content)) {echo $content;} ?>" ><?php if(isset($content)) {echo $content;}  else {echo "{$lang['CONTACT_US_CONTENT']}";}  ?></textarea>
						<div class="send">
							<button class="send-contact" type="submit"><?= $lang['Send']?></button>
						</div>
					</form>
					<script type="text/javascript" src="/js/contact.js"></script>
				</div>
				<div class="col-md-4 contact-in">
					<div class="address-more">
					<h4><?= $lang['FRONT_Administrator']?></h4>
						<p>Học viện Công nghệ</p>
						<p>Bưu chính Viễn thông</p>
						<p>Lê Ngọc Hoàn - D11CNPM4</p>
					</div>
					<div class="address-more">
					<h4><?= $lang['FRONT_Address']?></h4>
						<p>Tel 	: 1115550001</p>
						<p>Fax 	: 190-4509-494</p>
						<p>Email: <a href="game.magazine@gmail.com"> game.magazine@gmail.com</a></p>
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

