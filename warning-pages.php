<?php
require "core.php";
head();

if (isset($_POST['update'])) {
    $text = addslashes(htmlentities($_POST['text']));
    
    $text2 = addslashes(htmlentities($_POST['text2']));
    
    $text3 = addslashes(htmlentities($_POST['text3']));
    
    $text4 = addslashes(htmlentities($_POST['text4']));
    
    $text5 = addslashes(htmlentities($_POST['text5']));
    
    $text6 = addslashes(htmlentities($_POST['text6']));
    
    $text7 = addslashes(htmlentities($_POST['text7']));
    
    $text8 = addslashes(htmlentities($_POST['text8']));
    
    $text9 = addslashes(htmlentities($_POST['text9']));
    
    $update_banned = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text' 
WHERE page='Banned'");
    
    $update_blocked = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text2' 
WHERE page='Blocked'");
    
    $update_proxy = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text3' 
WHERE page='Proxy'");
    
    $update_spam = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text4' 
WHERE page='Spam'");
    
    $update_bannedc = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text5' 
WHERE page='Banned_Country'");
    
    $update_blockedbr = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text6' 
WHERE page='Blocked_Browser'");
    
    $update_blockedos = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text7' 
WHERE page='Blocked_OS'");
    
    $update_blockedisp = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text8' 
WHERE page='Blocked_ISP'");
    
    $update_blockedrfr = $mysqli->query("UPDATE `psec_pages-layolt` SET 
`text` = '$text9' 
WHERE page='Blocked_RFR'");
    
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-file-text"></i> Warning Pages</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Warning Pages</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

                     <div class="card card-primary card-outline">
						 <div class="card-header"><i class="fas fa-file-alt"></i> Warning Pages</div>
					
								<!--Tabs Content-->
								<div class="card-body">
								<div class="row">
								<div class="col-md-3">
								<div class="nav flex-column nav-tabs" aria-orientation="vertical">
									<a class="nav-link active" data-toggle="tab" href="#sqli-layout" aria-selected="true"><i class="fas fa-bug"></i> SQL Injection</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#proxy-layout" aria-selected="false"><i class="fas fa-globe"></i> Proxy</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#spam-layout" aria-selected="false"><i class="fas fa-keyboard"></i> Spam</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#banned-layout" aria-selected="false"><i class="fas fa-ban"></i> Banned IP</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#bannedc-layout" aria-selected="false"><i class="fas fa-flag"></i> Banned Country</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#bannedbr-layout" aria-selected="false"><i class="far fa-window-maximize"></i> Blocked Browser</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#bannedos-layout" aria-selected="false"><i class="fas fa-tablet"></i> Blocked OS</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#bannedisp-layout" aria-selected="false"><i class="fas fa-wifi"></i> Blocked ISP</a>
									<a class="nav-link" data-toggle="pill" role="tab" href="#bannedrfr-layout" aria-selected="false"><i class="fas fa-link"></i> Blocked Referrer</a>
								</div>				
								</div>
							    <div class="col-md-9">
								<form action="" method="post">
								<div class="tab-content">
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Blocked'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="sqli-layout" class="tab-pane fade active show">
<fieldset>	  
            <center>
			<label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text2" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>

<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Proxy'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="proxy-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text3" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
	        </center>
</fieldset>
									</div>
                                    
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Spam'");
$row   = mysqli_fetch_assoc($sql);
?>
                                    <div id="spam-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text4" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
	        </center>
</fieldset>
									</div>
                                    
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Banned'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="banned-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>
                                    
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Banned_Country'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="bannedc-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text5" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>
                                    
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Blocked_Browser'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="bannedbr-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text6" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>
                                    
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Blocked_OS'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="bannedos-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text7" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>
                                    
<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Blocked_ISP'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="bannedisp-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text8" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>

<?php
$sql   = $mysqli->query("SELECT * FROM `psec_pages-layolt` WHERE page='Blocked_RFR'");
$row   = mysqli_fetch_assoc($sql);
?>
									<div id="bannedrfr-layout" class="tab-pane fade">
<fieldset>
	        <center>
            <label><i class="fas fa-file-alt"></i> Page Text:</label>
	        <textarea name="text9" class="form-control" rows="5" type="text" required><?php
echo $row['text'];
?></textarea>
			</center>
</fieldset>
									</div>

								</div>
								</div>
								</div>
								<br />
								<input type="submit" class="btn btn-flat btn-success btn-md btn-block" name="update" value="Save" />
</form>
								</div>
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