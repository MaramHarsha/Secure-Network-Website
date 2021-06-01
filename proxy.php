<?php
require_once "core.php";
head();

if (isset($_GET['api'])) {
    
    $apid = (int) $_GET['api'];
    
    if ($apid == 0 || $apid == 1 || $apid == 2 || $apid == 3 || $apid == 4) {
        
        $table = $prefix . 'proxy-settings';
        $query = $mysqli->query("UPDATE `$table` SET protection='$apid' WHERE id=1");
        
		$files = glob('modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
    }
}

if (isset($_POST['save2'])) {
    $table = $prefix . 'proxy-settings';
    
    $queryas = $mysqli->query("SELECT * FROM `$table`");
    $rowas   = mysqli_fetch_array($queryas);
    $apiks   = 'api' . $rowas['protection'];
    
    if (isset($_POST['protection2'])) {
        $protection2 = 1;
    } else {
        $protection2 = 0;
    }
    
    $query = $mysqli->query("UPDATE `$table` SET protection2='$protection2' WHERE id=1");

    if ($rowas['protection'] > 0) {
		if ($rowas['protection'] != 4) {
			$api_key = $_POST['apikey'];
			$query = $mysqli->query("UPDATE `$table` SET $apiks='$api_key' WHERE id=1");
		}
		
		$files = glob('modules/cache/proxy/*'); // Get all cache file names
		foreach($files as $file){ // Iterate cache files
			if(is_file($file)) {
				unlink($file); // Delete cache file
			}
		}
	}
}

if (isset($_POST['save'])) {
    $table = $prefix . 'proxy-settings';
    
    if (isset($_POST['logging'])) {
        $logging = 1;
    } else {
        $logging = 0;
    }
    
    if (isset($_POST['autoban'])) {
        $autoban = 1;
    } else {
        $autoban = 0;
    }
    
    if (isset($_POST['mail'])) {
        $mail = 1;
    } else {
        $mail = 0;
    }
    
    $redirect = $_POST['redirect'];
    
    $query = $mysqli->query("UPDATE `$table` SET logging='$logging', autoban='$autoban', mail='$mail', redirect='$redirect' WHERE id=1");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-code"></i> Protection Module</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Protection Module</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

                <div class="row">
				<div class="col-md-8">
                    	    
<?php
$table = $prefix . 'proxy-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = mysqli_fetch_array($query);
if ($row['protection'] > 0 OR $row['protection2'] == 1) {
    echo '
              <div class="card card-solid card-success">
';
} else {
    echo '
              <div class="card card-solid card-danger">
';
}
?>
						<div class="card-header">
							<h3 class="card-title">Proxy - Protection Module</h3>
						</div>
						<div class="card-body">
<?php
if ($row['protection'] > 0 OR $row['protection2'] == 1) {
    echo '
        <h1 style="color: #47A447;"><i class="fas fa-check-circle"></i> Enabled</h1>
        <p>The website is protected from <strong>Proxies</strong></p>
';
} else {
    echo '
        <h1 style="color: #d2322d;"><i class="fas fa-times-circle"></i> Disabled</h1>
        <p>The website is not protected from <strong>Proxies</strong></p>
';
}
?>
                        </div>
                    </div>
                    
                        <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-shield-alt"></i> Proxy Detection Methods</h3>
							</div>
							<div class="card-body">
							<form class="form-horizontal form-bordered" action="" method="post">
                        	    <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-body bg-light">
                                        <div class="row">
										<div class="col-md-6">
                                        <h5>Detection Method #1</h5>
										</div>
										<div class="col-md-6">
										<div class="dropdown">
										  <button class="btn btn-<?php
if ($row['protection'] == 0) {
    echo 'danger';
} else {
    echo 'success';
}
?> dropdown-toggle float-right" style="width: 100%;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Proxy Detection API</button>
										  <div class="dropdown-menu" style="width: 100%;">
										    <a class="dropdown-item <?php
if ($row['protection'] == 0) {
    echo 'active';
}
?>" href="?api=0">Disabled</a>
											<div class="dropdown-divider"></div>
										    <a class="dropdown-item <?php
if ($row['protection'] == 1) {
    echo 'active';
}
?>" href="?api=1">IPHub</a>
										    <a class="dropdown-item <?php
if ($row['protection'] == 2) {
    echo 'active';
}
?>" href="?api=2">ProxyCheck</a>
											<a class="dropdown-item <?php
if ($row['protection'] == 3) {
    echo 'active';
}
?>" href="?api=3">IPHunter</a>
											<a class="dropdown-item <?php
if ($row['protection'] == 4) {
    echo 'active';
}
?>" href="?api=4">BlackBox</a>
										  </div>
										</div>
									    </div>
										</div>
										<hr />
                                        Connects with Proxy Detection API and verifies if the visitor is using a Proxy, VPN or TOR
                                        <br /><br />
<?php
if ($row['protection'] > 0 && $row['protection'] != 4) {
    
    $apik = 'api' . $row['protection'];
    $key  = $row[$apik];
    
    $proxy_check = 0;
    
    if ($row['protection'] == 1) {
        //Invalid API Key ==> Offline
        $ch  = curl_init();
        $url = "http://v2.api.iphub.info/ip/8.8.8.8";
        curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [ "X-Key: {$key}" ]
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            $proxy_check = 1;
        }
    } else if ($row['protection'] == 2) {
        
        $proxy_check = 1;
        
    } else if ($row['protection'] == 3) {
        //Invalid API Key ==> Offline
        $headers = [
			'X-Key: '.$key.'',
        ];
        $ch = curl_init("http://www.iphunter.info:8082/v1/ip/8.8.8.8");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            $proxy_check = 1;
        }
        
    }
    
    if ($proxy_check == 0) {
        echo '<div class="callout callout-warning" role="callout">Invalid API Key, Limit Exceeded or API is Offline</div>';
    }
    
    if ($row[$apik] == NULL OR $proxy_check == 0) {
        if ($row['protection'] == 1) {
            $apik_url = 'https://iphub.info/pricing';
        } else if ($row['protection'] == 2) {
            $apik_url = 'https://proxycheck.io/pricing';
        } else if ($row['protection'] == 3) {
            $apik_url = 'https://www.iphunter.info/prices';
        }
?>
                                        <a href="<?php
        echo $apik_url;
?>" class="btn btn-info btn-block" role="button" target="_blank"><i class="fas fa-key"></i> Get API Key</a><br />
<?php
    }
?>
											
											<p>API Key</p>
											<input name="apikey" class="form-control" type="text" value="<?php
    echo $row[$apik];
?>" required>
<?php
}
if ($row['protection'] == 4) {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$useragent = 'Mozilla/5.0';
	}
	
	$url = 'http://blackbox.ipinfo.app/lookup/8.8.8.8';
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
	
	if ($httpCode >= 200 && $httpCode < 300) {
        $proxy_check = 1;
		//echo '<div class="callout callout-success" role="callout"><b>BlackBox Proxy Detection API</b> is active</div>';
    } else {
		echo '<div class="callout callout-warning" role="callout">Limit Exceeded or API is Offline</div>';
	}
}
?>
                                        </div>
                                    </div>
									</div>
									<div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Detection Method #2</h5><hr />
                                        Checks the visitor's HTTP Headers for Proxy Elements
                                        <br /><br />
                                        
											<input type="checkbox" name="protection2" class="psec-switch" <?php
