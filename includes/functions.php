<?php 

	// xac dinh hang so cho dia chi tuyet doi
	define ('BASE_URL', 'http://localhost/gamecenter/');

// ####################################################################################################

	// Kiem tra xem ket qua tra ve co dung hay khong?
	function confirm_query($result, $query) {
		global $dbc;
		if (!$result) {
			die ("Query {$query} \n <br> MySQL Error: " .mysqli_error($dbc));
		}
	}	

// ####################################################################################################

	// tai dinh huong nguoi dung
	function redirect_to($page = 'index.php') {
		$url = BASE_URL . $page;
		header ("Location: {$url}");
		exit();
	}

// ####################################################################################################

	// ham cat chu cuoi cung cua phan content thanh doan van ngan
	function excerpt($text) {
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		if(strlen($sanitized) > 400 ) {
			$cutString = substr($sanitized,0,400);
			$words = substr($sanitized, 0, strrpos($cutString, ' '));
			return $words;
		} else {
			return $sanitized;
		}

	}// END the excerpt

// ####################################################################################################

	// ham cat chu cuoi cung cua phan content thanh doan van ngan
	function excerpt_features($text) {
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		if(strlen($sanitized) > 600 ) {
			$cutString = substr($sanitized,0,600);
			$words = substr($sanitized, 0, strrpos($cutString, ' '));
			return $words;
		} else {
			return $sanitized;
		}

	}// END the excerpt
// ####################################################################################################

	// Tao paragraph tu CSDL
	function the_content($text){
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		return str_replace(array("\r\n", "\n"), array("<p>" , "</p>"), $sanitized);
	}
// ####################################################################################################

	// ham kiem tra xem GET co gia tri hay ko, $id co hop le, la dang so hay ko
	function validate_id($id){
		if (isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1 ))) {
			$val_id = $id;
			return $val_id;
		}else {
			return null;
		}
	} // End validate_id

// ####################################################################################################
	function get_banner(){
		global $dbc;
		// Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
			$query = "SELECT i.image_id, i.image, i.title, c.cat_name, ";
			$query .= " DATE_FORMAT(i.post_on, '%b %d, %y') AS date ";
			$query .= " FROM tblimages as i";
			$query .= " INNER JOIN tblcategories AS c ";
			$query .= " USING (cat_id) WHERE c.cat_name='Banner' ";
			$query .= " ORDER BY date LIMIT 0, 3";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	}

// ####################################################################################################
	function get_new_games(){
		global $dbc;
		// Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
			$query = " SELECT news_id, title, content, avatar, type, ";
			$query .= " DATE_FORMAT(post_on, '%b %d, %y') AS date ";
			$query .= " FROM tblnews WHERE type='Games' ";
			$query .= " ORDER BY date LIMIT 0, 8";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	}

// Dung cho frontend  - hien thi anh bai viet hot nhat hien nay #####################################
	function get_best_features(){
		global $dbc;
			$query = "SELECT n.news_id, n.title, n.content,  ";
			$query .= " DATE_FORMAT( n.post_on, '%b %d, %Y') AS date, c.cat_name ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tblcategories AS c ";
			$query .= " USING ( cat_id ) ";
			$query .= " WHERE c.cat_name='Best Features' ";
			$query .= " ORDER BY date LIMIT 1";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;

	}
// Dung cho single page  - tung bai viet ########################################################

	function get_news_by_id($id){
		global $dbc;
			$query = "SELECT n.news_id, n.title, n.content, n.banner, n.avatar, n.type, ";
			$query .= " DATE_FORMAT( n.post_on, '%b') AS month, ";
			$query .= " DATE_FORMAT( n.post_on, '%d') AS day, ";
			$query .= " DATE_FORMAT( n.post_on, '%b %d, %Y') AS date, ";
			$query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id, c.cat_name ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tblusers AS u ";
			$query .= " USING ( user_id ) ";
			$query .= " INNER JOIN tblcategories AS c ";
			$query .= " USING ( cat_id ) ";
			$query .= " WHERE n.news_id={$id} LIMIT 1";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
	
			return $result;
	} // END of query

// Dung cho frontend  - bai viet hot nhat ##################################################

	function get_hot_news(){
		global $dbc;
		// Query lay gia tri tu co so du lieu ra
			$query = "SELECT n.news_id, n.avatar, n.title, DATE_FORMAT(n.post_on, '%d %b, %Y') AS date, ";
			$query .= " COUNT(c.comment_id) AS count ";
			$query .= " FROM tblnews AS n ";
			$query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";	
			$query .= " WHERE n.type = 'Games' ";
			$query .= " GROUP BY n.title ";
			$query .= " ORDER BY count DESC LIMIT 0, 3 ";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	} // END of query

