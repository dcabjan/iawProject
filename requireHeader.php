<!-- File: requireHeader.php -->
<?php 
session_start();

if (!isset($_SESSION['login'])) {
	
	header ("Location: http://dcabjan.nfshost.com/iawProject/login.php");
}

/*contains button that loads the previous URL in the history list*/
$back = '<input type="button" class="navoff" id="btnBack" value="Go Back" onClick="window.history.back()" \">';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $pageTitle; ?></title>
	<link rel="icon" type="image/jpg" href="./images/favicon.jpg">
	<link rel="stylesheet" href="./style.css" type="text/css" />
</head>
<body>

	<div id="container">

	

		<div id="header">
		<?php
		if(($pageTitle != 'ans_yes.php') && (!$pageTitle != 'ans_no.php')){
?>
			<a href="logout.php">LOGOUT</a>

			<?php
		}
		?>
			<h1>SJO-AMPA Notifier</h1>
		</div>
<?php
		if(($pageTitle != 'ans_yes.php') && (!$pageTitle != 'ans_no.php')){
?>
		
		<!-- contains the links to the different pages -->
		<div id="navigation">
			<div id="panel">
				<ul>
					<li><a href="list.php" class="<?php if($pageTitle == 'Event Statistics'){ echo 'navon';}else{echo 'navoff';} ?>" >EVENT STATISTICS</a></li>
					<li><a href="send.php" class="<?php if($pageTitle == 'Event Sender'){ echo 'navon';}else{echo 'navoff';} ?>" >EVENT SENDER</a></li>
					<li><a href="insert.php" class="<?php if($pageTitle == 'Manage Lists'){ echo 'navon';}else{echo 'navoff';} ?>" >MANAGE LISTS</a></li>
					<li><a href="create.php" class="<?php if($pageTitle == 'Create Event'){ echo 'navon';}else{echo 'navoff';} ?>" >CREATE EVENT</a></li>
				</ul>
			</div>
			
		</div>
<?php
		}
		?>
		<!-- displays the content of each page -->
		<div id="content">
			<div id="display">