<!--#####################################################################
    #
    #   File          : SINGLE NEWS
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
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
			$errors =  $lang['FRONT_VIDEO_NEW_SINGLE'];
		}
	}else {
		redirect_to('404.php');
	}
	include('includes/frontend/header.php');
?>

	<div class="container">
		<div class="single">
			<div class="blog-to">
			<?php foreach ($posts as $news){ ?>
                <img class="img-responsive sin-on" style="width: 1110px; height: 320px;" src="images/news/<?= $news['banner']; ?>" alt="" />
                <div class="blog-top">
                    <div class="blog-left">
                        <b><?= $news['day']; ?></b>
                        <span><?= $news['month']; ?></span>
                    </div>
                    <div class="top-blog">
                        <a class="fast" href="#"><?= $news['title']; ?></a>
                        <p><?= $lang['FRONT_VIDEO_POST_BY']?><a href="#"><?= $news['name']; ?></a> in <a href="#"><?= $news['type_name']; ?></a></p>
                        <p class="sed"><?= $news['content']; ?></p>
                        <b>Tag:</b>
                        <?php
                         	$rs = get_tag_by_id($nid);
					        if (mysqli_num_rows($rs) > 0 ) {
								while($array_tag = mysqli_fetch_array($rs, MYSQLI_ASSOC)){
								$tags = $array_tag['keyword'];
					            ?>
                        <a class="fast" href="result.php?keyword=<?= $tags ?>"><?= $tags ?></a>,
			            <?php
				        	}
				        }
				        ?>
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