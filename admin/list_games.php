<!--#####################################################################
    #
    #   File          : LIST GAME
    #   Project       : Game Magazine Project
    #   Author        : Béo Sagittarius
    #   Created       : 07/01/2015
    #
    ##################################################################### -->
<?php
    $title_page = 'List Games';
    include('../includes/functions.php');
	include('../includes/backend/header-admin.php');
	include('../includes/backend/mysqli_connect.php');
    include('../includes/errors.php');
?>
	<div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"><?= $lang['ADD_GAME_PAGE_HEADER']?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
    <!-- ============================== Table News [start] ============================== -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 style="text-align: center"><?= $lang['TITLE_GAMES']?></h2>
                            <h4 style="text-align: center" ><a href="index.php"><?= $lang['ADD_GAME_LINK_HOME'] ?></a> / <a href="add_game.php"><?= $lang['LIST_GAME_LINK_CREATE']?></a></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="text-align:center">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th style="width: 3% ; text-align:center"><a href="list_games.php?sort=id"><?=$lang['TABLE_ID']?></a></th>
							    			<th style="width: 7% ; text-align:center"><a href="list_games.php?sort=type"><?= $lang['TABLE_TYPE'] ?></a></th>
							    			<th style="width: 15% ; text-align:center"><a href="list_games.php?sort=title"><?= $lang['TABLE_GAME']?></a></th>
							                <th style="width: 45% ; text-align:center"><?= $lang['TABLE_CONTENT']?></th>
							                <th style="width: 9% ; text-align:center"><a href="list_games.php?sort=by"><?= $lang['TABLE_POST_BY']?></a></th>
							                <th style="width: 9% ; text-align:center"><a href="list_games.php?sort=on"><?= $lang['TABLE_POST_ON']?></a></th>
                                            <th style="width: 2% ; text-align:center"><?= $lang['TABLE_STATUS']?></th>
							                <th style="width: 10% ; text-align:center"> </th>
                                        </tr>
                                    </thead>

                                    <tbody>
									<?php
                                        if(isset($_GET['sort'])):
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
                                        else :
                                            $order_by = 'news_id';
                                        endif;

										$result = get_all_games($order_by);
										if(mysqli_num_rows($result) > 0 ) :
									 	while($games = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            if($games['status'] == 0):
                                                $active = "<a class='btn-action fa fa-remove' href='#' style='text-decoration: none' onClick='change_status_news({$games['news_id']},{$games['status']})'></a>";
                                            else :
                                                $active = "<a class='btn-action fa fa-check' href='#' style='text-decoration: none' onClick='change_status_news({$games['news_id']},{$games['status']})'></a>";
                                            endif;
                                        ?>
								 				<tr>
									                <td style='text-align:right' ><?= $games['news_id'] ?></td>
									                <td style='text-align:left'><?= $games['type_name'] ?></td>
									                <td style='text-align:left'><?= $games['title'] ?></td>
									                <td style='text-align:justify'><?= excerpt($games['content']) ?> ... </td>
									                <td style='text-align:left'><?= $games['name'] ?></td>
									                <td style='text-align:right'><?= $games['date'] ?></td>
                                                    <td style='text-align:center'><?= $active ?></td>

									                <td style='width : 100px'>
									                <a class='btn-action fa fa-eye' style='text-decoration: none' href='show_game.php?gid=<?= $games['news_id'] ?>'></a>
									                <a class='btn-action fa fa-pencil' style='text-decoration: none' href='edit_game.php?gid=<?= $games['news_id'] ?>'></a>
                                                    <a class='btn-action fa fa-trash-o' style='text-decoration: none' id='delete' name='delete' href='#' value='' onClick='check_delete_games(<?= $games['news_id'] ?>);'></a>
									                </td>
												</tr>

                                    <?php } else : ?>
										<p class='message-error alert alert-warning'><?= $error_games_no_item?></p>
									<?php endif; ?>
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