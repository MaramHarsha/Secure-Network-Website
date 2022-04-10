<?php
// Fake Bots Protection
if ($settings['badbot_protection2'] == 1) {

    if ($fake_bot == 1) {
            
            $type = "Fake Bot";
            
            //Logging
            if ($row['badbot_logging'] == 1) {
                psec_logging($mysqli, $type);
            }
            
            //AutoBan
            if ($row['badbot_autoban'] == 1) {
                psec_autoban($mysqli, $type);
            }
            
            //E-Mail Notification
            if ($srow['mail_notifications'] == 1 && $row['badbot_mail'] == 1) {
                psec_mail($mysqli, $type);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $settings['projectsecurity_path'] . '/pages/fakebot-detected.php" />';
            exit;
    }
}
?>