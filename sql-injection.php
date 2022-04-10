<?php
require "core.php";
head();

if (isset($_POST['save2'])) {

    if (isset($_POST['protection2'])) {
        $settings['sqli_protection2'] = 1;
    } else {
        $settings['sqli_protection2'] = 0;
    }
    
    if (isset($_POST['protection3'])) {
        $settings['sqli_protection3'] = 1;
    } else {
        $settings['sqli_protection3'] = 0;
    }
    
    if (isset($_POST['protection4'])) {
        $settings['sqli_protection4'] = 1;
    } else {
        $settings['sqli_protection4'] = 0;
    }
    
    if (isset($_POST['protection5'])) {
        $settings['sqli_protection5'] = 1;
    } else {
        $settings['sqli_protection5'] = 0;
    }
    
    if (isset($_POST['protection6'])) {
        $settings['sqli_protection6'] = 1;
    } else {
        $settings['sqli_protection6'] = 0;
    }
    
    if (isset($_POST['protection7'])) {
        $settings['sqli_protection7'] = 1;
    } else {
        $settings['sqli_protection7'] = 0;
    }
	
	if (isset($_POST['protection8'])) {
        $settings['sqli_protection8'] = 1;
    } else {
        $settings['sqli_protection8'] = 0;
    }
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_POST['save'])) {
    
    if (isset($_POST['protection'])) {
        $settings['sqli_protection'] = 1;
    } else {
        $settings['sqli_protection'] = 0;
    }
    
    if (isset($_POST['logging'])) {
        $settings['sqli_logging'] = 1;
    } else {
        $settings['sqli_logging'] = 0;
    }
    
    if (isset($_POST['autoban'])) {
        $settings['sqli_autoban'] = 1;
    } else {
        $settings['sqli_autoban'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['sqli_mail'] = 1;
    } else {
        $settings['sqli_mail'] = 0;
    }
    
    $settings['sqli_redirect'] = $_POST['redirect'];
    
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
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
if ($settings['sqli_protection'] == 1) {
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
							<h3 class="card-title">SQL Injection - Protection Module</h3>
						</div>
						<div class="card-body">
<?php
if ($settings['sqli_protection'] == 1) {
    echo '
        <h1 class="pm_enabled"><i class="fas fa-check-circle"></i> Enabled</h1>
        <p>The website is protected from <strong>SQL Injection Attacks (SQLi)</strong></p>
';
} else {
    echo '
        <h1 class="pm_disabled"><i class="fas fa-times-circle"></i> Disabled</h1>
        <p>The website is not protected from <strong>SQL Injection Attacks (SQLi)</strong></p>
';
}
?>
                        </div>
                    </div>
                    
                    <form class="form-horizontal form-bordered" action="" method="post">
                    
                        <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-shield-alt"></i> Additional Protection Options</h3>
							</div>
							<div class="card-body">
                        	    <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>XSS Protection</h5><hr />
                                        Sanitizes infected requests
                                        <br /><br /><br />
                                        
											<input type="checkbox" name="protection2" class="psec-switch" <?php
if ($settings['sqli_protection2'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Clickjacking Protection</h5><hr />
                                        Detecting and blocking clickjacking attempts
                                        <br /><br />
                                        
											<input type="checkbox" name="protection3" class="psec-switch" <?php
if ($settings['sqli_protection3'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Hide PHP Information</h5><hr />
                                        Hides the PHP version to remote requests
                                        <br /><br />
                                        
											<input type="checkbox" name="protection6" class="psec-switch" <?php
if ($settings['sqli_protection6'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
								</div>
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>MIME Mismatch Attacks Protection</h5><hr />
                                        Prevents attacks based on MIME-type mismatch
                                        <br /><br />
                                        
											<input type="checkbox" name="protection4" class="psec-switch" <?php
if ($settings['sqli_protection4'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Secure Connection</h5><hr />
                                        Forces the website to use secure connection (HTTPS)
                                        <br /><br /><br />
                                        
											<input type="checkbox" name="protection5" class="psec-switch" <?php
if ($settings['sqli_protection5'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
								</div>
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Data Filtering</h5><hr />
                                        Basic Sanitization of all fields, inputs, forms and requests. <i>Lower sensativity, faster performance.</i>
                                        <br /><br />
                                        
											<input type="checkbox" name="protection7" class="psec-switch" <?php
if ($settings['sqli_protection7'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
									<div class="col-md-6">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Requests Sanitization</h5><hr />
                                        Advanced Sanitization of all fields, inputs, forms and requests. <i>Higher sensativity, slower performance.</i>
                                        <br /><br />
                                        
											<input type="checkbox" name="protection8" class="psec-switch" <?php
if ($settings['sqli_protection8'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
								</div>
                                    <center><button class="btn btn-flat btn-md btn-block btn-primary" name="save2" type="submit"><i class="fas fa-save"></i> Save</button></center>
                        	</div>
                        </div>
                    
                    </form>
                </div>
                    
                <div class="col-md-4">
                     <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-info-circle"></i> What is SQL Injection</h3>
							</div>
							<div class="card-body">
                                <strong>SQL Injection</strong> is a technique where malicious users can inject SQL commands into an SQL statement, via web page input. Injected SQL commands can alter SQL statement and compromise the security of a web application.
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
											<p>Protection</p>
														<input type="checkbox" name="protection" class="psec-switch" <?php
if ($settings['sqli_protection'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">If this protection module is enabled all threats of this type will be blocked</span>
										</li>
										<li class="list-group-item">
											<p>Logging</p>
														<input type="checkbox" name="logging" class="psec-switch" <?php
if ($settings['sqli_logging'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Logs the detected threats</span>
										</li>
										<li class="list-group-item">
											<p>AutoBan</p>
														<input type="checkbox" name="autoban" class="psec-switch" <?php
if ($settings['sqli_autoban'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Automatically bans the detected threats</span>
										</li>
                                        <li class="list-group-item">
											<p>Mail Notifications</p>
														<input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['sqli_mail'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">You will receive email notification when threat of this type is detected</span>
										</li>
                                        <li class="list-group-item">
											<p>Redirect URL</p>
											<input name="redirect" class="form-control" type="text" value="<?php
echo $settings['sqli_redirect'];
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
<?php
footer();
?>