<?php
include "../config.php";

$table   = $prefix . 'settings';
$queryst = $mysqli->query("SELECT email FROM `$table` LIMIT 1");
$rowst   = mysqli_fetch_array($queryst);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project SECURITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../assets/img/favicon.png">
    <meta charset="utf-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
  </head>
  <body>

    <div class="container">