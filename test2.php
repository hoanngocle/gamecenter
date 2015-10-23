<!DOCTYPE html>
<html>
<head>
     <link rel="shortcut icon" href="gamemagazine.ico">
      <script src="../js/bootbox.min.js"></script>
  <?php include('includes/backend/mysqli_connect.php'); 
include('includes/functions.php');?>

    
</head>
<body>

    <?php

$rs = login_user('beosagittarius', '12345678');
 $user = mysqli_fetch_array($rs, MYSQLI_ASSOC);
var_dump($user);die;
?>

</body>
</html>

        
