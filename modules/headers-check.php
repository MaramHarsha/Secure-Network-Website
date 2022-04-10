<?php
//Anonymous Bots Protection
if ($settings['badbot_protection3'] == 1) {
    
    //Detect Missing User-Agent Header
    if (empty($useragent)) {
        
        $type = "Missing User-Agent header";
        
        //Logging
        if ($settings['badbot_logging'] == 1) {
            psec_logging($mysqli, $type);
        }
        
        //AutoBan
        if ($settings['badbot_autoban'] == 1) {
            psec_autoban($mysqli, $type);
        }
        
        //E-Mail Notification
        if ($settings['mail_notifications'] == 1 && $settings['badbot_mail'] == 1) {
            psec_mail($mysqli, $type);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $settings['projectsecurity_path'] . '/pages/missing-useragent.php" />';
        exit;
    }
    
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        
        $type = "Invalid IP Address header";
        
        //Logging
        if ($settings['badbot_logging'] == 1) {
            psec_logging($mysqli, $type);
        }
        
        //AutoBan
        if ($settings['badbot_autoban'] == 1) {
            psec_autoban($mysqli, $type);
        }
        
        //E-Mail Notification
        if ($settings['mail_notifications'] == 1 && $settings['badbot_mail'] == 1) {
            psec_mail($mysqli, $type);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $settings['projectsecurity_path'] . '/pages/invalid-ip.php" />';
        exit;
        
    }
}
?>