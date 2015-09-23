<?php 

    require_once 'includes/PHPMailer/class.phpmailer.php'; 
    require_once 'includes/PHPMailer/PHPMailerAutoload.php'; 
	// xac dinh hang so cho dia chi tuyet doi
	define ('BASE_URL', 'http://www.gamecenter.dev/');

// INCLUDE - CONFIRM  =================================================================
	function confirm_query($result, $query) {
		global $dbc;
		if (!$result) {
			die ("Query {$query} \n <br> MySQL Error: " .mysqli_error($dbc));
		}
	}	
    
// INCLUDE - REDIRECT =================================================================
	// tai dinh huong nguoi dung
	function redirect_to($page = 'index.php') {
		$url = BASE_URL . $page;
		header ("Location: {$url}");
		exit();
	}

// INCLUDE - EXCERPT ==========================================================
	// ham cat chu cuoi cung cua phan content thanh doan van ngan
	function excerpt($text) {
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		if(strlen($sanitized) > 400 ) {
			$cutString = substr($sanitized,0,500);
			$words = substr($sanitized, 0, strrpos($cutString, ' '));
			return $words;
		} else {
			return $sanitized;
		}

	}// END the excerpt
    
// INCLUDE - EXCERPT FEATURE ==========================================================
	// ham cat chu cuoi cung cua phan content thanh doan van ngan
	function excerpt_features($text) {
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		if(strlen($sanitized) > 600 ) {
			$cutString = substr($sanitized,0,500);
			$words = substr($sanitized, 0, strrpos($cutString, ' '));
			return $words;
		} else {
			return $sanitized;
		}

	}// END the excerpt

// INCLUDE - Tao paragraph ID ==========================================================
	// Tao paragraph tu CSDL
	function the_content($text){
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		return str_replace(array("\r\n", "\n"), array("<p>" , "</p>"), $sanitized);
	}
    
// INCLUDE - VALIDATE ID ===============================================================
	// ham kiem tra xem GET co gia tri hay ko, $id co hop le, la dang so hay ko
	function validate_id($id){
		if (isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1 ))) {
			$val_id = $id;
			return $val_id;
		}else {
			return null;
		}
	} // End validate_id

// INCLUDE - GET 1 NEW by ID ===========================================================
	function get_news_by_id($nid){
		global $dbc;
			$query = "SELECT n.news_id, n.title, n.content, n.banner, n.image, t.type_name, n.status, ";
			$query .= " DATE_FORMAT( n.post_on, '%b') AS month, ";
			$query .= " DATE_FORMAT( n.post_on, '%d') AS day, ";
			$query .= " DATE_FORMAT( n.post_on, '%b %d, %Y') AS date, ";
			$query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tblusers AS u ";
			$query .= " USING ( user_id ) ";
			$query .= " INNER JOIN tbltypes AS t ";
			$query .= " USING ( type_id ) ";
			$query .= " WHERE n.news_id={$nid} LIMIT 1";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
	
			return $result;
	} // END of query

// CLIENT SITE [start]==================================================================
 
// FRONTEND - BANNER ==================================================================
	function get_banner(){
		global $dbc;
		// Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
			$query = " SELECT i.image_id, i.image, i.title, t.type_name, ";
            $query .= " DATE_FORMAT(post_on, '%b %d, %y') AS date ";
			$query .= " FROM tblimages as i";
			$query .= " INNER JOIN tbltypes AS t ";
			$query .= " USING (type_id) ";
            $query .= " WHERE t.type_name = 'Banner' ";
			$query .= " ORDER BY date LIMIT 0, 3";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	}

// FRONTEND - NEW GAME =================================================================
	function get_new_games(){
		global $dbc;
		// Cau lenh SQL goi tu CSDL sap xep theo ngay thang va gioi han 8 result
			$query = " SELECT n.news_id, n.title, n.content, n.image, t.type_name, c.cat_name,  ";
			$query .= " DATE_FORMAT(post_on, '%b %d, %y') AS date ";
            $query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tbltypes AS t ";
			$query .= " USING ( type_id ) ";
            $query .= " INNER JOIN tblcategories AS c ";
			$query .= " USING ( cat_id ) ";
			$query .= " WHERE c.cat_name = 'Games' ";
			$query .= " ORDER BY date LIMIT 0, 8";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	}

// FRONTEND - BEST FEATURE - IMAGE =====================================================
    function get_features(){
		global $dbc;
			$query = "SELECT n.news_id, n.title, n.content, t.type_name,  ";
			$query .= " DATE_FORMAT( n.post_on, '%b') AS month, ";
			$query .= " DATE_FORMAT( n.post_on, '%d') AS day, ";
			$query .= " DATE_FORMAT( n.post_on, '%b %d, %Y') AS date ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tbltypes AS t ";
			$query .= " USING ( type_id ) ";
			$query .= " WHERE t.type_name = 'Feature' LIMIT 1";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
	
			return $result;
	} // END of query
    
