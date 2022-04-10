<?php
include "header.php";

$query = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Blocked_ISP'");
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
				
                    <p class="font35">
<span class="fa-stack fa-lg">
  <i class="fas fa-wifi fa-stack-1x"></i>
  <i class="fas fa-ban fa-stack-2x text-danger"></i>
</span></p>
                <h6>Please contact with the webmaster of the website if you think something is wrong.</h6>
				
				<br />
	            <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-primary col-12" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
			</center>
        </div>

<?php
include "footer.php";
?>