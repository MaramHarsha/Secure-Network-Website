<?php
$cache_file = __DIR__ . "/cache/ip-details/". str_replace(":", "-", $ip) .".json";

//Ban System
$querybanned = $mysqli->query("SELECT ip FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
if ($querybanned->num_rows > 0) {
    $bannedpage_url = $settings['projectsecurity_path'] . "/pages/banned.php";
    echo '<meta http-equiv="refresh" content="0;url=' . $bannedpage_url . '" />';
    exit;
}

//IP Ranges
$querybanned = $mysqli->query("SELECT ip_range FROM `psec_bans-ranges` WHERE ip_range='$ip_range' LIMIT 1");
if ($querybanned->num_rows > 0) {
    $bannedpage_url = $settings['projectsecurity_path'] . "/pages/banned.php";
    echo '<meta http-equiv="refresh" content="0;url=' . $bannedpage_url . '" />';
    exit;
}

//Blocking Country
$query1 = $mysqli->query("SELECT * FROM `psec_bans-country`");

$query2 = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type = 'isp'");
if ($query1->num_rows > 0 OR $query2->num_rows > 0) {
	if (psec_getcache($cache_file) == 'PSEC_NoCache') {
		$url = 'https://ipapi.co/' . $ip . '/json/';
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		@curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
		@$ipcontent = curl_exec($ch);
		curl_close($ch);
    
		$ip_data = @json_decode($ipcontent);
		
		// Grabs API Response and Caches
		file_put_contents($cache_file, $ipcontent);
		
	} else {
		$ip_data = @json_decode(psec_getcache($cache_file));
	}
		
    if ($ip_data && !isset($ip_data->{'error'})) {
        $country_check = $ip_data->{'country_name'};
        $isp_check     = $ip_data->{'org'};
		
		if($country_check == '') {
			$country_check = "Unknown";
		}
    } else {
        $country_check = "Unknown";
        $isp_check     = "Unknown";
    }
    
} else {
    @$isp_check = "Unknown";
    @$country_check = "Unknown";
}

@$querybanned = $mysqli->query("SELECT id, country FROM `psec_bans-country` WHERE country='$country_check'");
@$rowcb = mysqli_fetch_array($querybanned);

if ($settings['countryban_blacklist'] == 1) {
    if ($querybanned->num_rows > 0) {
        $bannedcpage_url = $settings['projectsecurity_path'] . "/pages/banned-country.php?c_id=" . $rowcb['id'];
		echo '<meta http-equiv="refresh" content="0;url=' . $bannedcpage_url . '" />';
        exit;
    }
} else {
    if (strpos(strtolower($useragent), "googlebot") !== false OR strpos(strtolower($useragent), "bingbot") !== false OR strpos(strtolower($useragent), "yahoo! slurp") !== false OR strpos(strtolower($useragent), "yandex") !== false) {
    } else {
        if ($querybanned->num_rows <= 0) {
            $bannedcpage_url = $settings['projectsecurity_path'] . "/pages/banned-country.php";
            echo '<meta http-equiv="refresh" content="0;url=' . $bannedcpage_url . '" />';
            exit;
        }
    }
}

//Blocking Browser
$querybanned = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='browser'");
while ($rowb = $querybanned->fetch_assoc()) {
    if (strpos(strtolower($browser), strtolower($rowb['value'])) !== false) {
        $blockedbpage_url = $settings['projectsecurity_path'] . "/pages/blocked-browser.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $blockedbpage_url . '" />';
        exit;
    }
}

//Blocking Operating System
$querybanned = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='os'");
while ($rowo = $querybanned->fetch_assoc()) {
    if (strpos(strtolower($os), strtolower($rowo['value'])) !== false) {
        $blockedopage_url = $settings['projectsecurity_path'] . "/pages/blocked-os.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $blockedopage_url . '" />';
        exit;
    }
}

//Blocking Internet Service Provider
$querybanned = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='isp'");
while ($rowi = $querybanned->fetch_assoc()) {
    if (strpos(strtolower($isp_check), strtolower($rowi['value'])) !== false) {
        $blockedipage_url = $settings['projectsecurity_path'] . "/pages/blocked-isp.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $blockedipage_url . '" />';
        exit;
    }
}

//Blocking Referrer
$querybanned = $mysqli->query("SELECT * FROM `psec_bans-other` WHERE type='referrer'");
while ($rowr = $querybanned->fetch_assoc()) {
    if (strpos(strtolower(@$referer), strtolower($rowr['value'])) !== false) {
        $blockedrpage_url = $settings['projectsecurity_path'] . "/pages/blocked-referrer.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $blockedrpage_url . '" />';
        exit;
    }
}
?>