// FRONTEND - HOTEST - NEW - comment nhieu nhat ========================================
	function get_hotest_news(){
		global $dbc;
		// Query lay gia tri tu co so du lieu ra
			$query = "SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.post_on, '%d %b, %Y') AS date, cat.cat_name,  ";
			$query .= " COUNT(c.comment_id) AS count ";
			$query .= " FROM tblnews AS n ";
            $query .= " INNER JOIN tbltypes AS t";
            $query .= " USING (type_id)";
            $query .= " INNER JOIN tblcategories AS cat";
            $query .= " USING (cat_id)";
			$query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";	
			$query .= " WHERE cat.cat_name = 'News' AND n.status = 1 ";
			$query .= " GROUP BY n.title ";
			$query .= " ORDER BY count DESC LIMIT 0, 3 ";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	} // END of query

// FRONTEND - LASTEST - NEW - bai viet moi nhat ========================================
	function get_lastest_news(){
		global $dbc;
		// Query lay gia tri tu co so du lieu ra
			$query = "SELECT n.news_id, n.image, n.title, DATE_FORMAT(n.post_on, '%d %b, %Y') AS date, cat.cat_name,  ";
			$query .= " COUNT(c.comment_id) AS count ";
			$query .= " FROM tblnews AS n ";
            $query .= " INNER JOIN tbltypes AS t";
            $query .= " USING (type_id)";
            $query .= " INNER JOIN tblcategories AS cat";
            $query .= " USING (cat_id)";
			$query .= " LEFT JOIN tblcomment AS c ON n.news_id = c.news_id ";	
			$query .= " WHERE cat.cat_name = 'News' AND n.status = 1 ";
			$query .= " GROUP BY n.title ";
			$query .= " ORDER BY date DESC LIMIT 0, 3 ";

			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	} // END of query
    

// FRONTEND : send mail ========================================
	function sendmail($to, $subject, $body){
		$mail = new PHPMailer(); // create a new object
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587; // or 587
            $mail->IsHTML(true);
            $mail->Username = "hoancn1.ptit@gmail.com";
            $mail->Password = "beo05121993";
            $mail->SetFrom("hoancn1.ptit@gmail.com", "GameMagazine");
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            if (!$mail->Send()) {
                return false;
            } else {
                return true;
            }

	} // END of query
    
    // FRONTEND : check exist username and email ========================================
	function checkUsernameAndEmail($username, $email){
		global $dbc;
            $query = "SELECT user_id FROM tblusers WHERE email = '{$email}' OR username = '{$username}'";
			// Tra ve result or bao loi ra man hinh
			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);

			return $result;
	} // END of query
    
// ADMIN SITE [start] ======================================================================
    
