<?php
// Test Integration

// CSS Style
echo '
<style>
#psec_confbox {
    position: absolute;
    border-style: solid;
    border-color: black;
    border-width: 3px;
    background-color: green;
    text-align: center;
    color: white;
    font-size: large;
    width: 100%;
	z-index: 99999;
}
</style>';

// HTML Confirmation Message
echo '<p id="psec_confbox">Project SECURITY integration is correct.</p>';
?>