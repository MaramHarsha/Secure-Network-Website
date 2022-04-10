<?php
include "config.php";
include "modules/core.php";

// Checking if the visitor is in the Whitelist
$wquery  = $mysqli->query("SELECT ip FROM `psec_ip-whitelist` WHERE ip='$ip' LIMIT 1");
$wfquery = $mysqli->query("SELECT path FROM `psec_file-whitelist` WHERE path='$script_name' LIMIT 1");
if ($wquery->num_rows <= 0 && $wfquery->num_rows <= 0) {
    
    // Error Reporting
    if ($settings['error_reporting'] == 1) {
        @error_reporting(0);
    }
    if ($settings['error_reporting'] == 2) {
        @error_reporting(E_ERROR | E_WARNING | E_PARSE);
    }
    if ($settings['error_reporting'] == 3) {
        @error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    }
    if ($settings['error_reporting'] == 4) {
        @error_reporting(E_ALL & ~E_NOTICE);
    }
    if ($settings['error_reporting'] == 5) {
        @error_reporting(E_ALL);
    }
    
    // Displaying Errors
    if ($settings['display_errors'] == 1) {
        @ini_set('display_errors', '1');
    } else {
        @ini_set('display_errors', '0');
    }
    
    if ($settings['test_integration'] == 1) {
        include "modules/test-integration.php";
    }
    
    // Checking if Project SECURITY is enabled
    if ($settings['project_security'] == 1) {
        include "modules/live-traffic.php";
		include "modules/ban-system.php";
        include "modules/sqli-protection.php";
        if ($searchengine_bot == 0) {
            include "modules/proxy-protection.php";
            include "modules/spam-protection.php";
        }
        include "modules/badbots-protection.php";
        include "modules/fakebots-protection.php";
        include "modules/bad-words.php";
        include "modules/headers-check.php";
    }
}
?>