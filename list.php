<!-- File: list.php -->
<?php
$pageTitle = 'Event Statistics';
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

/*if the session is set show the page content*/
if(isset($_SESSION['login'])){
?>

<div id="listSelect">
	Select an option to filter:
	<br>
	<form id="formFilter" action="" method="POST">
		<select name="event"> <!--We show the list of events in a dropdown list-->
			<option>All</option> <!--By default, 'ALL' will appear at dropdown list-->
			<option>Actives</option>
			<option>Finished</option>
		</select>
		<input type="submit" name="submit" value="Filter" />
	</form>
	<br>
</div>

<?php
if ($_SERVER['REQUEST_METHOD']=="POST"){
	if ($_POST['submit'] == "Filter"){
		if ($_POST['event'] == "All"){ //If 'ALL' is selected in filter, we make a SELECT * and we show all events
		$q="SELECT * FROM events ORDER BY eventDate";
	}
			elseif ($_POST['event']=="Actives"){ //If not, we only show the event that the user has chosen
				$q="SELECT * FROM events WHERE eventDate>'".date('Y/m/d')."' ORDER BY eventDate"; //Active events will be shown
			} 
			elseif ($_POST['event']=="Finished"){
					$q="SELECT * FROM events WHERE eventDate<'".date('Y/m/d')."' ORDER BY eventDate"; //Finished events will be shown
				}

			echo "<div id='pFilter'><span>You are filtering \"".$_POST['event']."\".</span></div>"; //We show an alert to let know the user what filter has used
		}
	}
	else{
		$q="SELECT * FROM events WHERE eventDate>'".date('Y/m/d')."' ORDER BY eventDate"; //Active events will be shown by default
		echo '<div id="pFilter"><span>You are filtering "Actives".</span></div>';
	}

	$r = @mysqli_query($dbc,$q); //We execute the query
	$num = mysqli_num_rows($r); //We count the number of returned fields

	if ($num>0){ //If the number of returned rows is more than 0, we found matches, then we show them in a table
		echo '<div id="listTable">';
		echo '<form action="" method=\"POST\">';
		echo '<table id="emailTable">';
		echo "<tr><th>EVENT NAME</th><th>EVENT DATE</th><th>YES</th><th>NO</th><th>DIDN'T ANSWER</th></tr>";
		while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			$date=strtotime($row['eventDate']);
			echo "<tr><td>".$row['eventName']."</td><td>".date('d/m/Y', $date)."</td><td>".$row['answerYes']."</td><td>".$row['answerNo']."</td><td>".$row['answerNa']."</td></tr>";
		}
		echo "</table>";
		echo '</div>';
	}

	mysqli_close($dbc); //Database connection is closed
	}
else{
	echo '<div class="answer">';
	echo 'YOU ARE NOT LOGGED.<br>';
	echo '<form action="./login.php">';
    echo '<input class="navoff" type="submit" value="Login">';
	echo '</form>';
	echo '</div>';
}
	require('./requireFooter.php');
	?>