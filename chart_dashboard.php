<?php
require "core.php";

$i = 1;
$array_count  = array();

while ($i <= 12) {
	
	// SQLi Count
    $date   = date('F Y', mktime(0, 0, 0, $i, 1));
    $squery = $mysqli->query("SELECT type FROM `psec_logs` WHERE `date` LIKE '%$date' AND `type` = 'SQLi'");
    $scount = mysqli_num_rows($squery);
	
	$array_count['SQLi'][] = $scount;

	// Bad Bots Count
	$bquery = $mysqli->query("SELECT type FROM `psec_logs` WHERE `date` LIKE '%$date' AND 
							 (`type` = 'Bad Bot' or `type` = 'Fake Bot' OR type = 'Missing User-Agent header' 
							 OR type = 'Missing header Accept' OR type = 'Invalid IP Address header')");
    $bcount = mysqli_num_rows($bquery);
	
	$array_count['Bad Bot'][] = $bcount;
	
	// Proxies Count
	$pquery = $mysqli->query("SELECT type FROM `psec_logs` WHERE `date` LIKE '%$date' AND `type` = 'Proxy'");
    $pcount = mysqli_num_rows($pquery);
	
	$array_count['Proxies'][] = $pcount;
	
	// Spammers Count
	$spquery = $mysqli->query("SELECT type FROM `psec_logs` WHERE `date` LIKE '%$date' AND `type` = 'Spammer'");
    $spcount = mysqli_num_rows($spquery);
	
	$array_count['Spammers'][] = $spcount;

    $i++;
}

echo json_encode($array_count);
?>