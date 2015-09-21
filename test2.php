<html>
    <head>
        <title></title>
        
    </head>
    <body>
        <?php 
            // PHP
            $text = "ぁ あ ぃ い ぅ う ぇ え ぉ お か が き ぎ く ぐ け ";
            $pattern = "/[\x{3041}-\x{3096}]/u";
            preg_match_all($pattern, $text, $matches);
            echo $matches;
        ?>
    </body>
</html>
