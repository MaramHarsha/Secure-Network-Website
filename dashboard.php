<?php
require "core.php";
head();

// Delete outdated cache files
$now   = time();

$files = glob("modules/cache/ip-details" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
$files = glob("modules/cache/live-traffic" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
$files = glob("modules/cache/proxy" . "/*");
foreach ($files as $file) {
    if (is_file($file)) {
		if (($now - filemtime($file)) >= (1 * 24 * 60 * 60)) { // 1 day
			unlink($file);
		}
    }
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-home"></i> Dashboard</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Dashboard</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">
                    
<h4 class="card-title">Today's Stats</h4><br />
<?php
$date   = date('d F Y');

$query  = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='SQLi'");
$count  = mysqli_num_rows($query);
$query2 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$count2 = mysqli_num_rows($query2);
$query3 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='Proxy'");
$count3 = mysqli_num_rows($query3);
$query4 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `date`='$date' AND `type`='Spammer'");
$count4 = mysqli_num_rows($query4);
?>
                <div class="row">
                
					    <div class="col-sm-6 col-lg-3">
                            <div class="small-box bg-info">
                               <div class="inner">
                                   <h3><?php
echo $count;
?></h3>
                                   <p>SQLi Attacks</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-code"></i>
                               </div>
                               <a href="sqli-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-danger">
                               <div class="inner">
                                   <h3><?php
echo $count2;
?></h3>
                                   <p>Bad Bots</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-robot"></i>
                               </div>
                               <a href="badbot-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-success">
                               <div class="inner">
                                   <h3><?php
echo $count3;
?></h3>
                                   <p>Proxies</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-globe"></i>
                               </div>
                               <a href="proxy-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-warning">
                               <div class="inner">
                                   <h3><?php
echo $count4;
?></h3>
                                   <p>Spammers</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-keyboard"></i>
                               </div>
                               <a href="spammer-logs.php" class="small-box-footer">View Logs <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
					    </div>
					</div>
                    
                <br /><h4 class="card-title">Overall Statistics</h4><br />
                    
                <div class="row">          
					    <div class="col-lg-7">
					        <div id="panel-network" class="card card-secondary card-outline">
					            <div class="card-header">
					                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Threat Statistics</h3>
					            </div>
					            <div class="card-body">
                                    <canvas id="log-stats"></canvas>
                                </div>
                            </div>
					
					    </div>
<?php
$querym  = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='SQLi'");
$countm  = mysqli_num_rows($querym);
$querym2 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Bad Bot' or `type`='Fake Bot' or type='Missing User-Agent header' or type='Missing header Accept' or type='Invalid IP Address header'");
$countm2 = mysqli_num_rows($querym2);
$querym3 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Proxy'");
$countm3 = mysqli_num_rows($querym3);
$querym4 = $mysqli->query("SELECT * FROM `psec_logs` WHERE `type`='Spammer'");
$countm4 = mysqli_num_rows($querym4);
?>
                        <div class="col-lg-5">
					        <div class="row">
					            <div class="col-sm-6 col-lg-6"> 
					         <div class="card card-primary card-outline">
								<div class="card-body text-center">
									<p class="text-uppercase mar-btm text-lg">SQL Injections</p>
									<i class="fas fa-code fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm;
?></p>
								</div>
							 </div>
					            </div>
					            <div class="col-sm-6 col-lg-6">
					         <div class="card card-danger card-outline">
								<div class="card-body text-center">
									<p class="text-uppercase mar-btm text-lg">Bad Bots</p>
									<i class="fas fa-robot fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm2;
?></p>
								</div>
							 </div>
					            </div>
					        </div>
					        <div class="row">
					            <div class="col-sm-6 col-lg-6">
					        <div class="card card-success card-outline">
								<div class="card-body text-center">
									<p class="text-uppercase mar-btm text-lg">Proxies</p>
									<i class="fas fa-globe fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm3;
?></p>
								</div>
							 </div>
					            </div>
					            <div class="col-sm-6 col-lg-6">
					        <div class="card card-warning card-outline">
								<div class="card-body text-center">
									<p class="text-uppercase mar-btm text-lg">Spammers</p>
									<i class="fas fa-keyboard fa-2x"></i>
									<hr />
									<p class="h3 text-thin"><?php
echo $countm4;
?></p>
								</div>
							 </div>
					            </div>
					        </div>
					
					    </div>
					</div>
                    
                    <div class="card card-primary card-outline">
						<div class="card-header">
								<h3 class="card-title"><i class="fas fa-stream"></i> Modules Status</h3>
						</div>
						<div class="card-body">
<div class="row">
					<div class="col-md-4">
                        <div class="card card-body bg-light">
						    <center>
							<h5><i class="fas fa-shield-alt"></i> &nbsp;Protection Modules</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-code"></i> SQLi</strong><br />Protection<hr />
<?php
if ($settings['sqli_protection'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>							
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-robot"></i> Bad Bots</strong><br />Protection<hr />
<?php
if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-globe"></i> Proxy</strong><br />Protection<br /><hr />
<?php
if ($settings['proxy_protection'] == 1 OR $settings['proxy_protection2'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-keyboard"></i> Spam</strong><br />Protection<br /><hr />
<?php
$querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-4">
                        <div class="card card-body bg-light">
						    <center>
							<h5><i class="fas fa-list-ul"></i> &nbsp;Logging Settings</h5>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-code"></i> SQLi</strong><br />Logging<hr />
<?php
if ($settings['sqli_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>							
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-robot"></i> Bad Bots</strong><br />Logging<hr />
<?php
if ($settings['badbot_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-globe"></i> Proxy</strong><br />Logging <br /><hr />
<?php
if ($settings['proxy_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					<div class="col-md-2">
                        <div class="card card-body bg-light">
						    <center>
							<strong><i class="fas fa-keyboard"></i> Spam</strong><br />Logging<br /><hr />
<?php
if ($settings['spam_logging'] == 1) {
    echo '
					        <h4><span class="badge badge-success"><i class="fas fa-check"></i> ON</span></h4>
';
} else {
    echo '
                            <h4><span class="badge badge-danger"><i class="fas fa-times"></i> OFF</span></h4>
';
}
?>
                            </center>
						</div>
					</div>
					</div>
						</div>
				   </div>
				   
				   <div class="row">
<?php
$url = 'https://ipapi.co/8.8.8.8/json/';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60');
curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
$ipcontent = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && !isset($ip_data->{'error'})) {
    $gstatus = '<font color="green">Online</font>';
} else {
    $gstatus = '<font color="red">Offline</font>';
}
?>
				        <div class="col-md-6">
						    <div class="info-box">
            			    <span class="info-box-icon bg-dark"><i class="fas fa-globe"></i></span>
            			    <div class="info-box-content">
            			      <span class="info-box-text">GeoIP API Status</span>
            			      <span class="info-box-number"><?php
echo $gstatus;
?></span>
            			    </div>
          			        </div>
						</div>
<?php
$proxy_check = 0;

if ($settings['proxy_protection'] > 0 && $settings['proxy_protection'] != 4) {
    $apik = 'api' . $settings['protection'];
    $key  = $settings['proxy_' . $apik];
}

if ($settings['proxy_protection'] == 1) {
    //Invalid API Key ==> Offline
    $ch  = curl_init();
    $url = "http://v2.api.iphub.info";
    curl_setopt_array($ch, [
		CURLOPT_URL => $url,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_RETURNTRANSFER => true,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else if ($settings['proxy_protection'] == 2) {
    
    $ch = curl_init('http://proxycheck.io/v2/8.8.8.8');
    $curl_options = array(
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else if ($settings['proxy_protection'] == 3) {
    //Invalid API Key ==> Offline
    $headers = [
		'X-Key: '.$key.'',
    ];
    $ch = curl_init("https://www.iphunter.info:8082/v1/ip/8.8.8.8");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }

} else if ($settings['proxy_protection'] == 4) {
	$ch  = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://blackbox.ipinfo.app/lookup/8.8.8.8');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
	curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
	$proxyresponse = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
	curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
    }
    
} else {
	$proxy_check = -1;
}

if ($proxy_check == 1) {
    $pstatus = '<font color="green">Online</font>';
} else if ($proxy_check == 0) {
    $pstatus = '<font color="red">Offline</font>';
} else {
	$pstatus = '<font color="red">Disabled</font>';
}
?>
				        <div class="col-md-6">
						    <div class="info-box">
            			    <span class="info-box-icon bg-dark"><i class="fas fa-cloud"></i></span>
            			    <div class="info-box-content">
            			      <span class="info-box-text">Proxy Detection API Status</span>
            			      <span class="info-box-number"><?php
echo $pstatus;
?></span>
            			    </div>
          			        </div>
						</div>
				   </div>
				   
				   <div class="row">
				        <div class="col-md-4">
						    <div class="card card-primary card-outline">
             			        <div class="card-header with-border">
            			            <h3 class="card-title">Recent Logs</h3>
									<a href="all-logs.php" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-list"></i> View All</a>
             			        </div>
            			        <div class="card-body">
<?php
$query = $mysqli->query("SELECT * FROM `psec_logs` ORDER BY id DESC LIMIT 2");
$count = mysqli_num_rows($query);
if ($count > 0) {
    while ($row = $query->fetch_assoc()) {
        echo '
							<p class="navbar-dark text-white text-center"><i class="fas fa-user pull-left"></i> ' . $row['ip'] . '</p>

							<div class="media">
                            <div class="media-body">

                                    <p><i class="fas fa-file-alt"></i> Threat Type:
';
        if ($row['type'] == 'SQLi') {
            echo '<button class="btn btn-xs btn-primary btn-flat"><i class="fas fa-code"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Bad Bot' || $row['type'] == 'Fake Bot' || $row['type'] == 'Missing User-Agent header' || $row['type'] == 'Missing header Accept' || $row['type'] == 'Invalid IP Address header') {
            echo '<button class="btn btn-xs btn-danger btn-flat"><i class="fas fa-robot"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Proxy') {
            echo '<button class="btn btn-xs btn-success btn-flat"><i class="fas fa-globe"></i> <b>' . $row['type'] . '</b></button>';
        } elseif ($row['type'] == 'Spammer') {
            echo '<button class="btn btn-xs btn-warning btn-flat"><i class="fas fa-keyboard"></i> <b>' . $row['type'] . '</b></button>';
        } else {
            echo '<button class="btn btn-xs btn-success btn-flat"><i class="fas fa-user-secret"></i> <b>Other</b></button>';
        }
        echo '
		                    </p>
							<p><i class="fas fa-calendar"></i> ' . $row['date'] . ' at ' . $row['time'] . '</p>
							
                            </div>
							<p class="ml-3">
                                        
										<a href="log-details.php?id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-primary"><i class="fas fa-tasks"></i> Details</a>
                            			';
        echo '
							            <a href="all-logs.php?delete-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-danger"><i class="fas fa-trash"></i> Delete</a>       

                                    </p>
                            </div>
							<hr />
';
    }
} else {
    echo '<div class="callout callout-info"><p>There are no recent <b>Logs</b></p></div>';
}
?>
            			        </div>
            			    </div>
						</div>
						
						<div class="col-md-4">
						    <div class="card card-primary card-outline">
             			        <div class="card-header with-border">
            			            <h3 class="card-title">Recent IP Bans</h3>
									<a href="bans-ip.php" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-list"></i> View All</a>
             			        </div>
            			        <div class="card-body">
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans` ORDER BY id DESC LIMIT 2");
$count = mysqli_num_rows($query);
if ($count > 0) {
    while ($row = $query->fetch_assoc()) {
        echo '	
							<p class="navbar-dark text-white text-center"><i class="fas fa-user pull-left"></i> ' . $row['ip'] . '</p>
								
							<div class="media">
                            <div class="media-body">
									<p><i class="fas fa-file-alt"></i> ' . $row['reason'] . '</p>
									<p><i class="fas fa-calendar"></i> ' . $row['date'] . ' at ' . $row['time'] . '</p>

                                    <p class="marg_bottom">
                                        <button class="btn btn-xs btn-flat btn-danger"><i class="fas fa-magic"></i> Autobanned: <b>';
        if ($row['autoban'] == 1) {
            echo 'Yes';
        } else {
            echo 'No';
        }
        echo '</b></button>
                                    </p>
                            </div>
							<p class="ml-3">
                                        
										<a href="bans-ip.php?edit-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            			<a href="bans-ip.php?delete-id=' . $row['id'] . '" class="btn btn-sm btn-flat btn-block btn-success"><i class="fas fa-ban"></i> Unban</a>
                                    </p>
                            </div>
							<hr />
';
    }
} else {
    echo '<div class="callout callout-info"><p>There are no recent <b>IP Bans</b></p></div>';
}
?>
            			        </div>
            			    </div>
						</div>
						
				        <div class="col-md-4">
						    <div class="card card-primary card-outline">
             			        <div class="card-header with-border">
            			            <h3 class="card-title">Statistics</h3>
             			        </div>
            			        <div class="card-body">
<table class="table table-bordered table-hover">
                 <thead class="<?php echo $thead; ?>">
				    <tr class="active">
                      <th><i class="fas fa-list"></i> Threat Logs</th>
                      <th>Value</th>
                    </tr>
				</thead>
				<tbody>
<?php
$query = $mysqli->query("SELECT id FROM `psec_logs`");
$count = mysqli_num_rows($query);
?>
                    <tr>
                      <td>Total</td>
                      <td><?php
echo $count;
?></td>
                    </tr>
<?php
$date2  = date("d F Y");
$query2 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `date`='$date2'");
$count2 = mysqli_num_rows($query2);
?>
                    <tr>
                      <td>Today</td>
                      <td><?php
echo $count2;
?></td>
                    </tr>
<?php
$date3  = date("F Y");
$query3 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `date` LIKE '% $date3'");
$count3 = mysqli_num_rows($query3);
?>
					<tr>
                      <td>This month</td>
                      <td><?php
echo $count3;
?></td>
                    </tr>
<?php
$date4  = date("Y");
$query4 = $mysqli->query("SELECT id FROM `psec_logs` WHERE `date` LIKE '% $date4'");
$count4 = mysqli_num_rows($query4);
?>
					<tr>
                      <td>This year</td>
                      <td><?php
echo $count4;
?></td>
                    </tr>
				</tbody>
				<thead class="<?php echo $thead; ?>">
					<tr class="active">
                      <th><i class="fas fa-ban"></i> IP Bans</th>
                      <th>Value</th>
                    </tr>
				</thead>
				<tbody>
<?php
$query5 = $mysqli->query("SELECT id FROM `psec_bans`");
$count5 = mysqli_num_rows($query5);
?>
                    <tr>
                      <td>Total</td>
                      <td><?php
echo $count5;
?></td>
                    </tr>
<?php
$date6  = date("d F Y");
$query6 = $mysqli->query("SELECT id FROM `psec_bans` WHERE `date`='$date6'");
$count6 = mysqli_num_rows($query6);
?>
                    <tr>
                      <td>Today</td>
                      <td><?php
echo $count6;
?></td>
                    </tr>
<?php
$date7  = date("F Y");
$query7 = $mysqli->query("SELECT id FROM `psec_bans` WHERE `date` LIKE '% $date7'");
$count7 = mysqli_num_rows($query7);
?>
					<tr>
                      <td>This month</td>
                      <td><?php
echo $count7;
?></td>
                    </tr>
<?php
$date8  = date("Y");
$query8 = $mysqli->query("SELECT id FROM `psec_bans` WHERE `date` LIKE '% $date8'");
$count8 = mysqli_num_rows($query8);
?>
					<tr>
                      <td>This year</td>
                      <td><?php
echo $count8;
?></td>
                    </tr>
				   </tbody>
                  </table>
            			        </div>
            			    </div>
						</div>
				    </div>
                    
                    <div class="card card-primary card-outline">
						<div class="card-header">
								<h3 class="card-title">Threats by Country</h3>
						</div>
						<div class="card-body">
					        <div class="col-md-12">

								<table id="dt-basic" class="table table-bordered table-hover table-sm">
									<thead class="<?php echo $thead; ?>">
										<tr>
								          <th><i class="fas fa-globe"></i> Country</th>
						                  <th><i class="fas fa-bug"></i> Threats</th>
										</tr>
									</thead>
									<tbody>
<?php
$countries = array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cape Verde",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombi",
    "Comoros",
    "Congo (Brazzaville)",
    "Congo",
    "Costa Rica",
    "Cote d\'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor (Timor Timur)",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia, The",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea, North",
    "Korea, South",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia and Montenegro",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Swaziland",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
);

foreach ($countries as $country) {
    $log_result = $mysqli->query("SELECT * FROM `psec_logs` WHERE `country` LIKE '%$country%'");
    $log_rows   = mysqli_num_rows($log_result);
    $lgrow      = mysqli_fetch_assoc($log_result);
    
    if ($log_rows > 0) {
        echo '<tr>';
        echo '<td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($lgrow['country_code']) . '"/>&nbsp; ' . $country . '</td>';
        echo '<td>' . $log_rows . '</td>';
        echo '</tr>';
    }
}
?>
</tbody>
</table>
							
                            </div>
                        </div>
                    </div>
                    
				</div>
				</div>
				<!--===================================================-->
				<!--End page content-->

			</div>
			<!--===================================================-->
			<!--END CONTENT CONTAINER-->
</div>
<?php
footer();
?>