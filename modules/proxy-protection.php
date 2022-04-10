<?php
//Proxy Protection
$cache_file = __DIR__ . "/cache/proxy/". str_replace(":", "-", $ip) .".json";

//Method 1
if ($settings['proxy_protection'] > 0) {
    
    $proxyv = 0;
    
    if ($settings['proxy_protection'] == 1) {
        
        if (psec_getcache($cache_file) == 'PSEC_NoCache') {
            $key = $settings['proxy_api1'];
            
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
            @$block = json_decode(psec_getcache($cache_file))->block;
        }
        
        if ($block == 1) {
            $proxyv = 1;
        }
        
    } else if ($settings['proxy_protection'] == 2) {
        
        if (psec_getcache($cache_file) == 'PSEC_NoCache') {
            $key = $settings['proxy_api2'];
            
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
            $jsonc = json_decode(psec_getcache($cache_file));
        }
        
        if (isset($jsonc->$ip->proxy) && $jsonc->$ip->proxy == "yes") {
            $proxyv = 1;
        }
        
    } else if ($settings['proxy_protection'] == 3) {
        
        if (psec_getcache($cache_file) == 'PSEC_NoCache') {
            $key = $settings['proxy_api3'];
            
            $headers = [
				'X-Key: '.$key,
            ];
            $ch = curl_init("https://www.iphunter.info:8082/v1/ip/" . $ip);
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
            $output = json_decode(psec_getcache($cache_file), 1);
            
            if ($output['data']['block'] == 1) {
                $proxyv = 1;
            }
        }
        
    } else if ($settings['proxy_protection'] == 4) {
        
        if (psec_getcache($cache_file) == 'PSEC_NoCache') {
            
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
			$httpCode      = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
			curl_close($ch);
            
            if ($proxyresponse == 'Y') {
                $proxyv = 1;
				
			}
			
			// Grabs API Response and Caches
			file_put_contents($cache_file, $proxyresponse);
        } else {
            $proxyresponse = psec_getcache($cache_file);
            
            if ($proxyresponse == 'Y') {
                $proxyv = 1;
            }
        }
        
    }
    
    if ($proxyv == 1) {
        
        $type = "Proxy";
        
        //Logging
        if ($settings['proxy_logging'] == 1) {
            psec_logging($mysqli, $type);
        }
        
        //E-Mail Notification
        if ($settings['mail_notifications'] == 1 && $settings['proxy_mail'] == 1) {
            psec_mail($mysqli, $type);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $settings['proxy_redirect'] . '?element=api' . $settings['proxy_protection'] . '" />';
        exit;
    }
}

//Method 2
if ($settings['proxy_protection2'] == 1) {
    $proxy_headers = array(
        'HTTP_VIA',
        'VIA',
        'Proxy-Connection',
        'HTTP_X_FORWARDED_FOR',  
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'HTTP_FORWARDED_FOR_IP',
        'X-PROXY-ID',
        'MT-PROXY-ID',
        'X-TINYPROXY',
        'X_FORWARDED_FOR',
        'FORWARDED_FOR',
        'X_FORWARDED',
        'FORWARDED',
        'CLIENT-IP',
        'CLIENT_IP',
        'PROXY-AGENT',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION'
    );
    foreach ($proxy_headers as $x) {
        if (isset($_SERVER[$x])) {
            
            $type = "Proxy";
            
            //Logging
            if ($settings['proxy_logging'] == 1) {
                psec_logging($mysqli, $type);
            }
            
            //E-Mail Notification
            if ($settings['mail_notifications'] == 1 && $settings['proxy_mail'] == 1) {
                psec_mail($mysqli, $type);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $settings['proxy_redirect'] . '?element=' . $x . '" />';
            exit;
        }
    }
}
?>