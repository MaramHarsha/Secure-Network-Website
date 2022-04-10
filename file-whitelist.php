<?php
require "core.php";
head();

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];

    $query = $mysqli->query("DELETE FROM `psec_file-whitelist` WHERE id='$id'");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-flag"></i> File Whitelist</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">File Whitelist</li>
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
if (isset($_POST['add'])) {
    $path       = addslashes(htmlspecialchars($_POST['path']));
    $notes      = addslashes(htmlspecialchars($_POST['notes']));
    
    $queryvalid = $mysqli->query("SELECT * FROM `psec_file-whitelist` WHERE path='$path' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
        echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>File</strong> is already whitelisted.</p>
        </div>
		';
    } else {
        $query = $mysqli->query("INSERT INTO `psec_file-whitelist` (path, notes) VALUES('$path', '$notes')");
    }
}
?>
                    
                <div class="row">
				<div class="col-md-9">
				
				<?php
if (isset($_GET['edit-id'])) {
    $id    = (int) $_GET["edit-id"];

    $sql   = $mysqli->query("SELECT * FROM `psec_file-whitelist` WHERE id = '$id'");
    $row   = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=file-whitelist.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=file-whitelist.php">';
    }
    
    if (isset($_POST['edit'])) {
        $path       = addslashes(htmlspecialchars($_POST['path']));
        $notes      = $_POST['notes'];
        
        $queryvalid = $mysqli->query("SELECT * FROM `psec_file-whitelist` WHERE path='$path' AND id != '$id' LIMIT 1");
        $validator  = mysqli_num_rows($queryvalid);
        if ($validator > "0") {
            echo '<br />
		<div class="callout callout-info">
                <p><i class="fas fa-info-circle"></i> This <strong>File</strong> is already whitelisted.</p>
        </div>';
        } else {
            $query = $mysqli->query("UPDATE `psec_file-whitelist` SET path='$path', `notes`='$notes' WHERE id='$id'");
            echo '<meta http-equiv="refresh" content="0; url=file-whitelist.php">';
        }
    }
?>
<form class="form-horizontal" action="" method="post">
                     <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Edit File</h3>
						</div>
				        <div class="card-body">
								<div class="form-group">
									<label class="control-label">File's Path: </label>
									<input type="text" name="path" placeholder="folder/file.php" class="form-control" value="<?php
    echo $row['path'];
?>" required>
								</div>
								<div class="form-group">
									<label class="control-label">Notes: </label>
									<textarea rows="4" name="notes" class="form-control" placeholder="Additional (descriptive) information can be added here"><?php
    echo $row['notes'];
?></textarea>
								</div>	
                        </div>
                        <div class="card-footer row">
							<div class="col-md-8">
								<button class="btn btn-block btn-flat btn-success" name="edit" type="submit">Save</button>
							</div>
							<div class="col-md-4">
								<button type="reset" class="btn btn-block btn-flat btn-default">Reset</button>
							</div>
						</div>
				     </div>
</form>
<?php
}
?>
				
				    <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">File Whitelist</h3>
						</div>
						<div class="card-body">
<table id="dt-basicphpconf" class="table table-strpathed table-bordered table-hover table-sm">
									<thead class="<?php echo $thead; ?>">
										<tr>
											<th><i class="fas fa-file-alt"></i> File</th>
											<th><i class="fas fa-clipboard"></i> Notes</th>
											<th><i class="fas fa-cog"></i> Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$query = $mysqli->query("SELECT * FROM `psec_file-whitelist`");
while ($row = $query->fetch_assoc()) {
    echo '
										<tr>
                                            <td>' . $row['path'] . '</td>
											<td>' . $row['notes'] . '</td>
											<td>
                                            <a href="?edit-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="?delete-id=' . $row['id'] . '" class="btn btn-flat btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
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
							<h3 class="card-title">Add File</h3>
						</div>
				        <div class="card-body">
						<form class="form-horizontal" action="" method="post">
								<div class="form-group">
									<label class="control-label">File's Path: </label>
									<input type="text" name="path" placeholder="folder/file.php" class="form-control" required>
							    </div>
								<div class="form-group">
									<label class="control-label">Notes: </label>
									<textarea rows="5" name="notes" class="form-control" placeholder="Additional (descriptive) information can be added here"></textarea>
								</div>	
                        </div>
                        <div class="card-footer">
							<button class="btn btn-block btn-flat btn-primary" name="add" type="submit"><i class="fas fa-plus-square"></i> Add</button>
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