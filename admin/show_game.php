<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
    include('../includes/errors.php');

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
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $games['title'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_GAME_LINK_HOME']?></a> / <a href="list_games.php"><?= $lang['ADD_GAME_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" class="show-fontsize ">   
					            <div class="show-img col-md-11" style="margin-left: 4%;">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_AVATAR']?>  : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="height: 23vw" src="../images/news/<?= $games['image'] ?>" alt="<?= $games['image'] ?>">
				                        </div>				                        
				                    </div>
                            	</div>
								<!-- END HEADER PANEL -->

			                  	<div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong style="font-size : 18px">Game ID :  </strong> <?= $games['news_id'] ?> 
					                </div>
					            </div>
					            
					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_TYPE']?> : </strong> <?= $games['type_name'] ?> 
					                </div>
					            </div>
                                
					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong>Game: </strong> <?= $games['title'] ?> 
					                </div>
					            </div>
                                
					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_POST_BY']?> : </strong> <?= $games['name'] ?> 
					                </div>
					            </div>

					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_POST_ON'] ?> : </strong> <?= $games['date'] ?>
					                </div>
					            </div>

					            <div class="col-md-11" style="margin-left: 4%">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_BANNER']?>  : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="width: 880px; height: 250px;" src="../images/news/<?= $games['banner'] ?>" alt="<?= $games['banner'] ?>">
				                        </div>				                        
				                    </div>
                            	 </div>
					                
					            <div class="col-md-11" style="margin-left: 4%">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_CONTENT']?></strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?= $games['content'] ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>

                                <div class="col-md-11" style="margin-left: 4%">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_STATUS']?> : </strong>
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
                                            <input type="button" class="btncustom btn btn-success" onclick="window.location='edit_game.php?gid=<?= $gid ?>';" value="<?= $lang['BUTTON_EDIT'] ?>">
                                            <input type="button" class="btncustom btn btn-warning" onClick="check_delete_game(<?= $gid ?>)" value="<?= $lang['BUTTON_DELETE'] ?>">
                                            <input type="button" class="btncustom btn btn-danger" onclick="window.history.back();" value="<?= $lang['BUTTON_BACK'] ?>">
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