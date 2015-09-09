<!-- Comment Form -->
	<?php 

		if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
			$errors = array(); //tao bien luu loi

			// validate name
			if(empty($_POST['name'])){
				$errors[] = "name";
			}else {
				// ham nay de tranh loi MySQL Injection, tranh cac loi script khi nhap input
				$author = mysqli_real_escape_string($dbc, strip_tags($_POST['name']));
			}

			// Validate comment
			if (!empty($_POST['comment'])) {
				$comment = mysqli_real_escape_string($dbc, $_POST['comment']);
			}else { 
				$errors[] = "comment";
			}
		
		if (empty($errors)) { 
		// neu ko co loi xay ra thi them comment vao co so du lieu
			
			$query = "INSERT INTO tblcomment (news_id, author, comment, comment_date) VALUES ({$nid}, '{$author}','{$comment}', NOW())";
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			// kiem tra xem co them thanh cong hay khong
			if(mysqli_affected_rows($dbc) == 1){ 
				// Success
				$messages = "<p class='success'>The category was added successfully!</p>";
			}else { // Fail
				$messages = "<p class='warning'>Could not added to the database due to a system error!</p>";
			}
		} else { // Error
			$messages =  "<p class='error'>Please fill all the required fields!</p>";
		}
	} // END main IF submit condition
?>

<?php 
	// Hien thi comment tu CSDL
	$query = " SELECT author, comment, DATE_FORMAT(comment_date, '%b %d, %y') AS date ";
	$query .=" FROM tblcomment WHERE news_id='{$nid}'";
	$result = mysqli_query($dbc, $query);
	confirm_query($result, $query);
	if (($count = mysqli_num_rows($result)) > 0 ) {
		// Neu co comment de hien thi ra trinh duyet
		
		echo "<div class='single-middle'>
				<h3>{$count} Comment</h3>";
		while(list($author, $comment, $date) = mysqli_fetch_array($result, MYSQLI_NUM)){
			echo "	
					<div class='media'>
						<div class='media-left'>
							<img class='media-object' src='images/co.png' alt=''>
						</div>
						<div class='media-body'>
							<h4 class='media-heading'>{$author}</h4>
							<h6>{$date}</h6>
							<p>{$comment}</p>
						</div>
					</div>";
		}// END while loop
		echo "</div>";
	} else {
		// Neu ko co comment thi hien ra, bao ra ngoai trinh duyet

	} // END if(mysqli_num_rows)
 ?>

<?php if (!empty($messages)) echo $messages; ?>
	<div class="single-bottom">
		<h3>Leave A Comment</h3>
			<form id="comment-form" action="" method="post">
				<div class="col-md-4 comment">
					<input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) {
							echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8');	} 
						?>" tabindex="3"  placeholder="Name">
					<?php 
						if (isset($errors) && in_array('name', $errors)) {
							echo "<p class='warning'>Please fill in the name!</p>";
						}
					?>
				</div>
				
				<div class="clearfix"> </div>
				<div id="comment">
					<textarea cols="77" rows="6" value="<?php if(isset($_POST['comment'])) {echo  htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8');} ?>" tabindex="3" id="comment" name="comment" placeholder="Comment"></textarea>
					<?php 
						if (isset($errors) && in_array('comment', $errors)) {
							echo "<p class='warning'>Please fill in the comment!</p>";
						}
					?>
				</div>
				<input type="submit" name="submit" value="Send" >
						
			</form>
		</div>