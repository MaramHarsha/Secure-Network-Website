<?php
//SQLi Protection
$table = $prefix . 'sqli-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection'] == 1) {
    
    //XSS Protection - Block infected requests
    //@header("X-XSS-Protection: 1; mode=block");
    
    if ($row['protection2'] == 1) {
        //XSS Protection - Sanitize infected requests
        @header("X-XSS-Protection: 1");
    }
    
    if ($row['protection3'] == 1) {
        //Clickjacking Protection
        @header("X-Frame-Options: sameorigin");
    }
    
    if ($row['protection4'] == 1) {
        //Prevents attacks based on MIME-type mismatch
        @header("X-Content-Type-Options: nosniff");
    }
    
    if ($row['protection5'] == 1) {
        //Force secure connection
        @header("Strict-Transport-Security: max-age=15552000; preload");
    }
    
    if ($row['protection6'] == 1) {
        //Hide PHP Version
        @header('X-Powered-By: Project SECURITY');
    }
    
    if ($row['protection7'] == 1) {
        //Sanitization of all fields and requests
        $_GET     = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $_POST    = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //$_REQUEST = (array) $_POST + (array) $_GET + (array) $_REQUEST;
        //$_REQUEST = filter_input_array(INPUT_REQUEST, FILTER_SANITIZE_STRING);
        //$_COOKIE  = filter_input_array(INPUT_COOKIE, FILTER_SANITIZE_STRING);
        //$_SERVER  = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
        //$_ENV     = filter_input_array(INPUT_ENV, FILTER_SANITIZE_STRING);
        /* if (isset($_SESSION)) {
            $_SESSION = filter_input_array(INPUT_SESSION, FILTER_SANITIZE_STRING);
        } */
    }
    
    //Data Sanitization
    if ($row['protection8'] == 1) {
        
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
        "+select+",
        "+union+",
        "union+",
        "+or+",
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
        "%27",
        "<?",
        "<?php",
        "?>",
        "../",
        "loopback",
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
            if ($row['logging'] == 1) {
                psec_logging($mysqli, $prefix, $type);
            }
            
            //AutoBan
            if ($row['autoban'] == 1) {
                psec_autoban($mysqli, $prefix, $type);
            }
            
            //E-Mail Notification
            if ($srow['mail_notifications'] == 1 && $row['mail'] == 1) {
                psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type);
            }
            
            echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '" />';
            exit;
        }
    }
}
?>