if ($row['protection2'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    
									</div>
                                    <center><button class="btn btn-flat btn-md btn-block btn-primary mar-top" name="save2" type="submit"><i class="fas fa-save"></i> Save</button></center>
                                </div>
                        	</div>
                    </form>
                    
                </div>
                    
                <div class="col-md-4">
                     <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-info-circle"></i> What is Proxy</h3>
							</div>
							<div class="card-body">
                                <strong>Proxy</strong> or <strong>Proxy Server</strong> is basically another computer which serves as a hub through which internet requests are processed. By connecting through one of these servers, your computer sends your requests to the proxy server which then processes your request and returns what you were wanting.
                        	</div>
                     </div>
                     <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-cogs"></i> Module Settings</h3>
							</div>
							<div class="card-body">
									<ul class="list-group">
<form class="form-horizontal form-bordered" action="" method="post">
										<li class="list-group-item">
											<p>Logging</p>
												<input type="checkbox" name="logging" class="psec-switch" <?php
if ($row['logging'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Logs the detected threats</span>
										</li>
										<li class="list-group-item">
											<p>AutoBan</p>
												<input type="checkbox" name="autoban" class="psec-switch" <?php
if ($row['autoban'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Automatically bans the detected threats</span>
										</li>
                                        <li class="list-group-item">
											<p>Mail Notifications</p>
												<input type="checkbox" name="mail" class="psec-switch" <?php
if ($row['mail'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Receive email notifications when threat of this type is detected</span>
										</li>
                                        <li class="list-group-item">
											<p>Redirect URL</p>
											<input name="redirect" class="form-control" type="text" value="<?php
echo $row['redirect'];
?>" required>
										</li>
									</ul>
                        	</div>
                            <div class="card-footer">
                                <button class="btn btn-flat btn-block btn-primary mar-top" name="save" type="submit"><i class="fas fa-save"></i> Save</button>
                            </div>
</form>
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
<script>
var elems = Array.prototype.slice.call(document.querySelectorAll('.psec-switch'));

elems.forEach(function(html) {
  var switchery = new Switchery(html, {secondaryColor: 'red'});
});
</script>
<?php
footer();
?>