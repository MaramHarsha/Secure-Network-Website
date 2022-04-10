<?php
require "core.php";
head();

// Purge logs older than 30 days
$datetod = strtotime(date('d F Y', strtotime('-30 days')));

$query2 = $mysqli->query("SELECT id, date FROM `psec_live-traffic` ORDER BY id ASC");
while ($row2 = $query2->fetch_assoc()) {
	if (strtotime($row2['date']) < $datetod) {
		$id     = $row2['id'];
		$query3 = $mysqli->query("DELETE FROM `psec_live-traffic` WHERE id = '$id'");
	}
}

if (isset($_GET['delete-all'])) {
    $query = $mysqli->query("TRUNCATE TABLE `psec_live-traffic`");
}

//Today Stats
@$date = @date('d F Y');
@$ctime = @date("H:i", strtotime('-30 seconds'));

$tsquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date' AND `time`>='$ctime'");
$tscount1 = $tsquery1->num_rows;
$tsquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date' AND `uniquev`=1");
$tscount2 = $tsquery2->num_rows;
$tsquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date'");
$tscount3 = $tsquery3->num_rows;
$tsquery4 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date`='$date' AND `uniquev`=1 AND `bot`=1");
$tscount4 = $tsquery4->num_rows;

//Month Stats
@$mdate = @date('F Y');
$msquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` LIKE '%$mdate' AND `uniquev`=1");
$mscount1 = $msquery1->num_rows;
$msquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` LIKE '%$mdate'");
$mscount2 = $msquery2->num_rows;
$msquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` LIKE '%$mdate' AND `uniquev`=1 AND `bot`=1");
$mscount3 = $msquery3->num_rows;
?>
<div class="content-wrapper">

			<!--CONTENT CONTAINER-->
			<!--===================================================-->
			<div class="content-header">
				
				<div class="container-fluid">
				  <div class="row mb-2">
        		    <div class="col-sm-6">
        		      <h1 class="m-0 "><i class="fas fa-chart-line"></i> Visit Analytics</h1>
        		    </div>
        		    <div class="col-sm-6">
        		      <ol class="breadcrumb float-sm-right">
        		        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Admin Panel</a></li>
        		        <li class="breadcrumb-item active">Visit Analytics</li>
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
				<div class="col-md-12">
                    
                <div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">Visit Analytics</h3>
							<div class="float-sm-right">
								<a href="?delete-all" class="btn btn-flat btn-danger btn-sm"><i class="fas fa-trash"></i> Delete Data</a>
							</div>
						</div>
						<div class="card-body">
						
                             <h4 class="card-title">Today's Stats</h4><br />
							 
							 <div class="row">
                
					    <div class="col-sm-6 col-lg-3">
                            <div class="small-box bg-success">
                               <div class="inner">
                                   <h3><?php
echo $tscount1;
?></h3>
                                   <p>Online Visitors</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-users"></i>
                               </div>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-info">
                               <div class="inner">
                                   <h3><?php
echo $tscount2;
?></h3>
                                   <p>Unique Visits</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-chart-line"></i>
                               </div>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-danger">
                               <div class="inner">
                                   <h3><?php
echo $tscount3;
?></h3>
                                   <p>Total Visits</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-chart-bar"></i>
                               </div>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-3">
					        <div class="small-box bg-warning">
                               <div class="inner">
                                   <h3><?php
echo $tscount4;
?></h3>
                                   <p>Bot Visits</p>
                               </div>
                               <div class="icon">
                                   <i class="fab fa-android"></i>
                               </div>
                            </div>
					    </div>
					</div>
					
					    <br /><h4 class="card-title">This Month's Stats</h4><br />
					
					    <div class="row">
                
					    <div class="col-sm-6 col-lg-4">
					        <div class="small-box bg-info">
                               <div class="inner">
                                   <h3><?php
echo $mscount1;
?></h3>
                                   <p>Unique Visits</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-chart-line"></i>
                               </div>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-4">
					        <div class="small-box bg-danger">
                               <div class="inner">
                                   <h3><?php
echo $mscount2;
?></h3>
                                   <p>Total Visits</p>
                               </div>
                               <div class="icon">
                                   <i class="fas fa-chart-bar"></i>
                               </div>
                            </div>
					    </div>
					    <div class="col-sm-6 col-lg-4">
					        <div class="small-box bg-warning">
                               <div class="inner">
                                   <h3><?php
echo $mscount3;
?></h3>
                                   <p>Bot Visits</p>
                               </div>
                               <div class="icon">
                                   <i class="fab fa-android"></i>
                               </div>
                            </div>
					    </div>
					</div>
					
					<br /><h4 class="card-title">Visits This Month</h4><br />
					
						<canvas id="visits-chart"></canvas>
						
					<br /><h4 class="card-title">Overall Statistics</h4><br />	
						
						<div class="row">
						     <div class="col-md-6">
							      <center><h5><i class="fas fa-globe"></i> Browser Statistics</h5></center>
								  <div id="canvas-holder" class="width100">
								  	  <canvas id="browser-graph"></canvas>
								  </div>
							 </div>
							 
							 <div class="col-md-6">
							      <center><h5><i class="fas fa-desktop"></i> Operating System Statistics</h5></center>
							      <div id="canvas-holder" class="width100">
								  	  <canvas id="os-graph"></canvas>
								  </div>
							 </div>
					  </div>
					  <div class="row">
							 <div class="col-md-6">
							      <br /><center><h5><i class="fas fa-mobile-alt"></i> Device Statistics</h5></center>
							      <div id="canvas-holder" class="width100">
								  	  <canvas id="device-graph"></canvas>
								  </div>
							 </div>
						</div>
						
						<div class="col-md-12">
						<hr />
						    <h5>Visits by Country</h5><br />
							
<table id="dt-basic" class="table table-bordered table-hover table-sm">
									<thead>
										<tr>
								          <th><i class="fas fa-globe"></i> Country</th>
						                  <th><i class="fas fa-users"></i> Visitors</th>
										</tr>
									</thead>
									<tbody>
<?php
$countries = array(
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Cape Verde",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombi",
    "Comoros",
    "Congo (Brazzaville)",
    "Congo",
    "Costa Rica",
    "Cote d\'Ivoire",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor (Timor Timur)",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia, The",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea, North",
    "Korea, South",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia and Montenegro",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Swaziland",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
);

foreach ($countries as $country) {
    $log_result = $mysqli->query("SELECT country_code FROM `psec_live-traffic` WHERE `country` LIKE '%$country%'");
    $log_rows   = mysqli_num_rows($log_result);
    $lgrow      = mysqli_fetch_assoc($log_result);
    
    if ($log_rows > 0) {
        echo '<tr>';
        echo '<td><img src="assets/plugins/flags/blank.png" class="flag flag-' . strtolower($lgrow['country_code']) . '"/>&nbsp; ' . $country . '</td>';
        echo '<td>' . $log_rows . '</td>';
        echo '</tr>';
    }
}
?>
</tbody>
</table>

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