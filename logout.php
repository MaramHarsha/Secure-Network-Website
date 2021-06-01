<?php
include_once "config.php";
if(!isset($_SESSION)) {
    session_start();
}
session_destroy();
echo '<meta http-equiv="refresh" content="0; url=' . $site_url . '" />';
exit();
?>