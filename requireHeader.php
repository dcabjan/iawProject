<!-- File: requireHeader.php -->
<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="./style.css" type="text/css" />
</head>
<body>

	<div id="container">
		<div id="header">
			<h1>SJO-AMPA Notifier</h1>
		</div>
		<!-- contains the links to the different pages -->
		<div id="navigation">
			<div id="panel">
				<ul>
					<li><a href="list.php">EVENT STATISTICS</a></li>
					<li><a href="send.php">EVENT SENDER</a></li>
					<li><a href="gest.php">MANAGE LISTS</a></li>
					<li><a href="create.php">CREATE EVENT</a></li>
					<li><a href="logout.php">LOGOUT</a></li>
				</ul>
			</div>
		</div>
		<!-- displays the content of each page -->
		<div id="content">
			<div id="display">