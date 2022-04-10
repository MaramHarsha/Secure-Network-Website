<?php
require "core.php";
head();

$sec_username = $_SESSION['sec-username'];
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-user"></i> Account</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Account</li>
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

<form class="form-horizontal" action="" method="post">
                    <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Account</h3>
						</div>
				        <div class="card-body">
                               <div class="form-group">
											<label class="control-label"><i class="fas fa-user"></i> Username: </label>
											<input type="text" name="username" class="form-control" value="<?php
echo $settings['username'];
?>" required>
										</div>
                                        <hr />
                                        <div class="form-group">
											<label class="control-label"><i class="fas fa-key"></i> New Password: </label>
											<input type="text" name="password" class="form-control">
										</div>
                                        <i>Fill this field only if you want to change the password.</i>
                        </div>
                        <div class="card-footer row">
							<div class="col-md-8">
								<button class="btn btn-block btn-flat btn-success" name="edit" type="submit"><i class="fas fa-save"></i> Save</button>
							</div>
							<div class="col-md-4">
								<button type="reset" class="btn btn-block btn-flat btn-default"><i class="fas fa-undo"></i> Reset</button>
							</div>
						</div>
				     </div>
</form>
<?php
if (isset($_POST['edit'])) {
    $username = addslashes($_POST['username']);
    $password = $_POST['password'];

	$settings['username'] = $username;
    $_SESSION['sec-username'] = $username;
	
    if ($password != null) {
        $password             = hash('sha256', $_POST['password']);
		
        $settings['password'] = $password;
    }
	
    file_put_contents('config_settings.php', '<?php $settings = ' . var_export($settings, true) . '; ?>');
	echo '<meta http-equiv="refresh" content="0;url=account.php">';
}
?>
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