<!--#####################################################################
    #
    #   File          : LIST NEWS
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'List News';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');
?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_NEWS_PAGE_HEADER']?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table News [start] ============================== -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $lang['TITLE_NEWS']?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_NEWS_LINK_HOME']?></a> / <a href="add_news.php"><?= $lang['ADD_NEWS_LINK_UPLOAD']?></a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 3% ; text-align:center"><a href="list_news.php?sort=id"><?=$lang['TABLE_ID']?></a></th>
							    			<th style="width: 7% ; text-align:center"><a href="list_news.php?sort=type"><?= $lang['TABLE_TYPE'] ?></a></th>
							    			<th style="width: 20% ; text-align:center"><a href="list_news.php?sort=title"><?= $lang['TABLE_TITLE']?></a></th>
							                <th style="width: 40% ; text-align:center"><?= $lang['TABLE_CONTENT']?></th>
							                <th style="width: 8% ; text-align:center"><a href="list_news.php?sort=by"><?= $lang['TABLE_POST_BY']?></a></th>
							                <th style="width: 10% ; text-align:center"><a href="list_news.php?sort=on"><?= $lang['TABLE_POST_ON']?></a></th>
                                            <th style="width: 3% ; text-align:center"><?= $lang['TABLE_STATUS']?></th>
							                <th style="width: 9% ; text-align:center"> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php
											if(isset($_GET['sort'])){
												switch ($_GET['sort']) {
													case 'id':
														$order_by = 'news_id';
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
														$order_by = 'news_id';
														break;

												} // END Switch
											} else {
												$order_by = 'news_id';
											}

										$result = get_all_news($order_by);
										if(mysqli_num_rows($result) > 0 ) {

									 	while($news = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            if($news['status'] == 0){
                                                $active = "<a class='btn-action fa fa-remove' href='#' style='text-decoration: none' onClick='change_status_news({$news['news_id']},{$news['status']})'></a>";
                                            }else {
                                                $active = "<a class='btn-action fa fa-check' href='#' style='text-decoration: none' onClick='change_status_news({$news['news_id']},{$news['status']})' ></a>";
                                            }
                                        ?>
                                            <tr>
                                                <td style='text-align:right' ><?= $news['news_id'] ?></td>
                                                <td style='text-align:left'><?= $news['type_name'] ?></td>
                                                <td style='text-align:left'><?= $news['title'] ?></td>
                                                <td style='text-align:justify'><?= excerpt($news['content']) ?> ... </td>
                                                <td style='text-align:left'><?= $news['name'] ?></td>
                                                <td style='text-align:right'><?= $news['date'] ?></td>
                                                <td style='text-align:center'><?= $active ?></td>

                                                <td style='width : 100px'>
                                                <a class='btn-action fa fa-eye' href='show_news.php?nid=<?= $news['news_id'] ?>' style='text-decoration: none' ></a>
                                                <a class='btn-action fa fa-pencil' href='edit_news.php?nid=<?= $news['news_id'] ?>' style='text-decoration: none'></a>
                                                <a class='btn-action fa fa-trash-o' id='delete' name='delete' href='#' style=' text-decoration: none' onClick='check_delete_news(<?= $news['news_id'] ?>);'></a>
                                                </td>
                                            </tr>

                                    <?php }// END While loop
										} else {
                                    ?>
										<p class='alert alert-warning'><?= $error_news_no_item?></p>
									<?php 	}   ?>
							    	</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    <!-- ============================== Table News [end] ============================== -->
    			</div>
    		</div>
		</div>
	</div>
<!--end content-->
<?php include('../includes/backend/footer-admin.php'); ?>