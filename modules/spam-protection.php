<?php
//Spam Protection
if ($settings['spam_protection'] == 1) {
    
    $dnsbl_lookup = array();
    
    $query = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
    while ($row = $query->fetch_assoc()) {
        
        $dnsbl_lookup[] = $row['database'];
        $reverse_ip     = implode(".", array_reverse(explode(".", $ip)));
        
        foreach ($dnsbl_lookup as $host) {
            if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {
                
                $type = "Spammer";
                
                //Logging
                if ($settings['spam_logging'] == 1) {
                    psec_logging($mysqli, $type);
                }
                
                //E-Mail Notification
                if ($settings['mail_notifications'] == 1 && $settings['spam_mail'] == 1) {
                    psec_mail($mysqli, $type);
                }
                
                echo '<meta http-equiv="refresh" content="0;url=' . $settings['spam_redirect'] . '" />';
                exit;
            }
        }
    }
}
?>