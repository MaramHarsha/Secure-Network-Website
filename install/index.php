<?php
include "core.php";
head();

if (isset($_POST['database_host'])) {
    $_SESSION['database_host'] = addslashes($_POST['database_host']);
} else {
    $_SESSION['database_host'] = '';
}
if (isset($_POST['database_username'])) {
    $_SESSION['database_username'] = addslashes($_POST['database_username']);
} else {
    $_SESSION['database_username'] = '';
}
if (isset($_POST['database_password'])) {
    $_SESSION['database_password'] = addslashes($_POST['database_password']);
} else {
    $_SESSION['database_password'] = '';
}
if (isset($_POST['database_name'])) {
    $_SESSION['database_name'] = addslashes($_POST['database_name']);
} else {
    $_SESSION['database_name'] = '';
}
?>
			<center><h6>Enter your database connection details. If you’re not sure about them, contact your hosting provider.</h6></center><hr />
                                
			<form method="post" action="" class="form-horizontal row-border"> 
                        
				<div class="form-group row">
					<p class="col-sm-3">Database Host: </p>
					<div class="col-sm-8">
						<div class="input-group">
							<div class="input-group-text">
								<i class="fas fa-database"></i>
							</div>
						<input type="text" name="database_host" class="form-control" placeholder="localhost" value="<?php
echo $_SESSION['database_host'];
?>" required>
                        </div>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-3">Database Name: </p>
					<div class="col-sm-8">
                        <div class="input-group">
							<div class="input-group-text">
								<i class="fas fa-list-alt"></i>
							</div>
						<input type="text" name="database_name" class="form-control" placeholder="security" value="<?php
echo $_SESSION['database_name'];
?>" required>
                        </div>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-3">Database Username: </p>
					<div class="col-sm-8">
                        <div class="input-group">
							<div class="input-group-text">
								<i class="fas fa-user"></i>
							</div>
						<input type="text" name="database_username" class="form-control" placeholder="root" value="<?php
echo $_SESSION['database_username'];
?>" required>
                        </div>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-3">Database Password: </p>
					<div class="col-sm-8">
                        <div class="input-group">
							<div class="input-group-text">
								<i class="fas fa-key"></i>
							</div>
						<input type="text" name="database_password" class="form-control" placeholder="" value="<?php
echo $_SESSION['database_password'];
?>">
                        </div>
					</div>
				</div><br />		
<?php
if (isset($_POST['submit'])) {
    $database_host     = $_POST['database_host'];
    $database_name     = $_POST['database_name'];
    $database_username = $_POST['database_username'];
    $database_password = $_POST['database_password'];
    
    @$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
    if (!$db) {
        echo '<div class="alert alert-danger">Error establishing a database connection.</div>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=settings.php" />';
    }
}
?>
				<input class="btn-primary btn col-12" type="submit" name="submit" value="Next" /><br /><br />
            </form>
			
<?php
// PHP Sessions check
$_SESSION['phpsess_check'] = "Test";
if (!isset($_SESSION['phpsess_check'])) {
	echo '<div class="alert alert-danger">PHP Sessions are not enabled.</div>';
}

// PHP MySQLi check
if(!function_exists('mysqli_connect')) {
	echo '<div class="alert alert-danger">PHP MySQLi extension is not enabled.</div>';
}

// PHP cURL check
if (!extension_loaded('curl')) {
    echo '<div class="alert alert-danger">PHP cURL extension is not enabled.</div>';
}

if (!function_exists('json_decode')) {
    echo '<div class="alert alert-danger">PHP json_decode function is not enabled.</div>';
}

footer();
?>