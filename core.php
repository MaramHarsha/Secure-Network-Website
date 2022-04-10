<?php
// Project SECURITY version
$psec_version = "4.8";

$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';
    exit();
}

require 'config.php';

if(!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    $uname = $_SESSION['sec-username'];
    if ($uname != $settings['username']) {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    exit;
}

if (basename($_SERVER['SCRIPT_NAME']) != 'warning-pages.php') {
    $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}

if($settings['dark_mode']){
    $thead = 'thead-dark';
} else {
    $thead = 'thead-light';
}

function get_banned($ip)
{
    include 'config.php';

    $query = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
    $count = mysqli_num_rows($query);
    if ($count > 0) {
        return 1;
    } else {
        return 0;
    }
}

function get_bannedid($ip)
{
    include 'config.php';

    $query = $mysqli->query("SELECT * FROM `psec_bans` WHERE ip='$ip' LIMIT 1");
    $row   = mysqli_fetch_array($query);
    return $row['id'];
}

function head()
{
    include 'config.php';
?>
<!DOCTYPE html>
<html class="height_auto">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Antonov_WEB">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta name="theme-color" content="#000000">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <title>Project SECURITY &rsaquo; Admin Panel</title>

    <!--STYLESHEET-->
    <!--=================================================-->
	
    <!--Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0-beta3/css/all.css">
	
	<!--Stylesheet-->
    <link href="assets/css/admin.min.css" rel="stylesheet">
	<link href="assets/css/psec.css" rel="stylesheet">
    
    <!--OverlayScrollbars-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css" rel="stylesheet">
	
    <!--Switchery-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    
    <!--Select2-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">

    <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.0/b-html5-2.1.0/r-2.2.9/datatables.min.css"/>
 
	<!--Flags-->
    <link href="assets/plugins/flags/flags.css" rel="stylesheet">
	
    <!--SCRIPT-->
    <!--=================================================-->

    <!--jQuery-->
    <script
	src="https://code.jquery.com/jquery-3.6.0.min.js"
	integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
	crossorigin="anonymous"></script>
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php' || basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo '
	<!--Chart.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js"></script>';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'log-details.php' || basename($_SERVER['SCRIPT_NAME']) == 'search.php') {
        echo '
	
    <!--Map-->
    <script src="https://openlayers.org/api/OpenLayers.js"></script>';
    }
?>
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed control-sidebar-slide-open <?php
if ($settings['dark_mode'] == 1) {
    echo 'dark-mode';
}
?>" class="height_auto">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark">

        <ul class="nav navbar-nav">
		  <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
          </li>
		</ul>
		  
		  <form class="form-inline ml-3" action="search.php" method="get">
      		  <div class="input-group input-group-sm">
      		    <input type="text" name="ip" class="form-control form-control-navbar" placeholder="IP Lookup" required>
				<div class="input-group-append">
				  <button type="submit" class="btn btn-navbar"><i class="fa fa-search"></i></button>
                </button>
     		    </div>
     		  </div>
   		  </form>
		  
		<ul class="nav navbar-nav ml-auto">
          <li class="nav-item d-none d-md-block">
             <a href="<?php
    echo $settings['site_url'];
?>" class="nav-link" target="_blank" data-toggle="tooltip" title="View Site" data-toggle="tooltip" data-placement="bottom">
			 <i class="fas fa-desktop"></i>
			 </a>
          </li>
          <li class="nav-item">
             <a href="settings.php" class="nav-link" data-toggle="tooltip" title="Settings" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-cogs"></i></a>
          </li>
        </ul>
    </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

	<center><a href="dashboard.php" class="brand-link">
      <span class="brand-text font-weight-light"><i class="fab fa-get-pocket"></i> Project SECURITY</span>
    </a></center>
	
	<div class="sidebar">
	
      <div class="user-panel mt-3 d-flex align-content-center justify-content-center flex-wrap">
          <p class="margin_auto"><a href="account.php" class="btn btn-sm btn-secondary btn-flat"><i class="fas fa-user fa-fw"></i> Account</a>
		  &nbsp;&nbsp;<a href="logout.php" class="btn btn-sm btn-danger btn-flat"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a></p>
      </div>

	  <nav class="mt-2">
	  <ul class="nav nav-pills nav-sidebar nav-legacy flex-column" data-widget="treeview" role="menu">
		<li class="nav-header">NAVIGATION</li>
        
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'active';
    }
?>">
           <a href="dashboard.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'dashboard.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-home"></i>&nbsp; <p>Dashboard</p>
           </a>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'site-info.php') {
        echo 'active';
    }
?>">
           <a href="site-info.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'site-info.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-info-circle"></i>&nbsp; <p>Site Information</p>
           </a>
        </li>
          
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php' OR basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php' OR basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-flag"></i>&nbsp; <p>Whitelist <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php') {
        echo 'active';
    }
