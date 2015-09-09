<?php include('../includes/backend/header-admin.php');?>
<?php include('../includes/backend/mysqli_connect.php'); ?>
<?php include('../includes/functions.php'); ?>
<?php include('../includes/backend/sidebar-admin.php'); ?>

<?php 
	// xac nhan bien GET ton tai va thuoc loai du lieu cho phep
	if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1 ))) {
		$cid = $_GET['cid'];
	}else{
		// tai dinh huong nguoi dung
		redirect_to('admin/admin.php');
	}


	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // gia tri ton tai, xu ly form	
		$errors = array(); //tao bien luu loi

		// kiem tra category co gia tri hay ko
		if(empty($_POST['category'])){
			$errors[] = "category";
		}else {
			// ham nay de tranh loi MySQL Injection, tranh cac loi script khi nhap input
			$cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['category']));
		}

		// kiem tra position co gia tri hay ko
		if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$position = $_POST['position'];
		}else {
			$errors[] = "position";
		}
		
		if (empty($errors)) {// neu ko co loi xay ra thi chen vao co so du lieu

			// cau lenh insert category
			$query = "UPDATE tblcategories SET cat_name ='{$cat_name}', position = $position WHERE cat_id = {$cid} LIMIT 1";

			// gia tri tra ve result, hoac la die thi bao loi ra man hinhf
			$result = mysqli_query($dbc, $query);
			// ham tra ve ket qua co dung hay ko
			confirm_query($result, $query);

			// kiem tra xem co them thanh cong hay khong
			if(mysqli_affected_rows($dbc) == 1){ // neu them thanh cong, in ra 
				$messages = "<p class='success'>The category was edited successfully!</p>";
			}else {
				$messages = "<p class='warning'>Could not edited the category due to a system error!</p>";
			}
			// co loi thi in ra dong nay
		} else {
			$messages =  "<p class='warning'>Please fill all the required fields!</p>";
		}
	} // END main IF submit condition
?>

<div id="content">
	<?php 
		$query = "SELECT cat_name, position FROM tblcategories WHERE cat_id = {$cid}";
		$result = mysqli_query($dbc, $query);
		confirm_query($result, $query);
		if (mysqli_num_rows($result) == 1) {
			// Neu category ton tai trong database, dua vao CID, thi minh xuat du lieu ra ngoai trinh duyet
				list($cat_name, $position) = mysqli_fetch_array($result, MYSQLI_NUM);
			}else {
				// Neu CID ko ton tai thi category khong the duoc hien thi ra
				$messages = "<p class='warning'>The category does not exist</p>";
			}
	 ?>


	<h2>Edit categories: <?php if(isset($cat_name)) echo $cat_name; ?></h2>
	<?php if (!empty($messages)) echo "$messages"; ?>
	<form id="add_cat" action="" method="post">
		<fieldset>
			<legend>Edit category</legend>
				<div>
					<label for="category">Category Name: <span class="required">*</span>
						<?php 
							if (isset($errors) && in_array('category', $errors)) {
								echo "<p class='warning'>Please fill in the category name!</p>";
							}
						?>
					</label>
					<input type="text" name="category" id="category" value=" <?php if(isset($cat_name)) echo $cat_name; ?>" size="20" maxlength="150" tabindex="1">
				</div>
				<div>
					<label for="position">Position: <span class="required"></span>
						<?php 
							if (isset($errors) && in_array('position', $errors)) {
								echo "<p class='warning'>Please pick a position!</p>";
							}
						?>
					</label>
					<select name="position" tabindex='2'>
						<?php 
							$query = "SELECT count(cat_id) AS count FROM tblcategories";
							$result = mysqli_query($dbc, $query); 
								confirm_query($result, $query);

							if(mysqli_num_rows($result) == 1 ){
								list($num) = mysqli_fetch_array($result, MYSQLI_NUM);
								for ($i=1; $i <= $num+1; $i++) { // tao vong for de tao ra option, cong them 1 de tao ra option
									echo "<option value='{$i}'"; 
										if (isset($position) && ($position == $i)) echo "selected='selected'";
									echo ">".$i."</option>";
									
								}
							}
						 ?>
					</select>
				</div>
		</fieldset>
		<p><input type="submit" name="submit" value="Edit Category"></p>
	</form>
</div><!--end content-->
<?php include('../includes/backend/sidebar-b.php');?>
<?php include('../includes/backend/footer-admin.php'); ?>