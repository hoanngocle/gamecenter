<?php 
	//Include file php function vs connect DB
	include('includes/backend/mysqli_connect.php'); 
	include('includes/functions.php');
	
	if($nid = validate_id($_GET['nid'])) {
		
		$set = get_news_by_id($nid);
		$posts = array(); // create array to save data

		if (mysqli_num_rows($set) > 0 ) {
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
        
        $result2 = get_tag_by_id($nid);
        $tags = null ;
        if (mysqli_num_rows($result2) > 0 ) {	
			$array_tag = mysqli_fetch_array($result2, MYSQLI_ASSOC);      
            $tags = $array_tag['keyword'];
        }
       
	}else {
		//if dont have nid, redirect user
		redirect_to('404.php');
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
                <img class="img-responsive sin-on" style="width: 1110px; height: 338px;" src="images/<?= $news['banner']; ?>" alt="" />
                <div class="blog-top">
                    <div class="blog-left">
                        <b><?= $news['day']; ?></b>
                        <span><?= $news['month']; ?></span>
                    </div>
                    <div class="top-blog">
                        <a class="fast" href="#"><?= $news['title']; ?></a>
                        <p>Posted by <a href="#"><?= $news['name']; ?></a> in <a href="#"><?= $news['type_name']; ?></a></p> 
                        <p class="sed"><?= $news['content']; ?></p>			
                        Tag: <a class="fast" href="search.php?tag=<?= $tags ?>"><?= $tags ?></a>
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