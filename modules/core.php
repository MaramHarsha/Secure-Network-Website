<?php
//Getting visitor's real IP Address
$ip      = '';
$ip_type = '';

if (isset($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    // When website is behind CloudFlare
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP']; 
} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED'];
} elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_FORWARDED_FOR'];
} elseif (isset($_SERVER['HTTP_FORWARDED'])) {
    $ip = $_SERVER['HTTP_FORWARDED'];
} elseif (isset($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
}

//Getting Browser and Operating System
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
} else {
    $useragent = '';
}
require 'lib/useragent.class.php';
$useragent_data = UserAgentFactoryPSec::analyze($useragent);

//Getting Visitor Information
if ($ip == "::1") {
    $ip = "127.0.0.1";
}
$ip           = strtok($ip, ',');
//$ip           = str_replace(',', '', $ip);
//$ip           = str_replace(' ', '', $ip);
if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {    
    $ip_type = "v4";
}
else if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) { 
    $ip_type = "v6";
}

if ($ip_type == "v4") {
	$ipnums       = explode(".", $ip);
	@$ip_range    = $ipnums[0] . "." . $ipnums[1] . "." . $ipnums[2];
}
else if ($ip_type == "v6") {
	$ipnums       = explode(":", $ip);
	@$ip_range    = $ipnums[0] . ":" . $ipnums[1] . ":" . $ipnums[2] . ":" . $ipnums[3];
}

// Browser
$browser      = $useragent_data->browser['title'];
$browsersh    = $useragent_data->browser['name'];
$browser_code = $useragent_data->browser['code'];

// Operating System
$os           = $useragent_data->os['title'];
$ossh         = $useragent_data->os['name'] . " " . $useragent_data->os['version'];
$os_code      = $useragent_data->os['code'];

// Referrer
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER["HTTP_REFERER"];
} else {
    $referer = '';
}

// Page and Path
$page        = $_SERVER['PHP_SELF'];
$script_name = ltrim($_SERVER["SCRIPT_NAME"], '/');
$querya      = strip_tags(addslashes($_SERVER['QUERY_STRING']));
$actual_url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Date and Time
@$date = @date("d F Y");
@$time = @date("H:i");

// Check if Search Engine Bot
@$hostname        = strtolower(gethostbyaddr($ip));
$searchengine_bot = 0;
$fake_bot         = 0;
if (strpos(strtolower($useragent), "googlebot") !== false) {
    if (strpos($hostname, "googlebot.com") !== false OR strpos($hostname, "google.com") !== false) {
        $searchengine_bot = 1;
    } else {
        $fake_bot = 1;
    }
}
if (strpos(strtolower($useragent), "bingbot") !== false) {
    if (strpos($hostname, "search.msn.com") !== false) {
        $searchengine_bot = 1;
    } else {
        $fake_bot = 1;
    }
}
if (strpos(strtolower($useragent), "yahoo! slurp") !== false) {
    if (strpos($hostname, "yahoo.com") !== false OR strpos($hostname, "crawl.yahoo.net")) {
        $searchengine_bot = 1;
    } else {
        $fake_bot = 1;
    }
}
if (strpos(strtolower($useragent), "yandex") !== false) {
    if (strpos($hostname, "yandex.ru") !== false OR strpos($hostname, "yandex.net") OR strpos($hostname, "yandex.com")) {
        $searchengine_bot = 1;
    } else {
        $fake_bot = 1;
    }
}

// Gets the contents of cache file if it exists (valid), otherwise grabs and caches
function psec_getcache($cache_file)
{
    global $cache_file;
    
    if (file_exists($cache_file)) {
        
        $current_time = time();
        //$expire_time  = 1 * 60 * 60; // 1 hour
		$expire_time  = 1 * 24 * 60 * 60; // 1 day
        $file_time    = filemtime($cache_file);
        
        if ($current_time - $expire_time < $file_time) {
            return file_get_contents($cache_file);
        } else {
			return 'PSEC_NoCache';
		}
    } else {
		return 'PSEC_NoCache';
	}
}

function psec_logging($mysqli, $type)
{
    global $ip, $page, $querya, $date, $time, $browser, $browser_code, $os, $os_code, $useragent, $referer;
    
    $queryvalid = $mysqli->query("SELECT ip, page, query, type, date FROM `psec_logs` WHERE ip='$ip' and page='$page' and query='$querya' and type='$type' and date='$date' LIMIT 1");
    if ($queryvalid->num_rows <= 0) {
        include "lib/ip_details.php";
        $log = $mysqli->query("INSERT INTO `psec_logs` (`ip`, `date`, `time`, `page`, `query`, `type`, `browser`, `browser_code`, `os`, `os_code`, `country`, `country_code`, `region`, `city`, `latitude`, `longitude`, `isp`, `useragent`, `referer_url`) VALUES ('$ip', '$date', '$time', '$page', '$querya', '$type', '$browser', '$browser_code', '$os', '$os_code', '$country', '$country_code', '$region', '$city', '$latitude', '$longitude', '$isp', '$useragent', '$referer')");
    }
}

function psec_autoban($mysqli, $type)
{
    global $ip, $date, $time;
    
    $bansvalid = $mysqli->query("SELECT ip FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
    if ($bansvalid->num_rows <= 0) {
        $log = $mysqli->query("INSERT INTO `psec_bans` (ip, date, time, reason, autoban) VALUES ('$ip', '$date', '$time', '$type', '1')");
    }
}

function psec_mail($mysqli, $type)
{
    global $ip, $date, $time, $browser, $os, $page, $referer, $to, $settings;
    
    $email   = 'notifications@' . $_SERVER['SERVER_NAME'] . ''; // Strip www.
    $to      = $settings['email'];
    $subject = 'Project SECURITY - ' . $type . '';
    $message = '
					<h2>Details of Log - ' . $type . '</h2>
					<p>IP Address: <strong>' . $ip . '</strong></p>
					<p>Date: <strong>' . $date . '</strong> at <strong>' . $time . '</strong></p>
					<p>Browser:  <strong>' . $browser . '</strong></p>
					<p>Operating System:  <strong>' . $os . '</strong></p>
					<p>Threat Type:  <strong>' . $type . '</strong> </p>
					<p>Page:  <strong>' . $page . '</strong> </p>
                	<p>Referer URL:  <strong>' . $referer . '</strong> </p>
                	<p>Site URL:  <strong>' . $settings['site_url'] . '</strong> </p>
                	<p>Project SECURITY URL:  <strong>' . $settings['projectsecurity_path'] . '</strong> </p>
				';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: ' . $email . '';
    @mail($to, $subject, $message, $headers);
}
?>