<!DOCTYPE html>
<html>
<head>
  <?php include('includes/backend/mysqli_connect.php'); ?>
    <?php include('search_algo.php'); ?>
</head>
<body>
    <form action="/search_algo.php" method="get">
    <input type="text" name="query" placeholder="Search term"/>
    <input type="submit" value="Search"/>
</form>
    <?php
    
    
    
    function save_thumbnail_from_url($url, $name){
        
        $ch = curl_init($url);
        $fp = fopen('images/'.$name.'.jpg', 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        return $name;
    }
    $url = 'http://img.cdn.ved.com.vn/web/lmht360/wp-content/uploads/2015/09/cloud9-groupb.jpg';
    $name = 'beo';
    save_thumbnail_from_url($url, $name)
    
    
    ?>

</body>
</html>

        
