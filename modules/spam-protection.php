<?php
//Spam Protection
$table = $prefix . 'spam-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection'] == 1) {
    
    $dnsbl_lookup = array();
    
    $table2 = $prefix . 'dnsbl-databases';
    $query2 = $mysqli->query("SELECT * FROM `$table2`");
    while ($row2 = $query2->fetch_assoc()) {
        
        $dnsbl_lookup[] = $row2['database'];
        $reverse_ip     = implode(".", array_reverse(explode(".", $ip)));
        
        foreach ($dnsbl_lookup as $host) {
            if (checkdnsrr($reverse_ip . "." . $host . ".", "A")) {
                
                $type = "Spammer";
                
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
                
                echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '" />';
                exit;
            }
        }
    }
}
?>