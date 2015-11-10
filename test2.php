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

$id = 'm-M1AtrxztU';

// Display Data 
print_r(get_youtube($id));;
?>

</body>
</html>

        
