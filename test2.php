<html>
    <head>
        <title></title>
        <?php //require_once 'includes/class.smtp.php'; ?>
        <?php require_once 'includes/functions.php'; ?>
    </head>
    <body>
        <?php
           $to = "hoancn1.ptit@gmail.com";
           $subject = "tesst";
           $body = "meomoeoemeogm";
        if(sendmail($to, $subject, $body) == true){
            echo "true";
        }  else {
        echo "fail";    
        }
            
        ?>
    </body>
</html>
