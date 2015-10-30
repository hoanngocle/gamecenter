<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
    include('../includes/errors.php');
	?>
<?php
    
	if( $gid = validate_id($_GET['gid'])){
		$set = get_news_by_id($gid);

		$games = array();
		if(mysqli_num_rows($set) > 0 ) {
		 	$games = mysqli_fetch_array($set, MYSQLI_ASSOC);
		}else {
			redirect_to('admin/list_games.php');
		} 
	}else{
		redirect_to('admin/list_games.php');		
	}	
    $title_page = $games['type_name'];
	include('../includes/backend/header-admin.php');
	?>

	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11" style="margin-left: 48.75px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $games['title'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php">Home</a> / <a href="list_games.php">List Games</a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" style="font-size : 18px">   
					            <div class="col-md-11" style="margin: 30px 0 0 43.75px ; max-width : 400px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Avatar : </strong> 
				                        </div>
				                        <div class="panel-body">
				                            <img class="img-responsive" style="width: 400px; height: 330px;" src="../images/<?= $games['image'] ?>" alt="<?= $games['image'] ?>">
				                        </div>				                        
				                    </div>
                            	</div>
								<!-- END HEADER PANEL -->

			                  	<div class="col-md-5" style="margin: 30px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">News ID :  </strong> <?= $games['news_id'] ?> 
					                </div>
					            </div>
					            
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Type : </strong> <?= $games['type_name'] ?> 
					                </div>
					            </div>
                                
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Game: </strong> <?= $games['title'] ?> 
					                </div>
					            </div>
                                
					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted By : </strong> <?= $games['name'] ?> 
					                </div>
					            </div>

					            <div class="col-md-5" style="margin: 5px 0 0 118px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Posted On : </strong> <?= $games['date'] ?>
					                </div>
					            </div>

					            <div class="col-md-11" style="margin-left: 43.75px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Banner : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="width: 880px; height: 250px;" src="../images/<?= $games['banner'] ?>" alt="<?= $games['banner'] ?>">
				                        </div>				                        
				                    </div>
                            	 </div>
					                
					            <div class="col-md-11" style="margin-left: 43.75px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong style="font-size : 18px">Content  </strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?= $games['content'] ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>

                                <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="alert alert-success">
					                 	<strong style="font-size : 18px">Status : </strong>
                                        <?php if ($games['status'] == 0){
                                            echo "Inactive";
                                        }else{
                                            echo "Active";
                                        } ?> 
					                </div>
					            </div>
                                
                            	<div class="col-md-11">
                            		<center>
                            			<div class="alert alert-default">
						                 	<a href="edit_game.php?gid=<?= $gid ?>" class="btn btn-success btn-lg" style="padding: 10px 35px"> Edit </a>
											<a href="#" id="delete" name="delete" class="btn btn-danger btn-lg" style="padding: 10px 25px ; margin-left: 40px" onClick="check_delete_game(<?= $gid ?>)">Delete</a>
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