<?php
include "header.php";

$query = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Spam'");
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
				
                    <p class="font20"><i class="fas fa-keyboard fa-4x"></i></p>
                <h6>Please contact with the webmaster of the website if you think something is wrong.</h6>
				
				<br />
	            <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-primary col-12" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
				<br />
                <h6>To check in which Spam Database (DNSBL) you attend click the button below:</h6>
                <a href="https://www.dnsbl.info/dnsbl-database-check.php" class="btn btn-info col-12" target="_blank">Check</a>
				
			</center>
        </div>

<?php
include "footer.php";
?>