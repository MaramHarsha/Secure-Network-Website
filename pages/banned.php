<?php
include "header.php";
$table = $prefix . 'pages-layolt';
$query = $mysqli->query("SELECT * FROM `$table` WHERE page='Banned'");
$row   = $query->fetch_assoc();
?>
        <br />
        <div class="row d-flex justify-content-center">
          <div class="col-lg-10">
              <div class="jumbotron">
                <center>
				<div class="alert alert-danger" style="background-color: #d9534f; color: white;">
                    <h5 class="alert-heading"><?php
echo html_entity_decode($row['text']);
?></h5>
                </div><br />
				
                    <p style="font-size: 35px;">
<span class="fa-stack fa-lg">
  <i class="fas fa-user fa-stack-1x"></i>
  <i class="fas fa-ban fa-stack-2x text-danger"></i>
</span></p>
<?php
$ip          = $_SERVER['REMOTE_ADDR'];
if ($ip == "::1") {
    $ip = "127.0.0.1";
}
$table2      = $prefix . 'bans';
$querybanned = $mysqli->query("SELECT * FROM `$table2` WHERE ip='$ip'");
$banned      = mysqli_num_rows($querybanned);
$row         = mysqli_fetch_array($querybanned);
$reason      = $row['reason'];
$redirect    = $row['redirect'];
$url         = $row['url'];
if ($banned > "0") {
    echo '<p>Reason: <strong>' . $reason . '</strong></p>';
}
if ($redirect == 1) {
    echo '<br /><center>You will be redirected</center><br />
<meta http-equiv="refresh" content="4;url=' . $url . '">';
}
?>
                <h6>Please contact with the webmaster of the website if you think something is wrong.</h6>
				
				<br />
	            <a href="mailto:<?php echo $rowst['email']; ?>" class="btn btn-primary btn-block" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
                </center>
              </div>
          </div>
        </div>

<?php
include "footer.php";
?>