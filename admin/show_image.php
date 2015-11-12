<?php 
	include('../includes/backend/mysqli_connect.php'); 
	include('../includes/functions.php');

	if( $iid = validate_id($_GET['iid'])){
		$set = get_image_by_id($iid);
        
		$images = array();
		if(mysqli_num_rows($set) > 0 ) {
		 	$images = mysqli_fetch_array($set, MYSQLI_ASSOC);
		}else {
			redirect_to('admin/list_images.php');
		}
	}else{
		redirect_to('admin/list_images.php');		
	}	
    $title_page = $images['type_name'];
	include('../includes/backend/header-admin.php');
	?>

	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-11" style="margin-left: 4.2%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $images['type_name'] ?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_IMAGE_LINK_HOME']?></a> / <a href="list_images.php"><?= $lang['ADD_IMAGE_LINK_LIST']?></a></h4>
                        </div> <!-- END PANEL HEADING--> 

                        <div class="panel-body">
                            <div class="row" class="show-fontsize">   
					            
			                  	<div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong>News ID :  </strong> <?= $images['image_id'] ?> 
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong ><?= $lang['TABLE_TYPE']?> : </strong> <?= $images['type_name'] ?> 
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong ><?= $lang['TABLE_TITLE']?> : </strong> <?= $images['title'] ?> 
					                </div>
					            </div>
                                <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong ><?= $lang['TABLE_POST_BY'] ?> : </strong> <?= $images['name'] ?>
					                </div>
					            </div>
					            <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong ><?= $lang['TABLE_POST_ON']?> : </strong> <?= $images['date'] ?>
					                </div>
					            </div>
                                
                                <div class="col-md-6" >
					                <div class="show-fontsize alert alert-success">
					                 	<strong >Status : </strong> <?= $images['status'] ?>
					                </div>
					            </div>
                                <div class="col-md-12" style="margin-left: 65px ; max-width : 900px">
									<div class="panel panel-success">
				                        <div class="panel-heading">
				                            <strong class="show-fontsize">Image : </strong> 
				                        </div>
				                        <div class="panel-body">
                                            <img class="img-responsive" style="margin: auto;" src="../images/gallery/<?= $images['image'] ?>" alt="<?= $images['image'] ?>">
				                        </div>				                        
				                    </div>
                            	</div>
                                <div class="col-md-11" style="margin-left: 4%">
					                <div class="show-fontsize alert alert-success">
					                 	<strong><?= $lang['TABLE_STATUS']?> : </strong>
                                        <?php if ($images['status'] == 0){
                                            echo "Inactive";
                                        }else{
                                            echo "Active";
                                        } ?> 
					                </div>
					            </div>
                            	<div class="col-md-12">
                            		<center>
                            			<div class="alert alert-default">
						                 	<input type="button" class="btncustom btn btn-success" onclick="window.location='edit_image.php?iid=<?= $iid ?>';" value="<?= $lang['BUTTON_EDIT'] ?>">
                                            <input type="button" class="btncustom btn btn-warning" onClick="check_delete_image(<?= $iid ?>)" value="<?= $lang['BUTTON_DELETE'] ?>">
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