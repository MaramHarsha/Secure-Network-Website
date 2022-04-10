<?php
require "core.php";
head();

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_bans-ranges`");
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_bans-ranges` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-grip-horizontal"></i> IP Range Bans</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">IP Range Bans</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">
				
<?php
if (isset($_POST['ban-iprange'])) {
    $ip_range = addslashes(htmlspecialchars($_POST['ip_range']));
    
    $queryvalid = $mysqli->query("SELECT * FROM `psec_bans-ranges` WHERE ip_range='$ip_range' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>IP Range</strong> is already banned.</p>
        </div>
		';
    } else {
        $query = $mysqli->query("INSERT INTO `psec_bans-ranges` (`ip_range`) VALUES ('$ip_range')");
    }
}
?>
                    
                <div class="row">
                    
				<div class="col-md-9">
<?php
if (isset($_GET['edit-id'])) {
    $id    = (int) $_GET["edit-id"];
    
    if (isset($_POST['edit-ban'])) {
        $ip_range = addslashes(htmlspecialchars($_POST['ip_range']));
        
        $update = $mysqli->query("UPDATE `psec_bans-ranges` SET ip_range = '$ip_range' WHERE id='$id'");
    }
    
    $result = $mysqli->query("SELECT * FROM `psec_bans-ranges` WHERE id = '$id'");
    $row    = mysqli_fetch_assoc($result);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=bans-iprange.php">';
        exit();
    }
    if (mysqli_num_rows($result) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=bans-iprange.php">';
        exit();
    }
?>         
<form class="form-horizontal" action="" method="post">
                    <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Edit - IP Range Ban #<?php
    echo $id;
?></h3>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label class="control-label">IP Range: </label>
								<input name="ip_range" class="form-control" type="text" maxlength="19" value="<?php
    echo $row['ip_range'];
?>" required>
							</div>
                        </div>
						<div class="card-footer row">
							<div class="col-md-8">
								<button class="btn btn-flat btn-success btn-block" name="edit-ban" type="submit">Save</button>
							</div>
							<div class="col-md-4">
								<button type="reset" class="btn btn-flat btn-default btn-block">Reset</button>
							</div>
						</div>
                     </div>
				</form>
<?php
}
?>
				    <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">IP Range Bans</h3>
							<a href="?delete-all" class="btn btn-flat btn-danger btn-sm float-sm-right" data-toggle="tooltip" title="Delete all IP Range Bans"><i class="fas fa-trash"></i> Delete All</a>
						</div>
						<div class="card-body">

<table id="dt-basic2" class="table table-bordered table-hover table-sm">
									<thead class="<?php echo $thead; ?>">
										<tr>
						                  <th><i class="fas fa-grip-horizontal"></i> IP Range</th>
										  <th><i class="fas fa-cog"></i> Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_bans-ranges`");
while ($row = $query->fetch_assoc()) {
    echo '
										<tr>
						                    <td>' . $row['ip_range'] . '</td>
											<td>
                                            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-success btn-sm"><i class="fas fa-trash"></i> Unban</a>
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

				<div class="col-md-3">
				     <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Ban IP Range</h3>
						</div>
				        <div class="card-body">
						<form class="form-horizontal" action="" method="post">
							<div class="form-group">
								<label class="control-label">IP Range: </label>
								<input name="ip_range" class="form-control" type="text" placeholder="Format: 12.34.56 or 1111:db8:3333:4444" maxlength="19" value="" required>
							</div>
                        </div>
                        <div class="card-footer">
							<button class="btn btn-flat btn-danger btn-block" name="ban-iprange" type="submit">Ban</button>
				        </div>
				     </div>
				</div>
</form>
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