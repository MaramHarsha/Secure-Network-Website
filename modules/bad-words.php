<?php
//Bad Words
$table   = $prefix . 'bad-words';
$queryfc = $mysqli->query("SELECT * FROM `$table`");
$countfc = mysqli_num_rows($queryfc);

if ($countfc > 0) {
    
    //Content Filtering
    function bad_words($buffer, $mysqli, $prefix)
    {
        
        $table  = $prefix . 'bad-words';
        $query1 = $mysqli->query("SELECT * FROM `$table`");
        $table  = $prefix . 'settings';
        $squery = $mysqli->query("SELECT * FROM `$table`");
        $srow   = $squery->fetch_assoc();
        
        while ($row1 = $query1->fetch_array()) {
            $buffer = str_replace($row1['word'], $srow['badword_replace'], $buffer);
        }
        
        return $buffer;
    }
    
    //ob_start();
    ob_start(function($buffer) use ($mysqli, $prefix)
    {
    return bad_words($buffer, $mysqli, $prefix);
    });
    
    //POST Filtering
    function badwords_checker($input, $mysqli, $prefix)
    {
        $table  = $prefix . 'settings';
        $squery = $mysqli->query("SELECT * FROM `$table`");
        $srow   = $squery->fetch_assoc();
        $table2 = $prefix . 'bad-words';
        $query2 = $mysqli->query("SELECT * FROM `$table2`");
        
        while ($row2 = $query2->fetch_array()) {
            $badwords2[] = $row2['word'];
        }
        
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = badwords_checker($val, $mysqli, $prefix);
            }
        } else {
            $query2 = $mysqli->query("SELECT * FROM `$table2`");
            while ($row3 = $query2->fetch_array()) {
                $input = str_replace($row3['word'], $srow['badword_replace'], $input);
                
            }
            $output = $input;
        }
        return @$output;
    }
    
    $_POST = badwords_checker($_POST, $mysqli, $prefix);
    //$_GET  = badwords_checker($_GET);
}
?>