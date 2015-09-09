<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
	?>
<?php
	if( $iid = validate_id($_GET['iid'])){
		$set = get_image_by_id($iid);
        
		$images = array();
		if(mysqli_num_rows($set) > 0 ) {
		 	$images = mysqli_fetch_array($set, MYSQLI_ASSOC);
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
                            <h2 style="text-align: center"><?php echo $images['cat_name'] ?></h2>
                            <h4 style="text-align: center" ><a href="view_news.php">List Images</a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" style="font-size : 18px">   
					            
								<!-- END HEADER PANEL -->

			                  	<div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">News ID :  </strong> <?php echo $images['image_id']; ?> 
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Category : </strong> <?php echo $images['cat_name']; ?> 
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Title : </strong> <?php echo $images['title']; ?> 
					                </div>
					            </div>

					            <div class="col-md-6" >
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted On : </strong> <?php echo $images['date']; ?>
					                </div>
					            </div>
                                <div class="col-md-12" style="margin-left: 65px ; max-width : 900px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Image : </strong> 
				                        </div>
				                        <div class="panel-body">
				                            <img class="img-responsive" src="../images/<?php echo $images['image']; ?>" alt="<?php echo $images['image']; ?>">
				                        </div>				                        
				                    </div>
                            	</div>
                            	<div class="col-md-11">
                            		<center>
                            			<div class="alert alert-default">
						                 	<a href="edit_news.php?iid=<?php echo $nid ?>" class="btn btn-success btn-lg" style="padding: 10px 35px"> Edit </a>
											<a href="#" class="btn btn-danger btn-lg" style="padding: 10px 25px ; margin-left: 40px">Delete</a>
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