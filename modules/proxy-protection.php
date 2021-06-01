<?php
//Proxy Protection
$table = $prefix . 'proxy-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

$cache_file = __DIR__ . "/cache/proxy/". $ip .".json";

//Method 1
if ($row['protection'] > 0) {
    
    $proxyv = 0;
    
    if ($row['protection'] == 1) {
        
        if (psec_getcache($ip, $cache_file) == 'PSEC_NoCache') {
            $key = $row['api1'];
            
            $ch  = curl_init();
            $url = 'http://v2.api.iphub.info/ip/' . $ip . '';
            curl_setopt_array($ch, [
				CURLOPT_URL => $url,
				CURLOPT_CONNECTTIMEOUT => 30,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
            ]);
			$choutput = curl_exec($ch);
            @$block   = json_decode($choutput)->block;
            curl_close($ch);
			
			// Grabs API Response and Caches
			file_put_contents($cache_file, $choutput);
        } else {
            @$block = json_decode(psec_getcache($ip, $cache_file))->block;
        }
        
        if ($block == 1) {
            $proxyv = 1;
        }
        
    } else if ($row['protection'] == 2) {
        
        if (psec_getcache($ip, $cache_file) == 'PSEC_NoCache') {
            $key = $row['api2'];
            
            $ch           = curl_init('http://proxycheck.io/v2/' . $ip . '?key=' . $key . '&vpn=1');
            $curl_options = array(
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_RETURNTRANSFER => true
            );
            curl_setopt_array($ch, $curl_options);
            $response = curl_exec($ch);
            curl_close($ch);

            $jsonc = json_decode($response);
			
			// Grabs API Response and Caches
			file_put_contents($cache_file, $response);
        } else {
            $jsonc = json_decode(psec_getcache($ip, $cache_file));
        }
        
        if (isset($jsonc->$ip->proxy) && $jsonc->$ip->proxy == "yes") {
            $proxyv = 1;
        }
        
    } else if ($row['protection'] == 3) {
        
        if (psec_getcache($ip, $cache_file) == 'PSEC_NoCache') {
            $key = $row['api3'];
            
            $headers = [
				'X-Key: '.$key,
            ];
            $ch = curl_init("http://www.iphunter.info:8082/v1/ip/" . $ip);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
			$choutput    = curl_exec($ch);
            $output      = json_decode($choutput, 1);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($http_status == 200) {
                if ($output['data']['block'] == 1) {
                    $proxyv = 1;
                }
				
				// Grabs API Response and Caches
				file_put_contents($cache_file, $choutput);
            }
        } else {
            $output = json_decode(psec_getcache($ip, $cache_file), 1);
            
            if ($output['data']['block'] == 1) {
                $proxyv = 1;
            }
        }
        
    } else if ($row['protection'] == 4) {
        
        if (psec_getcache($ip, $cache_file) == 'PSEC_NoCache') {
            
            $url = 'http://blackbox.ipinfo.app/lookup/' . $ip;
			$ch  = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
			$proxyresponse = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
			curl_close($ch);
            
            if ($proxyresponse == 'Y') {
                $proxyv = 1;
				
			}
			
			// Grabs API Response and Caches
			file_put_contents($cache_file, $proxyresponse);
        } else {
            $proxyresponse = psec_getcache($ip, $cache_file);
            
            if ($proxyresponse == 'Y') {
                $proxyv = 1;
            }
        }
        
    }
    
    if ($proxyv == 1) {
        
        $type = "Proxy";
        
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
            psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type, $srow['email']);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '?element=api' . $row['protection'] . '" />';
        exit;
    }
}

//Method 2
if ($row['protection2'] == 1) {
    $proxy_headers = array(
        'HTTP_VIA',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_FORWARDED_HOST',
        'HTTP_FORWARDED',
        'HTTP_FORWARDED_FOR_IP',
        'HTTP_FORWARDED_PROTO',
        'HTTP_PROXY_CONNECTION'
    );
    foreach ($proxy_headers as $x) {
        if (isset($_SERVER[$x])) {
            
            $type = "Proxy";
            
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
                psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type, $srow['email']);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '?element=' . $x . '" />';
            exit;
        }
    }
}
?>