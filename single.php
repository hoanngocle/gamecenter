<!-- goi file chua header -->
<?php 
	//Include file php function vs connect DB
	include('includes/backend/mysqli_connect.php'); 
	include('includes/functions.php');
	
	// Ham lay gia tri tu csdl ra, tao dynamite title
	if($nid = validate_id($_GET['nid'])) {
		//Neu nid hop le thi tien hanh truy van co so du lieu
		$set = get_news_by_id($nid);
		$posts = array(); // Tao 1 array trong de luu gia tri vao su dung sau nay cho phan noi dung

		// kiem tra co gia tri tra ve ko
		if (mysqli_num_rows($set) > 0 ) {
			// Neu co page thi hien thi ra ngoai
			$news = mysqli_fetch_array($set, MYSQLI_ASSOC);
			$title = $news['title'];

			$posts[] = array(
						'banner' => $news['banner'],
						'day' => $news['day'],
						'month' => $news['month'],
						'title' => $news['title'],
						'name' => $news['name'],
						'type_name' => $news['type_name'],
						'content' => $news['content']
				);
		}else {
			$errors =  "<p>There are currently no post in this category.</p>";
		}
	}else {
		//neu nid ko co thi chuyen huong nguoi dung
		redirect_to();
	}
	include('includes/frontend/header.php');
?>

<!--content-->
	<div class="container">
		<div class="single">
			<!-- Show content -->
			<div class="blog-to">
			<!-- In ra trang 404 neu ko có page -->
			<?php foreach ($posts as $news){ ?>

					<img class="img-responsive sin-on" src="images/<?php echo $news['banner']; ?>" alt="" />
					<div class="blog-top">
						<div class="blog-left">
							<b><?php echo $news['day']; ?></b>
							<span><?php echo $news['month']; ?></span>
						</div>
						<div class="top-blog">
							<a class="fast" href="#"><?php echo $news['title']; ?></a>
							<p>Posted by <a href="#"><?php echo $news['name']; ?></a> in <a href="#"><?php echo $news['type_name']; ?></a></p> 
							<p class="sed"><?php echo $news['content']; ?></p>			
						<div class="clearfix"> </div>
						</div>
					<div class="clearfix"> </div>
					</div>

			<?php  } ?>
	
				
			</div>

		<!-- Comment -->
		<?php include('includes/frontend/comment_form.php') ?>
		
		</div>
	</div>
<!-- goi file chua header -->
<?php include('includes/frontend/footer.php'); ?>