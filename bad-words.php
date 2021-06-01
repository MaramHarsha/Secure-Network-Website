<?php
require_once "core.php";
head();

if (isset($_POST['add-word'])) {
    $table      = $prefix . 'bad-words';
    $word       = $_POST['word'];
    $queryvalid = $mysqli->query("SELECT * FROM `$table` WHERE `word`='$word' LIMIT 1");
    $validator  = mysqli_num_rows($queryvalid);
    if ($validator > "0") {
    } else {
        $query = $mysqli->query("INSERT INTO `$table` (`word`) VALUES ('$word')");
    }
}

if (isset($_GET['delete-id'])) {
    $id    = (int) $_GET["delete-id"];
    $table = $prefix . 'bad-words';
    $query = $mysqli->query("DELETE FROM `$table` WHERE id='$id'");
}

if (isset($_POST['save'])) {
    $table = $prefix . 'settings';
    
    $badword_replace = $_POST['badword-replace'];
    $update          = $mysqli->query("UPDATE `$table` SET badword_replace='$badword_replace' WHERE id=1");
}
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-filter"></i> Protection Module</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Protection Module</li>
        		      </ol>
        		    </div>
        		  </div>
    			</div>
            </div>

				<!--Page content-->
				<!--===================================================-->
				<div class="content">
				<div class="container-fluid">

                <div class="row">
				<div class="col-md-8">
                    	    
<?php
$table   = $prefix . 'settings';
$query   = $mysqli->query("SELECT * FROM `$table`");
$row     = mysqli_fetch_array($query);
$table   = $prefix . 'bad-words';
$queryfc = $mysqli->query("SELECT * FROM `$table`");
$countfc = mysqli_num_rows($queryfc);
if ($countfc > 0) {
    echo '
              <div class="card card-solid card-success">
';
} else {
    echo '
              <div class="card card-solid card-primary">
';
}
?>
						<div class="card-header">
							<h3 class="card-title">Bad Words - Protection Module</h3>
						</div>
						<div class="card-body">
<?php
if ($countfc > 0) {
    echo '
        <h1 style="color: #47A447;"><i class="fas fa-check-circle"></i> Enabled</h1>
        <p>The bad words are <strong>Filtered</strong></p>
';
} else {
    echo '
        <h1 style="color: #007bff;"><i class="fas fa-times-circle"></i> Disabled</h1>
        <p>The bad words are not <strong>Filtered</strong></p>
';
}
?>
                        </div>
                    </div>
                    
                    <div class="card">
						<div class="card-header">
							<h3 class="card-title">Bad Words</h3>
							<button data-target="#add" data-toggle="modal" class="btn btn-flat btn-primary btn-sm float-sm-right"><i class="fas fa-plus-circle"></i> Add Bad Word</button>
						</div>
						<div class="card-body">
						
						<form action="" method="post" class="form-horizontal form-bordered">
						
						    <div class="form-group">
								<label class="control-label"><i class="fas fa-pen-square"></i> Replacement Word</label>
								<input type="text" name="badword-replace" value="<?php
echo $row['badword_replace'];
?>" class="form-control">
							</div>
						
						    <button type="button submit" name="save" class="mb-xs mt-xs mr-xs btn btn-flat btn-success btn-sm btn-block"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</button>
						</form>
						
						<hr /><br />
									
<form class="form-horizontal mb-lg" method="POST">
    <div class="modal fade" id="add" role="dialog" tabindex="-1" aria-labelledby="add" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">Add Bad Word</h6>
					<button data-dismiss="modal" class="close" type="button">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label class="control-label">Bad Word:</label>
						<input type="text" class="form-control" name="word" required />
					</div>
				</div>
				<div class="modal-footer">
					<input class="btn btn-block btn-flat btn-primary" name="add-word" type="submit" value="Add">
				</div>
			</div>
        </div>
    </div>
</form>               
<table id="dt-basic" class="table table-bordered table-hover table-sm">
									<thead class="<?php echo $thead; ?>">
										<tr>
											<th>Bad Word</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$table = $prefix . 'bad-words';
$query = $mysqli->query("SELECT * FROM `$table`");
while ($rowd = $query->fetch_assoc()) {
    echo '
										<tr>
                                            <td>' . $rowd['word'] . '</td>
											<td>
                                            <a href="?delete-id=' . $rowd['id'] . '" class="btn btn-flat btn-danger btn-sm btn-block"><i class="fas fa-trash"></i> Delete</a>
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
                    
                <div class="col-md-4">
                     <div class="card card-primary card-outline">
                        	<div class="card-header">
								<h3 class="card-title"><i class="fas fa-info-circle"></i> About Bad Words Filtering</h3>
							</div>
							<div class="card-body">
                                This module can be used to censore (hide, replace) bad words, links and sentences.
								<br /><br />
								If there are no bad words added the module is automatically disabled. 
								<br /><br />
								The module is working in two ways:
								<ul>
								  <li>Filtering bad words in real-time before Output (Page Rendering)</li>
								  <li>Filtering bad words after POST data is submitted</li>
								</ul>
								<strong>Replacement Word</strong> - Text (Word) that will be displayed instead the bad word
                        	</div>
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
<script>
$(document).ready(function() {

	$('#dt-basic').dataTable( {
		"responsive": true,
        "order": [[ 0, "asc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
} );
</script>    
<?php
footer();
?>