//  BACKEND - LIST SHOW NEW  ===============================================================
	function get_all_news($order_by){
		global $dbc;
			$query = "SELECT n.news_id, t.type_name, n.title, n.content, n.status, c.cat_name, ";
			$query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
			$query .= " DATE_FORMAT(n.post_on, '%b %d %Y') AS date ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tblusers AS u ";
			$query .= " USING(user_id) ";
			$query .= " INNER JOIN tbltypes AS t";
			$query .= " USING (type_id) ";
            $query .= " INNER JOIN tblcategories AS c";
			$query .= " USING (cat_id) ";
            $query .= " WHERE cat_id = 1 ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}
    
//  BACKEND - LIST SHOW GAME  ===============================================================
	function get_all_games($order_by){
		global $dbc;
			$query = "SELECT n.news_id, t.type_name, n.title, n.content, n.status, c.cat_name, ";
			$query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
			$query .= " DATE_FORMAT(n.post_on, '%b %d %Y') AS date ";
			$query .= " FROM tblnews AS n ";
			$query .= " INNER JOIN tblusers AS u ";
			$query .= " USING(user_id) ";
			$query .= " INNER JOIN tbltypes AS t";
			$query .= " USING (type_id) ";
            $query .= " INNER JOIN tblcategories AS c";
			$query .= " USING (cat_id) ";
            $query .= " WHERE cat_id = 2 ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}
	
//  BACKEND - LIST SHOW IMAGE  ==============================================================
	function get_all_images($order_by){
		global $dbc;
			$query = " SELECT i.image_id, t.type_name, i.image, i.title, i.status,  ";
            $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
			$query .= " DATE_FORMAT(i.post_on, '%b %d %Y') AS date ";
			$query .= " FROM tblimages AS i ";
            $query .= " INNER JOIN tblusers AS u ";
			$query .= " USING(user_id) ";
			$query .= " INNER JOIN tbltypes AS t";
			$query .= " USING(type_id) ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}	

//  BACKEND - LIST SHOW VIDEO  ==============================================================
	function get_all_videos($order_by){
		global $dbc;
			$query = " SELECT v.video_id, t.type_name, v.url_video, v.title, v.description, v.status,  ";
            $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, ";
            $query .= " DATE_FORMAT(v.post_on, '%b %d %Y') AS date ";
			$query .= " FROM tblvideos AS v ";
            $query .= " INNER JOIN tblusers AS u ";
			$query .= " USING(user_id) ";
			$query .= " INNER JOIN tbltypes AS t";
			$query .= " USING(type_id) ";
			$query .= " ORDER BY {$order_by} ASC ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
				
			return $result;
	}	

//  BACKEND - DELETE NEWS - GAMES ============================================================
	function delete_news_games($nid){
		global $dbc;
		$query = "DELETE FROM tblnews WHERE news_id = {$nid} LIMIT 1";
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}

//  BACKEND - DELETE IMAGE  ===================================================================
	function delete_images($iid){
		global $dbc;
		$query = "DELETE FROM tblimages WHERE image_id = {$iid} LIMIT 1";
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
    
//  BACKEND - DELETE VIDEO  ===================================================================
	function delete_videos($vid){
		global $dbc;
		$query = "DELETE FROM tblvideos WHERE video_id = {$vid} LIMIT 1";
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
	
//  BACKEND - EDIT - NEWS - GAMES  ============================================================
	function edit_news_games($nid, $title, $type_id, $myAvatar, $myBanner, $content, $status){	
	global $dbc;
		$query = "UPDATE tblnews SET ";
		$query .=" title = '{$title}', ";
		$query .=" type_id = '{$type_id}', ";
		$query .=" image = '{$myAvatar}', ";
		$query .=" banner = '{$myBanner}', ";
		$query .=" content = '{$content}', ";
        $query .=" status = '{$status}', ";
		$query .=" user_id = 1, ";	
		$query .=" post_on = NOW() ";
		$query .=" WHERE news_id = {$nid} LIMIT 1";	
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
    
//  BACKEND - EDIT - IMAGE ===================================================================
	function edit_image($iid, $title, $type_id, $myImage, $status){	
	global $dbc;
		$query = "UPDATE tblimages SET ";
		$query .=" title = '{$title}', ";
		$query .=" type_id = '{$type_id}', ";
		$query .=" image = '{$myImage}', ";
        $query .=" status = '{$status}', ";
		$query .=" user_id = 1, ";	
		$query .=" post_on = NOW() ";
		$query .=" WHERE image_id = {$iid} LIMIT 1";	
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
 
//  BACKEND - EDIT - VIDEO ===================================================================
	function edit_video($vid, $title, $type_id, $url_video, $description, $status){	
	global $dbc;
		$query = "UPDATE tblimages SET ";
		$query .=" title = '{$title}', ";
		$query .=" type_id = '{$type_id}', ";
		$query .=" url_video = '{$url_video}', ";
        $query .=" description = '{$description}', ";
        $query .=" status = '{$status}', ";
		$query .=" user_id = 1, ";	
		$query .=" post_on = NOW() ";
		$query .=" WHERE video_id = {$vid} LIMIT 1";	
		
		$result = mysqli_query($dbc,$query);
		confirm_query($result, $query);

		return $result;
	}
    
//  BACKEND - SHOW IMAGE =====================================================================
    function get_image_by_id($iid){
		global $dbc;
			$query = "SELECT i.image_id, t.type_name, i.image, i.title, i.status, ";
            $query .=" DATE_FORMAT( i.post_on, '%b %d, %Y') AS date, "; 
            $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
            $query .=" FROM tblimages AS i ";
            $query .=" INNER JOIN tblusers AS u ";
            $query .=" USING ( user_id ) ";
            $query .=" INNER JOIN tbltypes AS t ";
            $query .=" USING ( type_id ) ";
            $query .=" WHERE i.image_id= {$iid} ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
	
			return $result;
	} // END of query

//  BACKEND - SHOW VIDEO =====================================================================	
    function get_video_by_id($iid){
		global $dbc;
			$query = "SELECT i.image_id, t.type_name, i.image, i.title, i.status, ";
            $query .=" DATE_FORMAT( i.post_on, '%b %d, %Y') AS date, "; 
            $query .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
            $query .=" FROM tblimages AS i ";
            $query .=" INNER JOIN tblusers AS u ";
            $query .=" USING ( user_id ) ";
            $query .=" INNER JOIN tbltypes AS t ";
            $query .=" USING ( type_id ) ";
            $query .=" WHERE i.image_id= {$iid} ";

			$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
	
			return $result;
	} // END of query


//  BACKEND - get id youtube =====================================================================	
    function youtube_id_from_url($url) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}


?> 