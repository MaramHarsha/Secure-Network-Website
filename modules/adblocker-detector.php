<?php
//AdBlock Detector
$table = $prefix . 'adblocker-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['detection'] == 1) {

    echo '
<script type="text/javascript">
function adBlockDetected() {
	window.location = "' . $row['redirect'] . '";
}

if(typeof fuckAdBlock !== "undefined" || typeof FuckAdBlock !== "undefined") {
	adBlockDetected();
} else {
	var importFAB = document.createElement("script");
	importFAB.onload = function() {
		fuckAdBlock.onDetected(adBlockDetected)
	};
	importFAB.onerror = function() {
		adBlockDetected(); 
	};
	importFAB.integrity = "sha256-xjwKUY/NgkPjZZBOtOxRYtK20GaqTwUCf7WYCJ1z69w=";
	importFAB.crossOrigin = "anonymous";
	importFAB.src = "https://cdnjs.cloudflare.com/ajax/libs/fuckadblock/3.2.1/fuckadblock.min.js";
	document.head.appendChild(importFAB);
}
</script>
	';
    
}
?>