?>"><a href="ip-whitelist.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'ip-whitelist.php') {
        echo 'active';
    }
?>"><i class="fas fa-user"></i>&nbsp; <p>IP Whitelist</p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>"><a href="file-whitelist.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'file-whitelist.php') {
        echo 'active';
    }
?>"><i class="far fa-file-alt"></i>&nbsp; <p>File Whitelist</p></a></li>
           </ul>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'warning-pages.php') {
        echo 'active';
    }
?>">
           <a href="warning-pages.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'warning-pages.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-file-alt"></i>&nbsp; <p>Warning Pages</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'users.php') {
        echo 'active';
    }
?>">
           <a href="login-history.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'login-history.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-history"></i>&nbsp; <p>Login History</p>
           </a>
        </li>

        <li class="nav-header">SECURITY</li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sql-injection.php') {
        echo 'active';
    }
?>">
           <a href="sql-injection.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sql-injection.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-code"></i>&nbsp; <p>SQL Injection
<?php
    if ($settings['sqli_protection'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbots.php') {
        echo 'active';
    }
?>">
           <a href="badbots.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbots.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-user-secret"></i>&nbsp; <p>Bad Bots
<?php
    if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo 'active';
    }
?>">
           <a href="proxy.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-globe"></i>&nbsp; <p>Proxy
<?php
    if ($settings['proxy_protection'] > 0 OR $settings['proxy_protection2'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spam.php') {
        echo 'active';
    }
?>">
           <a href="spam.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spam.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-keyboard"></i>&nbsp; <p>Spam
<?php
    $querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
    if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-danger">OFF</span>';
    }
?>     
           </p></a>
        </li>
        
<?php
    $lquery1 = $mysqli->query("SELECT * FROM `psec_logs`");
    $lcount1 = mysqli_num_rows($lquery1);
    $lquery2 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='SQLi'");
    $lcount2 = mysqli_num_rows($lquery2);
    $lquery3 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
    $lcount3 = mysqli_num_rows($lquery3);
    $lquery4 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Proxy'");
    $lcount4 = mysqli_num_rows($lquery4);
    $lquery5 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Spammer'");
    $lcount5 = mysqli_num_rows($lquery5);
?>
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'log-details.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php' OR basename($_SERVER['SCRIPT_NAME']) == 'log-details.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-align-justify"></i>&nbsp; <p>Logs <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php') {
        echo 'active';
    }
?>"><a href="all-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'all-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-align-justify"></i>&nbsp; <p>All Logs <span class="badge right badge-primary"><?php
    echo $lcount1;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php') {
        echo 'active';
    }
?>"><a href="sqli-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'sqli-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-code"></i>&nbsp; <p>SQLi Logs <span class="badge right badge-info"><?php
    echo $lcount2;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php') {
        echo 'active';
    }
?>"><a href="badbot-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'badbot-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-robot"></i>&nbsp; <p>Bad Bot Logs <span class="badge right badge-danger"><?php
    echo $lcount3;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php') {
        echo 'active';
    }
?>"><a href="proxy-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'proxy-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-globe"></i>&nbsp; <p>Proxy Logs <span class="badge right badge-success"><?php
    echo $lcount4;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php') {
        echo 'active';
    }
?>"><a href="spammer-logs.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'spammer-logs.php') {
        echo 'active';
    }
?>"><i class="fas fa-keyboard"></i>&nbsp; <p>Spam Logs <span class="badge right badge-warning"><?php
    echo $lcount5;
?></span></p></a></li>
           </ul>
        </li>
        
<?php
    $bquery1 = $mysqli->query("SELECT * FROM `psec_bans`");
    $bcount1 = mysqli_num_rows($bquery1);

    $bquery2 = $mysqli->query("SELECT * FROM `psec_bans-country`");
    $bcount2 = mysqli_num_rows($bquery2);

    $bquery3 = $mysqli->query("SELECT * FROM `psec_bans-ranges`");
    $bcount3 = mysqli_num_rows($bquery3);

    $bquery4 = $mysqli->query("SELECT * FROM `psec_bans-other`");
    $bcount4 = mysqli_num_rows($bquery4);
?>
        <li class="nav-item has-treeview <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'menu-open';
    }
?>">
           <a href="#" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php' OR basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-ban"></i>&nbsp; <p>Bans <i class="fas fa-angle-right right"></i>
           </p></a>
           <ul class="nav nav-treeview">
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php') {
        echo 'active';
    }
?>"><a href="bans-ip.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-ip.php') {
        echo 'active';
    }
?>"><i class="fas fa-user"></i>&nbsp; <p>IP Bans <span class="badge right badge-secondary"><?php
    echo $bcount1;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo 'active';
    }
