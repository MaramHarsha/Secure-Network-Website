<?php
//Bad Words
$queryfc = $mysqli->query("SELECT * FROM `psec_bad-words`");
$countfc = mysqli_num_rows($queryfc);

if ($countfc > 0) {
    
    //Content Filtering
    function bad_words($buffer, $mysqli)
    {
        global $settings;
		
		$query1 = $mysqli->query("SELECT * FROM `psec_bad-words`");

        while ($row1 = $query1->fetch_array()) {
            $buffer = str_replace($row1['word'], $settings['badword_replace'], $buffer);
        }
        
        return $buffer;
    }
    
    ob_start(function($buffer) use ($mysqli) {
        return bad_words($buffer, $mysqli);
    });
    
    //POST Filtering
    function badwords_checker($input, $mysqli)
    {
        global $settings;
		
		$query2 = $mysqli->query("SELECT * FROM `psec_bad-words`");
        
        while ($row2 = $query2->fetch_array()) {
            $badwords2[] = $row2['word'];
        }
        
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = badwords_checker($val, $mysqli);
            }
        } else {
            $query2 = $mysqli->query("SELECT * FROM `psec_bad-words`");
            while ($row3 = $query2->fetch_array()) {
                $input = str_replace($row3['word'], $settings['badword_replace'], $input);
                
            }
            $output = $input;
        }
        return @$output;
    }
    
    $_POST = badwords_checker($_POST, $mysqli);
    //$_GET  = badwords_checker($_GET);
}
?>