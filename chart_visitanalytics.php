<?php
require "core.php";

$array_count  = array();

//Browser Stats
$bquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` = 'Google Chrome'");
$array_count['bcount1'][] = $bquery1->num_rows;
$bquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` LIKE '%Firefox%'");
$array_count['bcount2'][] = $bquery2->num_rows;
$bquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` = 'Opera'");
$array_count['bcount3'][] = $bquery3->num_rows;
$bquery4 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` LIKE '%Edge%'");
$array_count['bcount4'][] = $bquery4->num_rows;
$bquery5 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` = 'Internet Explorer'");
$array_count['bcount5'][] = $bquery5->num_rows;
$bquery6 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` LIKE '%Safari%'");
$array_count['bcount6'][] = $bquery6->num_rows;
$bquery7 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `browser` != 'Google Chrome' AND `browser` NOT LIKE '%Firefox%' AND `browser` != 'Opera' AND `browser` NOT LIKE '%Edge%' AND `browser` != 'Internet Explorer' AND `browser` NOT LIKE '%Safari%'");
$array_count['bcount7'][] = $bquery7->num_rows;

//OS Stats
$oquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `os` LIKE '%Windows%'");
$array_count['ocount1'][] = $oquery1->num_rows;
$oquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `os` LIKE '%Linux%'");
$array_count['ocount2'][] = $oquery2->num_rows;
$oquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `os` LIKE '%Android%'");
$array_count['ocount3'][] = $oquery3->num_rows;
$oquery4 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `os` LIKE '%iOS%'");
$array_count['ocount4'][] = $oquery4->num_rows;
$oquery5 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `os` LIKE '%Mac OS X%'");
$array_count['ocount5'][] = $oquery5->num_rows;
$oquery6 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `os` NOT LIKE '%Windows%' AND  `os` NOT LIKE '%Linux%' AND `os` NOT LIKE '%Android%' AND `os` NOT LIKE '%iOS%' AND `os` NOT LIKE '%Mac OS X%'");
$array_count['ocount6'][] = $oquery6->num_rows;

//Platform Stats
$pquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `device_type` = 'Computer'");
$array_count['pcount1'][] = $pquery1->num_rows;
$pquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `device_type` = 'Mobile'");
$array_count['pcount2'][] = $pquery2->num_rows;
$pquery3 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `device_type` = 'Tablet'");
$array_count['pcount3'][] = $pquery3->num_rows;

$array_count['dateFY'][] = date("F Y");

$i    = 1;
@$days = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
while ($i <= $days) {
    $array_count['v_labels'][] = $i;
    
    $i++;
}

$i    = 1;
$days = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
while ($i <= $days) {
    @$mdatef = sprintf("%02d", $i) . ' ' . date("F Y");
    $mquery1 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` = '$mdatef'");
    $mcount1 = $mquery1->num_rows;
    $array_count['total_visits'][] = $mcount1;
    
    $i++;
}

$i = 1;
while ($i <= $days) {
    @$mdatef = sprintf("%02d", $i) . ' ' . date("F Y");
    $mquery2 = $mysqli->query("SELECT id FROM `psec_live-traffic` WHERE `date` = '$mdatef' AND `uniquev`=1");
    $mcount2 = $mquery2->num_rows;
    $array_count['unique_visits'][] = $mcount2;

    $i++;
}

echo json_encode($array_count);
?>