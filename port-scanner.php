<?php
require "core.php";
head();
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-search"></i> Port Scanner</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Port Scanner</li>
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
				<div class="col-md-9">	 
<?php
@set_time_limit(360);
ini_set('max_execution_time', 300); //300 Seconds = 5 Minutes
ini_set('memory_limit', '512M');

    $ports = array(
        20,
        21,
        22,
        23,
        25,
        53,
		79,
        80,
        110,
		115,
        119,
        135,
        137,
        138,
        139,
        143,
		194,
		389,
        443,
		445,
		465,
        520,
		548,
		515,
		587,
		631,
		993,
		995,
		1080,
        1433,
        1434,
		1521,
		1701,
        1723,
        2082,
        2086,
        2095,
        3306,
		3389,
		5432,
		5900,
		8000,
        8080,
		11211
    );
    
    $results = array();
    foreach ($ports as $port) {
        if ($pf = @fsockopen($_SERVER['SERVER_NAME'], $port, $err, $err_string, 1)) {
            $results[$port] = true;
            fclose($pf);
        } else {
            $results[$port] = false;
        }
    }
    
    echo '<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-th-list"></i> Scan results for <b>' . $_SERVER['SERVER_NAME'] . '</b></h3>
			</div>
			<div class="card-body">';
    
    echo '<div class="table-responsive"><table class="table table-bordered table-hover table-sm">
    <thead class="<?php echo $thead; ?>">
      <tr>
        <th><i class="fas fa-dot"></i> Port</th>
        <th><i class="fas fa-cogs"></i> Service</th>
        <th><i class="fas fa-info-circle"></i> Status</th>
      </tr>
    </thead>
    <tbody>';
    
    foreach ($results as $port => $val) {
        $prot = getservbyport($port, "tcp");
        echo "<tr><td>$port</td><td>$prot</td>";
        if ($val) {
            echo '<td><a href="http://' . $_SERVER['SERVER_NAME'] . ':' . $port . '" target="_blank" class="badge badge-danger" class="font13"><i class="fas fa-unlock"></i> Open</a></td></tr>';
        } else {
            echo '
			<td><font class="badge badge-success" class="font13"><i class="fas fa-lock"></i> Closed</font></td></tr>';
        }
    }
    
    echo '</tbody>
    </table></div>';
    
    echo '</div></div></div>';
?>
                    
				<div class="col-md-3">
				     <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-info-circle"></i> What is Port Scanning</h3>
						</div>
				        <div class="card-body">
						    Port Scanning is the name for the technique used to identify open ports and services available on a network host. Port Scanning is used to determine which ports are open and vulnerable to attacks. 
							<br /><br />
							Port Scanning is a slow proccess and can take a while.
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
<?php
footer();
?>