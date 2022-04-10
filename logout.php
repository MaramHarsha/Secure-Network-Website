<?php
include "config.php";
if(!isset($_SESSION)) {
    session_start();
}
session_destroy();
echo '<meta http-equiv="refresh" content="0; url=' . $settings['site_url'] . '" />';
exit();
?>