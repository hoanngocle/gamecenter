<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
    include('../includes/errors.php');
	?>
<?php
	if( $nid = validate_id($_GET['nid'])){
		$set = get_news_by_id($nid);

		$news = array();
		if(mysqli_num_rows($set) > 0 ) {
		 	$news = mysqli_fetch_array($set, MYSQLI_ASSOC);
		}else {
			$errors = "<p>There are currently no post in this category.</p>";
		}
	}else{
		redirect_to('admin/index.php');		
	}	

	include('../includes/backend/header-admin.php');
	?>

	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11" style="margin-left: 48.75px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?php echo $news['type_name'] ?></h2>
                            <h4 style="text-align: center" ><a href="view_news.php">List News & Games</a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" style="font-size : 18px">   
					            <div class="col-md-11" style="margin: 30px 0 0 43.75px ; max-width : 400px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Avatar : </strong> 
				                        </div>
				                        <div class="panel-body">
				                            <img class="img-responsive" src="../images/<?php echo $news['avatar']; ?>" alt="<?php echo $news['avatar']; ?>">
				                        </div>				                        
				                    </div>
                            	</div>
								<!-- END HEADER PANEL -->

			                  	<div class="col-md-5" style="margin: 30px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">News ID :  </strong> <?php echo $news['news_id']; ?> 
					                </div>
					            </div>
					            
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Type : </strong> <?php echo $news['type_name']; ?> 
					                </div>
					            </div>
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Title : </strong> <?php echo $news['title']; ?> 
					                </div>
					            </div>
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted By : </strong> <?php echo $news['name']; ?> 
					                </div>
					            </div>

					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted On : </strong> <?php echo $news['date']; ?>
					                </div>
					            </div>

					            <div class="col-md-11" style="margin-left: 43.75px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Banner : </strong> 
				                        </div>
				                        <div class="panel-body">
				                            <img class="img-responsive" src="../images/<?php echo $news['banner']; ?>" alt="<?php echo $news['banner']; ?>">
				                        </div>				                        
				                    </div>
                            	 </div>
					                
					            <div class="col-md-11" style="margin-left: 43.75px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Content  </strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?php echo $news['content']; ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>

                            	<div class="col-md-11">
                            		<center>
                            			<div class="alert alert-default">
						                 	<a href="edit_news.php?nid=<?php echo $nid ?>" class="btn btn-success btn-lg" style="padding: 10px 35px"> Edit </a>
											<a href="#" id="delete" name="delete" class="btn btn-danger btn-lg" style="padding: 10px 25px ; margin-left: 40px" onClick="check_delete(<?php echo $nid ?>)">Delete</a>
						                </div>
                            		</center>   
					            </div>
						
      						</div>
                        </div> <!-- END PANEL BODY-->
                    </div> <!-- END PANEL -->
    			</div>
    		</div> <!--  END ROW-->
		</div>
	</div>  <!-- END CONTENT -->

<?php include('../includes/backend/footer-admin.php'); ?>