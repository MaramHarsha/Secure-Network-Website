<?php
require "core.php";
head();

if (isset($_POST['add-database'])) {
    $database   = $_POST['database'];
	
    $queryvalid = $mysqli->query("SELECT * FROM `psec_dnsbl-databases` WHERE `database`='$database' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
    } else {
        $query = $mysqli->query("INSERT INTO `psec_dnsbl-databases` (`database`) VALUES ('$database')");
    }
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_dnsbl-databases` WHERE id='$id'");
}

if (isset($_POST['save'])) {

    if (isset($_POST['protection'])) {
        $settings['spam_protection'] = 1;
    } else {
        $settings['spam_protection'] = 0;
    }
    
    if (isset($_POST['logging'])) {
        $settings['spam_logging'] = 1;
    } else {
        $settings['spam_logging'] = 0;
    }
    
    if (isset($_POST['mail'])) {
        $settings['spam_mail'] = 1;
    } else {
        $settings['spam_mail'] = 0;
    }
    
    $settings['spam_redirect'] = $_POST['redirect'];
    
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
$querysp = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
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
							<h3 class="card-title">Spam - Protection Module</h3>
						</div>
						<div class="card-body">
<?php
if ($settings['spam_protection'] == 1 && mysqli_num_rows($querysp) > 0) {
    echo '
        <h1 class="pm_enabled"><i class="fas fa-check-circle"></i> Enabled</h1>
        <p>The website is protected from <strong>Spammers</strong></p>
';
} else {
    echo '
        <h1 class="pm_disabled"><i class="fas fa-times-circle"></i> Disabled</h1>
        <p>The website is not protected from <strong>Spammers</strong></p>
';
}
?>
                        </div>
                    </div>
                    
                    <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-server"></i> Spam Databases (DNSBL)</h3>
							<button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-plus-circle"></i> Add Spam Database (DNSBL)</button>
						</div>
						<div class="card-body">

<form class="form-horizontal mb-lg" method="POST">
    <div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">Add Spam Database (DNSBL)</h6>
					<button data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label class="control-label"><i class="fas fa-database"></i> Spam Database (DNSBL):</label>
						<input type="text" class="form-control" name="database" required />
					</div>
				</div>
				<div class="modal-footer">
					<input class="btn btn-block btn-flat btn-primary" name="add-database" type="submit" value="Add">
				</div>
			</div>
        </div>
    </div>
</form>

<?php
if (mysqli_num_rows($querysp) > 3) {
    echo '
        <div class="callout callout-warning">
			It is NOT recommended to use more than <b>3 spam databases</b> because performance and accuracy could be affected in negative way.
		</div>';
}
?>

<div class="table-responsive">                
	<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th><i class="fas fa-database"></i> DNSBL Database</th>
											<th><i class="fas fa-cog"></i> Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_dnsbl-databases`");
while ($rowd = $query->fetch_assoc()) {
    echo '
										<tr>
                                            <td>' . $rowd['database'] . '</td>
											<td>
                                            <a href="?delete-id=' . $rowd['id'] . '" class="btn btn-flat btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> Delete</a>
											</td>
										</tr>
';
}
?>
									</tbody>
								</table>
								</div>
                            
                        </div>
                     </div>
                    
                </div>
                    
                <div class="col-md-4">
                     <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-info-circle"></i> What is Spam & DNSBL</h3>
							</div>
							<div class="card-body">
                                <strong>Electronic Spamming</strong> is the use of electronic messaging systems to send unsolicited messages (spam), especially advertising, as card card-body bg-light as sending messages repeatedly on the same site.
                                <br /><br />
                                A <strong>DNS-based Blackhole List (DNSBL)</strong> or <strong>Real-time Blackhole List (RBL)</strong> is a list of IP addresses which are most often used to publish the addresses of computers or networks linked to spamming.<br /><br />
                                    
                                All <strong>Blacklists</strong> can be found here: <strong><a href="https://www.dnsbl.info/dnsbl-list.php" target="_blank">https://www.dnsbl.info/dnsbl-list.php</a></strong>
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
if ($settings['spam_protection'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">If this protection module is enabled all threats of this type will be blocked</span>
										</li>
										<li class="list-group-item">
											<p>Logging</p>
                                            <input type="checkbox" name="logging" class="psec-switch" <?php
if ($settings['spam_logging'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Logs the detected threats</span>
										</li>
                                        <li class="list-group-item">
											<p>Mail Notifications</p>
											<input type="checkbox" name="mail" class="psec-switch" <?php
if ($settings['spam_mail'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">Receive email notifications when threat of this type is detected</span>
										</li>
                                        <li class="list-group-item">
											<p>Redirect URL</p>
											<input name="redirect" class="form-control" type="text" value="<?php
echo $settings['spam_redirect'];
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