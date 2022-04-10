<?php
require "core.php";
head();

if (isset($_POST['save'])) {
    
    $settings['email'] = $_POST['email'];
    
    if (isset($_POST['project_security'])) {
        $settings['project_security'] = 1;
    } else {
        $settings['project_security'] = 0;
    }
    
    if (isset($_POST['mail_notifications'])) {
        $settings['mail_notifications'] = 1;
    } else {
        $settings['mail_notifications'] = 0;
    }
    
    if (isset($_POST['test_integration'])) {
        $settings['test_integration'] = 1;
    } else {
        $settings['test_integration'] = 0;
    }
	
	if (isset($_POST['dark_mode'])) {
        $settings['dark_mode'] = 1;
    } else {
        $settings['dark_mode'] = 0;
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
        		      <h1 class="m-0 "><i class="fas fa-cogs"></i> Settings</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Settings</li>
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
                    
				<div class="col-md-12">
<form class="form-horizontal" method="post">
				    <div class="col-md-12 card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-cog"></i> Settings</h3>
						</div>
						<div class="card-body mx-auto">
							<div class="form-group row">
								<label class="control-label" for="inputDefault">E-Mail Address:</label>
												
								 <div class="input-group col-sm-10">
                					<div class="input-group-prepend">
                						<span class="input-group-text"><i class="fa fa-envelope"></i></span>
                					</div>
									<input type="email" class="form-control" name="email" value="<?php
echo $settings['email'];
?>" required>
                				</div>
                                <p><br />The E-Mail Address is used for receiving <b>Mail Notifications</b> and for the <b>Contact Button (Warning Pages)</b>.</p>
							</div><hr />
                            <div class="form-group">
								<label class="control-label">Project SECURITY</label><br />
								<input type="checkbox" name="project_security" class="psec-switch" <?php
if ($settings['project_security'] == 1) {
    echo 'checked';
}
?> />
								<br /> With this option you can <strong>Enable</strong> or <strong>Disable</strong> the whole script.<br />
                            </div><hr /><br />
                            <div class="form-group">
								<label class="control-label">Mail Notifications</label><br />
                                <input type="checkbox" name="mail_notifications" class="psec-switch" <?php
if ($settings['mail_notifications'] == 1) {
    echo 'checked';
}
?> />
									</br> If this option is <strong>Enabled</strong> you will receive notifications on your E-Mail Address.<br />
                            </div><hr /><br />
                            <div class="form-group">
								<label class="control-label">Test Integration</label><br />
                                <input type="checkbox" name="test_integration" class="psec-switch" <?php
if ($settings['test_integration'] == 1) {
    echo 'checked';
}
?> />
									</br> Check if your website is correctly integrated with Project SECURITY.<br />
                                    Message will be displayed on your website if this option is <strong>Enabled</strong> and if <strong>Integration is correct</strong>.<br />
                            </div><hr /><br />
							<div class="form-group">
                                <label class="control-label">Dark Mode Theme</label><br />
								<input type="checkbox" name="dark_mode" class="psec-switch" <?php
if ($settings['dark_mode'] == 1) {
    echo 'checked';
}
?> />
								<br /> Dark mode theme can reduce eyestrain and can save battery on devices with OLED screens.
							</div>
						</div>
                        <div class="card-footer">
							<button class="btn btn-block btn-flat btn-primary" name="save" type="submit"><i class="fas fa-save"></i> Save</button>
						</div>
                     </div>
					 </div>
</form>
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