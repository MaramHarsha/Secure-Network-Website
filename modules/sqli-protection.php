<?php
//SQLi Protection
if ($settings['sqli_protection'] == 1) {
    
    //XSS Protection - Block infected requests
    //@header("X-XSS-Protection: 1; mode=block");
    
    if ($settings['sqli_protection2'] == 1) {
        //XSS Protection - Sanitize infected requests
        @header("X-XSS-Protection: 1");
    }
    
    if ($settings['sqli_protection3'] == 1) {
        //Clickjacking Protection
        @header("X-Frame-Options: sameorigin");
    }
    
    if ($settings['sqli_protection4'] == 1) {
        //Prevents attacks based on MIME-type mismatch
        @header("X-Content-Type-Options: nosniff");
    }
    
    if ($settings['sqli_protection5'] == 1) {
        //Force secure connection
        @header("Strict-Transport-Security: max-age=15552000; preload");
    }
    
    if ($settings['sqli_protection6'] == 1) {
        //Hide PHP Version
        @header('X-Powered-By: Project SECURITY');
    }
    
    if ($settings['sqli_protection7'] == 1) {
        //Sanitization of all fields and requests
        $_GET     = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        $_POST    = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    //Data Sanitization
    if ($settings['sqli_protection8'] == 1) {
        
        if (!function_exists('cleanInput')) {
            function cleanInput($input)
            {
                $search = array(
                    '@<script[^>]*?>.*?</script>@si', // Strip out javascript
                    '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
                    '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
                    '@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments
                );
                
                $output = preg_replace($search, '', $input);
                return $output;
            }
        }
        
        if (!function_exists('sanitize')) {
            function sanitize($input)
            {
                if (is_array($input)) {
					$output = [];
                    foreach ($input as $var => $val) {
                        $output[$var] = sanitize($val);
                    }
                } else {
					$output = '';
                    $input  = str_replace('"', "", $input);
                    $input  = str_replace("'", "", $input);
                    $input  = cleanInput($input);
                    $output = htmlentities($input, ENT_QUOTES);
                }
                return @$output;
            }
        }
        
        $_POST    = sanitize($_POST);
        $_GET     = sanitize($_GET);
        $_REQUEST = sanitize($_REQUEST);
        $_COOKIE  = sanitize($_COOKIE);
        if (isset($_SESSION)) {
            $_SESSION = sanitize($_SESSION);
        }
    }
    
    $query_string = $_SERVER['QUERY_STRING'];
    
    //Patterns, used to detect Malicous Request (SQL Injection)
    $patterns = array(
        "**/",
        "/**",
        "0x3a",
        "/*",
        "*/",
        "*",
        ";",
        "||",
        "' #",
        "or 1=1",
		"or%201=1",
        "'1'='1",
        "S@BUN",
        "`",
        "'",
        '"',
        "<",
        ">",
        "1,1",
        "1=1",
        "sleep(",
        "<?",
        "<?php",
        "?>",
        "../",
        "%0A",
        "%0D",
        "%3C",
        "%3E",
        "%00",
        "%2e%2e",
        "input_file",
        "path=.",
        "mod=.",
        "eval\(",
        "javascript:",
        "base64_",
        "boot.ini",
        "etc/passwd",
        "self/environ",
        "echo.*kae",
        "=%27$"
    );
    foreach ($patterns as $pattern) {
        if (strpos(strtolower($query_string), strtolower($pattern)) !== false) {
            $querya = strip_tags(addslashes($query_string));
            $type   = "SQLi";

            //Logging
            if ($settings['sqli_logging'] == 1) {
                psec_logging($mysqli, $type);
            }
            
            //AutoBan
            if ($settings['sqli_autoban'] == 1) {
                psec_autoban($mysqli, $type);
            }
            
            //E-Mail Notification
            if ($settings['mail_notifications'] == 1 && $settings['sqli_mail'] == 1) {
                psec_mail($mysqli, $type);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $settings['sqli_redirect'] . '" />';
            exit;
        }
    }
}
?>