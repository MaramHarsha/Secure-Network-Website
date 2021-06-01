<?php
include "header.php";
$table = $prefix . 'pages-layolt';
$query = $mysqli->query("SELECT * FROM `$table` WHERE page='Banned_Country'");
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
  <i class="fas fa-globe fa-stack-1x"></i>
  <i class="fas fa-ban fa-stack-2x text-danger"></i>
</span></p>
<?php
$cid = 0;
if(isset($_GET['c_id'])) {
	$cid = (int) $_GET['c_id'];
}

if ($cid > 0) {
    $table2      = $prefix . 'bans-country';
    $querybanned = $mysqli->query("SELECT * FROM `$table2` WHERE id='$cid'");
    $banned      = mysqli_num_rows($querybanned);
    $rowcb       = mysqli_fetch_array($querybanned);
    $redirect    = $rowcb['redirect'];
    $url         = $rowcb['url'];
    if ($redirect == 1) {
        echo '<br /><center>You will be redirected</center><br />
		<meta http-equiv="refresh" content="4;url=' . $url . '">';
    }
}
?>
                <h6>Please contact with the webmaster of the website if you think something is wrong.</h6>
				
				<br />
	            <a href="mailto:<?php
echo $rowst['email'];
?>" class="btn btn-primary btn-block" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
                </center>
              </div>
          </div>
        </div>

<?php
include "footer.php";
?>