?>"><a href="bans-country.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-country.php') {
        echo 'active';
    }
?>"><i class="fas fa-globe"></i>&nbsp; <p>Country Bans <span class="badge right badge-secondary"><?php
    echo $bcount2;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php') {
        echo 'active';
    }
?>"><a href="bans-iprange.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-iprange.php') {
        echo 'active';
    }
?>"><i class="fas fa-grip-horizontal"></i>&nbsp; <p>IP Range Bans <span class="badge right badge-secondary"><?php
    echo $bcount3;
?></span></p></a></li>
               <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>"><a href="bans-other.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bans-other.php') {
        echo 'active';
    }
?>"><i class="fas fa-desktop"></i>&nbsp; <p>Other Bans <span class="badge right badge-secondary"><?php
    echo $bcount4;
?></span></p></a></li>
           </ul>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bad-words.php') {
        echo 'active';
    }
?>">
           <a href="bad-words.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bad-words.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-filter"></i>&nbsp; <p>Bad Words
<?php
    $queryfc = $mysqli->query("SELECT * FROM `psec_bad-words` LIMIT 1");
    $countfc = mysqli_num_rows($queryfc);
    if ($countfc > 0) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-primary">OFF</span>';
    }
?>
           </p></a>
        </li>
		
		<li class="nav-header">SECURITY CHECK</li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'phpfunctions-check.php') {
        echo 'active';
    }
?>">
           <a href="phpfunctions-check.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'phpfunctions-check.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-check"></i>&nbsp; <p>PHP Functions</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'phpconfig-check.php') {
        echo 'active';
    }
?>">
           <a href="phpconfig-check.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'phpconfig-check.php') {
        echo 'active';
    }
?>">
              <i class="fab fa-php"></i>&nbsp; <p>PHP Configuration</p>
           </a>
        </li>
		
		<li class="nav-header">ANALYTICS &nbsp;
<?php
    if ($settings['live_traffic'] == 1) {
        echo '<span class="right badge badge-success">ON</span>';
    } else {
        echo '<span class="right badge badge-primary">OFF</span>';
    }
?></li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic.php') {
        echo 'active';
    }
?>">
           <a href="live-traffic.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'live-traffic.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-globe"></i>&nbsp; <p>Live Traffic</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo 'active';
    }
?>">
           <a href="visit-analytics.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'visit-analytics.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-chart-line"></i>&nbsp; <p>Visit Analytics</p>
           </a>
        </li>
          
        <li class="nav-header">TOOLS</li>

		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'error-monitoring.php') {
        echo 'active';
    }
?>">
           <a href="error-monitoring.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'error-monitoring.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-exclamation-circle"></i>&nbsp; <p>Error Monitoring</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'htaccess-editor.php') {
        echo 'active';
    }
?>">
           <a href="htaccess-editor.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'htaccess-editor.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-columns"></i>&nbsp; <p>.htacces Editor</p>
           </a>
        </li>
		
		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'port-scanner.php') {
        echo 'active';
    }
?>">
           <a href="port-scanner.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'port-scanner.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-search"></i>&nbsp; <p>Port Scanner</p>
           </a>
        </li>

		<li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'blacklist-checker.php') {
        echo 'active';
    }
?>">
           <a href="blacklist-checker.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'blacklist-checker.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-list"></i>&nbsp; <p>IP Blacklist Checker</p>
           </a>
        </li>
          
        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hashing.php') {
        echo 'active';
    }
?>">
           <a href="hashing.php" class="nav-link <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hashing.php') {
        echo 'active';
    }
?>">
              <i class="fas fa-lock"></i>&nbsp; <p>Hashing</p>
           </a>
        </li>
		
		</ul>
          
      </nav>
    </div>

  </aside>
<?php
}

function footer()
{
    include 'config.php';
	
	global $psec_version;
?>
<footer class="main-footer">
    <div class="scroll-btn"><div class="scroll-btn-arrow"></div></div>
    <strong>&copy; <?php
    echo date("Y");
?> <a href="https://codecanyon.net/item/project-security-website-security-antivirus-firewall/15487703?ref=Antonov_WEB" target="_blank">Project SECURITY</a> v<?php echo $psec_version; ?></strong>
	
</footer>

</div>

    <!--JAVASCRIPT-->
    <!--=================================================-->
	
    <!--Bootstrap 4-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    
	<!--AdminLTE-->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
	<script src="assets/js/psec.js"></script>
    
    <!--OverlayScrollbars-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/jquery.overlayScrollbars.min.js"></script>

    <!--Select2-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    
    <!--DataTables-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/vfs_fonts.min.js"></script>

	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.0/b-html5-2.1.0/r-2.2.9/datatables.min.js"></script>

</body>
</html>
<?php
}
?>