// Dung cho frontend - show lastest - bai viet cuoi cung ##########################################

	function get_lastest_news(){
		global $dbc;
		// Query lay gia tri tu co so du lieu ra
			$query = "SELECT n.news_id, n.avatar, n.title, DATE_FORMAT(n.post_on, '%d %b, %Y') AS date, ";
			$query .= " COUNT(c.comment_id) AS count ";
			$query .= " FROM tblnews AS n ";
			$query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
			$query .= " WHERE n.type = 'Games' ";
			$query .= " GROUP BY n.title ";
			$query .= " ORDER BY date DESC LIMIT 0, 3 ";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	} // END of query

// Dung cho frontend - show popular - bai viet nhieu comment ##########################################

	function get_popular_news(){
		global $dbc;
			$query = "SELECT n.news_id, n.avatar, n.title, DATE_FORMAT(n.post_on, '%d %b, %Y') AS date, ";
			$query .= " COUNT(c.comment_id) AS count ";
			$query .= " FROM tblnews AS n ";
			$query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";
			$query .= " WHERE n.type = 'Games' ";
			$query .= " GROUP BY n.title ";	
			$query .= " ORDER BY count DESC LIMIT 0, 3 ";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	} // END of query



	// Dung cho backend - list news #################################################################
	function get_all_news($order_by){
		global $dbc;
			$query = "SELECT n.news_id, c.cat_name, n.type, n.title, n.content, ";
			$query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
			$query .= " DATE_FORMAT(n.post_on, '%b %d %Y') AS date ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tblusers AS u ";
			$query .= " USING(user_id) ";
			$query .= " INNER JOIN tblcategories AS c";
			$query .= " USING(cat_id) ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}
	
// Dung cho backend - list images ######################################################################
	function get_all_images($order_by){
		global $dbc;
			$query = " SELECT i.image_id, c.cat_name, i.image, i.title, ";
			$query .= " DATE_FORMAT(i.post_on, '%b %d %Y') AS date ";
			$query .= " FROM tblimages AS i ";
			$query .= " INNER JOIN tblcategories AS c";
			$query .= " USING(cat_id) ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}	

// Dung cho backend - list videos ######################################################################
	function get_all_videos($order_by){
		global $dbc;
			$query = " SELECT v.video_id, c.cat_name, v.url_video, v.title ";
			$query .= " FROM tblvideos AS v ";
			$query .= " INNER JOIN tblcategories AS c";
			$query .= " USING(cat_id) ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}	

// Dung cho backend - delete news - games #########################################################
	function delete_news($nid){
		global $dbc;
		$query = "DELETE FROM tblnews WHERE news_id = {$nid} LIMIT 1";
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}

// Dung cho backend - delete images ################################################################
	function delete_images($iid){
		global $dbc;
		$query = "DELETE FROM tblimages WHERE image_id = {$iid} LIMIT 1";
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
// Dung cho backend - delete videos ####################################################################
	function delete_videos($vid){
		global $dbc;
		$query = "DELETE FROM tblvideos WHERE video_id = {$iid} LIMIT 1";
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}

	
//  Dung cho backend - edit news - games #################################################################
	function edit_news($nid){	
	global $dbc;
		$query = "UPDATE tblnews SET ";
		$query .=" title = '{$title}', ";
		$query .=" cat_id = '{$cat_id}', ";
		$query .=" type = '{$type}', ";
		$query .=" avatar = '{$myAvatar}', ";
		$query .=" banner = '{$myBanner}', ";
		$query .=" content = '{$content}', ";
		$query .=" user_id = 1, ";	
		$query .=" post_on = NOW() ";
		$query .=" WHERE news_id = {$nid} LIMIT 1";	
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
    
//  Dung cho backend - show image #################################################################	
    function get_image_by_id($id){
		global $dbc;
			$query = "SELECT i.image_id, i.title, i.image, ";
            $query .=" DATE_FORMAT( i.post_on, '%b %d, %Y') AS date, c.cat_name "; 
            $query .=" FROM tblimages AS i ";
            $query .=" INNER JOIN tblcategories AS c ";
            $query .=" USING ( cat_id ) ";
            $query .=" WHERE i.image_id={$id} ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
	
			return $result;
	} // END of query
?> 