<?php
include "header.php";
?>
        <br />
        <div class="row d-flex justify-content-center">
            <center>
				<div class="alert alert-danger" class="wpage_head">
                    <h5 class="alert-heading">You were identified as a Fake Bot and you cannot continue to the website</h5>
                </div><br />
				
				<p class="font20"><i class="fas fa-user-secret fa-4x"></i></p>
                <h6>Please contact with the webmaster of the website if you think something is wrong.</h6>
				
				<br />
	            <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-primary col-12" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
			</center>
        </div>

<?php
include "footer.php";
?>