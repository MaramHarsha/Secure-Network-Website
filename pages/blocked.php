<?php
include "header.php";
$table = $prefix . 'pages-layolt';
$query = $mysqli->query("SELECT * FROM `$table` WHERE page='Blocked'");
$row   = mysqli_fetch_array($query);
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
				
                    <p style="font-size: 20px;"><i class="fas fa-bug fa-4x"></i></p>
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