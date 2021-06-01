<?php
require_once "core.php";
head();

if (isset($_POST['save'])) {
    $table = $prefix . 'adblocker-settings';
    
    if (isset($_POST['detection'])) {
        $detection = 1;
    } else {
        $detection = 0;
    }
    
    $redirect = $_POST['redirect'];
    
    $query = $mysqli->query("UPDATE `$table` SET detection='$detection', redirect='$redirect' WHERE id=1");
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
$table = $prefix . 'adblocker-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = mysqli_fetch_array($query);
if ($row['detection'] == 1) {
    echo '
              <div class="card card-solid card-success">
';
} else {
    echo '
              <div class="card card-solid card-primary">
';
}
?>
						<div class="card-header">
							<h3 class="card-title">AdBlocker Detection - Protection Module</h3>
						</div>
						<div class="card-body">
<?php
if ($row['detection'] == 1) {
    echo '
        <h1 style="color: #47A447;"><i class="fas fa-check-circle"></i> Enabled</h1>
        <p>Visitors with enabled <strong>AdBlockers</strong> are not allowed</p>
';
} else {
    echo '
        <h1 style="color: #007bff;"><i class="fas fa-times-circle"></i> Disabled</h1>
        <p>Visitors with enabled <strong>AdBlockers</strong> are allowed</p>
';
}
?>
                            </div>
                        </div>
						
                        <div class="card">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-info-circle"></i> What is AdBlocker</h3>
							</div>
							<div class="card-body">
                        	    <strong>AdBlocker</strong> is a piece of software that is designed to prevent advertisements from appearing on a web page.
                        	</div>
                        </div>
						
                    </div>
                    
                    <div class="col-md-4">
						
<form class="form-horizontal form-bordered" action="" method="post">
                        <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-cogs"></i> Settings</h3>
							</div>
							<div class="card-body">
                                 <ul class="list-group">
<form class="form-horizontal form-bordered" action="" method="post">
										<li class="list-group-item">
											<p>Detection</p>
														<input type="checkbox" name="detection" class="psec-switch" <?php
if ($row['detection'] == 1) {
    echo 'checked="checked"';
}
?> /><br />
											<span class="text-muted">If this protection module is enabled all threats of this type will be blocked</span>
										</li>
                                        <li class="list-group-item">
											<p>Redirect URL</p>
											<input name="redirect" class="form-control" id="abredirect" type="text" value="<?php
echo $row['redirect'];
?>" required>
										</li>
									</ul>
                            </div>
                            <div class="card-footer">
							    <button class="btn btn-flat btn-block btn-primary" name="save" type="submit"><i class="fas fa-save"></i> Save</button>
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