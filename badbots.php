<?php
require "core.php";
head();

if (isset($_POST['save2'])) {

    if (isset($_POST['protection'])) {
        $settings['badbot_protection'] = 1;
    } else {
        $settings['badbot_protection'] = 0;
    }
    
    if (isset($_POST['protection2'])) {
        $settings['badbot_protection2'] = 1;
    } else {
        $settings['badbot_protection2'] = 0;
    }
    
    if (isset($_POST['protection3'])) {
        $settings['badbot_protection3'] = 1;
    } else {
        $settings['badbot_protection3'] = 0;
    }

	file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
}

if (isset($_POST['save'])) {

    if (isset($_POST['logging'])) {
        $settings['badbot_logging'] = 1;
    } else {
        $settings['badbot_logging'] = 0;
    }
    
    if (isset($_POST['autoban'])) {
        $settings['badbot_autoban'] = 1;
    } else {
        $settings['badbot_autoban'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['badbot_mail'] = 1;
    } else {
        $settings['badbot_mail'] = 0;
    }

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
if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
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
							<h3 class="card-title">Bad Bots - Protection Module</h3>
						</div>
						<div class="card-body">
<?php
if ($settings['badbot_protection'] == 1 OR $settings['badbot_protection2'] == 1 OR $settings['badbot_protection3'] == 1) {
    echo '
        <h1 class="pm_enabled"><i class="fas fa-check-circle"></i> Enabled</h1>
        <p>The website is protected from <strong>Bad Bots</strong></p>
';
} else {
    echo '
        <h1 class="pm_disabled"><i class="fas fa-times-circle"></i> Disabled</h1>
        <p>The website is not protected from <strong>Bad Bots</strong></p>
';
}
?>
                        </div>
                    </div>
                    
<form class="form-horizontal form-bordered" action="" method="post">
                        <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-shield-alt"></i> Protection Options</h3>
							</div>
							<div class="card-body">
                        	    <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Bad Bots</h5><hr />
                                        Detects the <b>bad bots</b> and blocks their access to the website
                                        <br /><br />
                                        
											<input type="checkbox" name="protection" class="psec-switch" <?php
if ($settings['badbot_protection'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Fake Bots</h5><hr />
                                        Detects the <b>fake bots</b> and blocks their access to the website
                                        <br /><br />
                                        
											<input type="checkbox" name="protection2" class="psec-switch" <?php
if ($settings['badbot_protection2'] == 1) {
    echo 'checked="checked"';
}
?> />
                                        </center>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-body bg-light">
                                        <center>
                                        <h5>Anonymous Bots</h5><hr />
                                        Detects the <b>anonymous bots</b> and blocks their access to the website<br />
                                        <br /><br />
                                        
											<input type="checkbox" name="protection3" class="psec-switch" <?php
if ($settings['badbot_protection3'] == 1) {
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
								<h3 class="card-title"><i class="fas fa-info-circle"></i> What is Bad Bot</h3>
							</div>
							<div class="card-body">
                                <strong>Bad</strong>, <strong>Fake</strong> and <strong>Anonymous Bots</strong> are bots that consume bandwidth, slow down your server, steal your content and look for vulnerability to compromise your server.
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
if ($settings['badbot_logging'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Logs the detected threats</span>
										</li>
										<li class="list-group-item">
											<p>AutoBan</p>
												<input type="checkbox" name="autoban" class="psec-switch" <?php
if ($settings['badbot_autoban'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Automatically bans the detected threats</span>
										</li>
                                        <li class="list-group-item">
											<p>Mail Notifications</p>
												<input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['badbot_mail'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Receive email notifications when threat of this type is detected</span>
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