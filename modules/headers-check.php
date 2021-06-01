<?php
//Anonymous Bots Protection
$table = $prefix . 'badbot-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection3'] == 1) {
    
    //Detect Missing User-Agent Header
    if (empty($useragent)) {
        
        $type = "Missing User-Agent header";
        
        //Logging
        if ($row['logging'] == 1) {
            psec_logging($mysqli, $prefix, $type);
        }
        
        //AutoBan
        if ($row['autoban'] == 1) {
            psec_autoban($mysqli, $prefix, $type);
        }
        
        //E-Mail Notification
        if ($srow['mail_notifications'] == 1 && $row['mail'] == 1) {
            psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $projectsecurity_path . '/pages/missing-useragent.php" />';
        exit;
    }
    
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        
        $type = "Invalid IP Address header";
        
        //Logging
        if ($row['logging'] == 1) {
            psec_logging($mysqli, $prefix, $type);
        }
        
        //AutoBan
        if ($row['autoban'] == 1) {
            psec_autoban($mysqli, $prefix, $type);
        }
        
        //E-Mail Notification
        if ($srow['mail_notifications'] == 1 && $row['mail'] == 1) {
            psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $projectsecurity_path . '/pages/invalid-ip.php" />';
        exit;
        
    }
}
?>