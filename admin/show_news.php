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
			redirect_to('admin/list_news.php');
		} 
	}else{
		redirect_to('admin/list_news.php');		
	}	
    $title_page = $news['type_name'];
	include('../includes/backend/header-admin.php');
	?>

	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11" style="margin-left: 48.75px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $news['title'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php">Home</a> / <a href="list_news.php">List News</a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" style="font-size : 18px">   
					            <div class="col-md-11" style="margin: 30px 0 0 43.75px ; max-width : 400px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Avatar : </strong> 
				                        </div>
				                        <div class="panel-body">
				                            <img class="img-responsive" style="width: 400px; height: 330px;" src="../images/<?= $news['image'] ?>" alt="<?= $news['image'] ?>">
				                        </div>				                        
				                    </div>
                            	</div>
								<!-- END HEADER PANEL -->

			                  	<div class="col-md-5" style="margin: 30px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">News ID :  </strong> <?= $news['news_id'] ?> 
					                </div>
					            </div>
					            
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Type : </strong> <?= $news['type_name'] ?> 
					                </div>
					            </div>
                                
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Title : </strong> <?= $news['title'] ?> 
					                </div>
					            </div>
                                
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted By : </strong> <?= $news['name'] ?> 
					                </div>
					            </div>

					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted On : </strong> <?= $news['date'] ?>
					                </div>
					            </div>

					            <div class="col-md-11" style="margin-left: 43.75px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Banner : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="width: 880px; height: 250px;" src="../images/<?= $news['banner'] ?>" alt="<?= $news['banner'] ?>">
				                        </div>				                        
				                    </div>
                            	 </div>
					                
					            <div class="col-md-11" style="margin-left: 43.75px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Content  </strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?= $news['content'] ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>

                                <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Status : </strong>
                                        <?php if ($news['status'] == 0){
                                            echo "Inactive";
                                        }else{
                                            echo "Active";
                                        } ?> 
					                </div>
					            </div>
                                
                            	<div class="col-md-11">
                            		<center>
                            			<div class="alert alert-default">
						                 	<a href="edit_news.php?nid=<?= $nid ?>" class="btn btn-success btn-lg" style="padding: 10px 35px"> Edit </a>
											<a href="#" id="delete" name="delete" class="btn btn-danger btn-lg" style="padding: 10px 25px ; margin-left: 40px" onClick="check_delete_news(<?= $nid ?>)">Delete</a>
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