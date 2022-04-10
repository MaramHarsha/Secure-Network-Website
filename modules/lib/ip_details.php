<?php
//Getting Country, City, Region, Map Location and Internet Service Provider
$url = 'https://ipapi.co/' . $ip . '/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
    $country      = $ip_data->{'country_name'};
    $country_code = $ip_data->{'country_code'};
    $region       = $ip_data->{'region'};
    $city         = $ip_data->{'city'};
    $latitude     = $ip_data->{'latitude'};
    $longitude    = $ip_data->{'longitude'};
    $isp          = $ip_data->{'org'};
} else {
    $country      = "Unknown";
    $country_code = "XX";
    $region       = "Unknown";
    $city         = "Unknown";
    $latitude     = "0";
    $longitude    = "0";
    $isp          = "Unknown";
}
?>