<?php
include "header.php";

$query = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Proxy'");
$row   = mysqli_fetch_array($query);
?>
        <br />
        <div class="row d-flex justify-content-center">
            <center>
				<div class="alert alert-danger" class="wpage_head">
                    <h5 class="alert-heading"><?php
echo html_entity_decode($row['text']);
?></h5>
                </div><br />
				
                    <p class="font20"><i class="fas fa-globe fa-4x"></i></p>
                <h6>Please contact with the webmaster of the website if you think something is wrong.</h6>
				
				<br />
	            <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-primary col-12" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
			</center>
        </div>

<?php
include "footer.php";
?>