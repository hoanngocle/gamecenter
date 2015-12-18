<!--#####################################################################
    #
    #   File          : LIST VIDEO
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'Playlist';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');
?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_VIDEO_PAGE_HEADER']?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                  <!--   Kitchen Sink -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $lang['TITLE_VIDEOS']?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_VIDEO_LINK_HOME']?></a> / <a href="upload_video.php"><?= $lang['ADD_VIDEO_H2']?></a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 3% ; text-align:center"><a href="list_videos.php.php?sort=id"><?=$lang['TABLE_ID']?></a></th>
							    			<th style="width: 5% ; text-align:center"><a href="list_videos.php?sort=cat"><?= $lang['TABLE_TYPE'] ?></a></th>
							    			<th style="width: 15% ; text-align:center"><a href="list_videos.php?sort=title"><?= $lang['TABLE_TITLE']?></a></th>
							                <th style="width: 15% ; text-align:center"><?= $lang['TABLE_DESCRIPTION']?></th>
                                            <th style="width: 28% ; text-align:center"><?= $lang['TABLE_VIDEO'] ?></th>
							                <th style="width: 10% ; text-align:center"><a href="list_videos.php?sort=by"><?= $lang['TABLE_POST_BY']?></a></th>
                                            <th style="width: 10% ; text-align:center"><a href="list_videos.php?sort=on"><?= $lang['TABLE_POST_ON']?></a></th>
                                            <th style="width: 4% ; text-align:center"><?= $lang['TABLE_STATUS']?></th>
							                <th style="width: 10% ; text-align:center"> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php
                                        if(isset($_GET['sort'])){
                                            switch ($_GET['sort']) {
                                                case 'id':
                                                    $order_by = 'video_id';
                                                    break;

                                                case 'type':
                                                    $order_by = 'type_name';
                                                    break;

                                                case 'title':
                                                    $order_by = 'title';
                                                    break;

                                                case 'by':
                                                    $order_by = 'name';
                                                    break;

                                                case 'on':
                                                    $order_by = 'date';
                                                    break;

                                                case 'stt':
                                                    $order_by = 'status';
                                                    break;

                                                default:
                                                    $order_by = 'video_id';
                                                    break;

                                            } // END Switch
                                        } else {
                                            $order_by = 'video_id';
                                        }
										$result = get_all_videos($order_by);
										if(mysqli_num_rows($result) > 0 ) {

									 	while($videos = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            if($videos['status'] == 0){
                                                $active = "<a class='btn-action fa fa-remove' style='text-decoration: none' onClick='change_status_video({$videos['video_id']},{$videos['status']})'></a>";
                                            }else {
                                                $active = "<a class='btn-action fa fa-check' style='text-decoration: none' onClick='change_status_video({$videos['video_id']},{$videos['status']})'></a>";
                                            }
                                        ?>
                                            <tr>
                                                <td style='text-align:right' ><?= $videos['video_id']?></td>
                                                <td style='text-align:left'><?= $videos['type_name']?></td>
                                                <td style='text-align:left'><?= $videos['title']?></td>
                                                <td style='text-align:justify'><?= $videos['description']?></td>
                                                <td style='text-align:right'><img style="width: 300px; height: 169px" src="/images/thumbnails/<?= $videos['thumbnail']?>" alt="" class="item-chil-row1" ></td>
                                                <td style='text-align:left'><?= $videos['name']?></td>
                                                <td style='text-align:right'><?= $videos['date']?></td>
                                                <td style='text-align:center'><?= $active?></td>
                                                <td style='width : 100px'>
                                                <a class='btn-action fa fa-eye' href='show_video.php?vid=<?= $videos['video_id']?>' style='text-decoration: none'></a>
                                                <a class='btn-action fa fa-pencil' href='edit_video.php?vid=<?= $videos['video_id']?>' style='text-decoration: none'></a>
                                                <a class='btn-action fa fa-trash-o' id='delete' name='delete' href='#' style='text-decoration: none' value='' onClick='check_delete_video(<?= $videos['video_id'] ?>);'></a>
                                                </td>
                                            </tr>
									<?php
                                            }// END While loop
										} else {
                                    ?>
										 	<p class='alert alert-warning'><?= $error_videos_no_item?></p>
									<?php 	}   ?>
							    	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    			</div>
    		</div>
		</div>
	</div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>