<?php
$table  = $prefix . 'settings';
$squery = $mysqli->query("SELECT * FROM `$table`");
$srow   = $squery->fetch_assoc();

//Getting visitor's real IP Address
$ip = '';

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
require_once 'lib/useragent.class.php';
$useragent_data = UserAgentFactoryPSec::analyze($useragent);

//Getting Visitor Information
if ($ip == "::1") {
    $ip = "127.0.0.1";
}
$ip           = strtok($ip, ',');
//$ip           = str_replace(',', '', $ip);
//$ip           = str_replace(' ', '', $ip);
$ipnums       = explode(".", $ip);
@$ip_range    = $ipnums[0] . "." . $ipnums[1] . "." . $ipnums[2];
$page         = $_SERVER['PHP_SELF'];
$browser      = $useragent_data->browser['title'];
$browsersh    = $useragent_data->browser['name'];
$browser_code = $useragent_data->browser['code'];
$os           = $useragent_data->os['title'];
$ossh         = $useragent_data->os['name'] . " " . $useragent_data->os['version'];
$os_code      = $useragent_data->os['code'];
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER["HTTP_REFERER"];
} else {
    $referer = '';
}
$script_name = ltrim($_SERVER["SCRIPT_NAME"], '/');
@$date = @date("d F Y");
@$time = @date("H:i");

// Gets the contents of cache file if it exists (valid), otherwise grabs and caches
function psec_getcache($ip, $cache_file)
{
    global $ip, $cache_file;
    
    if (file_exists($cache_file)) {
        
        $current_time = time();
        $expire_time  = 1 * 60 * 60;
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

function psec_logging($mysqli, $prefix, $type)
{
    global $ip, $page, $querya, $date, $time, $browser, $browser_code, $os, $os_code, $useragent, $referer;
    
    $ltable     = $prefix . 'logs';
    $queryvalid = $mysqli->query("SELECT ip, page, query, type, date FROM `$ltable` WHERE ip='$ip' and page='$page' and query='$querya' and type='$type' and date='$date' LIMIT 1");
    if ($queryvalid->num_rows <= 0) {
        include_once "lib/ip_details.php";
        $log = $mysqli->query("INSERT INTO `$ltable` (`ip`, `date`, `time`, `page`, `query`, `type`, `browser`, `browser_code`, `os`, `os_code`, `country`, `country_code`, `region`, `city`, `latitude`, `longitude`, `isp`, `useragent`, `referer_url`) VALUES ('$ip', '$date', '$time', '$page', '$querya', '$type', '$browser', '$browser_code', '$os', '$os_code', '$country', '$country_code', '$region', '$city', '$latitude', '$longitude', '$isp', '$useragent', '$referer')");
    }
}

function psec_autoban($mysqli, $prefix, $type)
{
    global $ip, $date, $time;
    
    $btable    = $prefix . 'bans';
    $bansvalid = $mysqli->query("SELECT ip FROM `$btable` WHERE ip='$ip' LIMIT 1");
    if ($bansvalid->num_rows <= 0) {
        $log = $mysqli->query("INSERT INTO `$btable` (ip, date, time, reason, autoban) VALUES ('$ip', '$date', '$time', '$type', '1')");
    }
}

function psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type)
{
    global $ip, $date, $time, $browser, $os, $page, $referer, $to, $srow;
    
    $email   = 'notifications@' . $_SERVER['SERVER_NAME'] . '';
    $to      = $srow['email'];
    $subject = 'Project SECURITY - ' . $type . '';
    $message = '
					<p style="padding:0; margin:0 0 11pt 0;line-height:160%; font-size:18px;">Details of Log - ' . $type . '</p>
					<p>IP Address: <strong>' . $ip . '</strong></p>
					<p>Date: <strong>' . $date . '</strong> at <strong>' . $time . '</strong></p>
					<p>Browser:  <strong>' . $browser . '</strong></p>
					<p>Operating System:  <strong>' . $os . '</strong></p>
					<p>Threat Type:  <strong>' . $type . '</strong> </p>
					<p>Page:  <strong>' . $page . '</strong> </p>
                	<p>Referer URL:  <strong>' . $referer . '</strong> </p>
                	<p>Site URL:  <strong>' . $site_url . '</strong> </p>
                	<p>Project SECURITY URL:  <strong>' . $projectsecurity_path . '</strong> </p>
				';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'To: ' . $to . ' <' . $to . '>' . "\r\n";
    $headers .= 'From: ' . $email . ' <' . $email . '>' . "\r\n";
    @mail($to, $subject, $message, $headers);
}
?>