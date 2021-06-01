<?php
//Fake Bots Protection
$table = $prefix . 'badbot-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection2'] == 1) {
    
    @$hostname = strtolower(gethostbyaddr($ip));
    
    //Fake Googlebot Detection
    if (strpos(strtolower($useragent), "googlebot") !== false) {
        if (strpos($hostname, "googlebot.com") !== false OR strpos($hostname, "google.com") !== false) {
        } else {
            
            $type = "Fake Bot";
            
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
                psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type, $srow['email']);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $projectsecurity_path . '/pages/fakebot-detected.php" />';
            exit;
        }
    }
    
    //Fake Bingbot Detection
    if (strpos(strtolower($useragent), "bingbot") !== false) {
        if (strpos($hostname, "search.msn.com") !== false) {
        } else {
            
            $type = "Fake Bot";
            
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
                psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type, $srow['email']);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $projectsecurity_path . '/pages/fakebot-detected.php" />';
            exit;
        }
    }
    
    //Fake Yahoo Bot Detection
    if (strpos(strtolower($useragent), "yahoo! slurp") !== false) {
        if (strpos($hostname, "yahoo.com") !== false OR strpos($hostname, "crawl.yahoo.net")) {
        } else {
            
            $type = "Fake Bot";
            
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
            
            echo '<meta http-equiv="refresh" content="0;url=' . $projectsecurity_path . '/pages/fakebot-detected.php" />';
            exit;
        }
    }
}
?>