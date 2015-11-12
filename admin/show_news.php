<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');
    include('../includes/errors.php');

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
                <div class="col-md-11" style="margin-left: 4.1%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $news['title'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_NEWS_LINK_HOME']?></a> / <a href="list_news.php"><?= $lang['ADD_NEWS_LINK_LIST'] ?></a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row"  class="show-fontsize">   
					            <div class="show-img col-md-11" style="margin-left: 4% ;">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_AVATAR']?> : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="height: 23vw" src="../images/<?= $news['image'] ?>" alt="<?= $news['image'] ?>">
				                        </div>				                        
				                    </div>
                            	</div>
								<!-- END HEADER PANEL -->

                                <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong>News ID :  </strong> <?= $news['news_id'] ?> 
					                </div>
					            </div>
					            
					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_TYPE']?> : </strong> <?= $news['type_name'] ?> 
					                </div>
					            </div>
                                
					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_TITLE']?> : </strong> <?= $news['title'] ?> 
					                </div>
					            </div>
                                
					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_POST_BY']?> : </strong> <?= $news['name'] ?> 
					                </div>
					            </div>

					            <div class="show-left col-md-5">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_POST_ON'] ?> : </strong> <?= $news['date'] ?>
					                </div>
					            </div>

					            <div class="col-md-11" style="margin-left: 4%">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_BANNER']?> : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="banner img-responsive" src="../images/<?= $news['banner'] ?>" alt="<?= $news['banner'] ?>">
				                        </div>				                        
				                    </div>
                            	 </div>
					                
					            <div class="col-md-11" style="margin-left: 4%">
									<div class="panel panel-success">
				                        <div class="show-fontsize panel-heading">
				                            <strong><?= $lang['TABLE_CONTENT']?></strong>
				                        </div>
				                        <div class="panel-body">
				                            <p><?= $news['content'] ?> </p>
				                        </div>				                        
				                    </div>
                            	</div>

                                <div class="col-md-11" style="margin-left: 43.75px">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_STATUS']?> : </strong>
                                        <?php if ($news['status'] == 0){
                                            echo "Inactive";
                                        }else{
                                            echo "Active";
                                        } ?> 
					                </div>
					            </div>
                                
                            	<div class="col-md-12">
                            		<center>
                            			<div class="alert alert-default">
                                            <input type="button" class="btncustom btn btn-success" onclick="window.location='edit_news.php?nid=<?= $nid ?>';" value="<?= $lang['BUTTON_EDIT'] ?>">
                                            <input type="button" class="btncustom btn btn-warning" onClick="check_delete_news(<?= $nid ?>)" value="<?= $lang['BUTTON_DELETE'] ?>">
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