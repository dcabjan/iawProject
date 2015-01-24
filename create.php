<!-- File: create.php -->
<?php
$pageTitle = 'Create Event';
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

//Function to display a drop down list to select a date (day/month/year)
function createSelectDate () {
	$meses=array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");
	?>
	Select event date: <br />
	<select name="day">
		<option value="" selected="selected" disabled>-</option>
		<?php
		for ($i=1;$i<32;$i++) {
			echo "<option value=\"".$i."\">".$i."</option>";
		}
		?>
	</select>
	
	<select name="month">
		<option value="" selected="selected" disabled>-</option>
		<?php
		foreach ($meses as $k=>$v) {
			echo "<option value=\"".$k."\">".$v."</option>";
		}
		?>
	</select>

	<select name="year">
		<option value="" selected="selected" disabled>-</option>
		<?php
		echo "<option value=\"".date("Y")."\">".date("Y")."</option>";
		echo "<option value=\"".date('Y', strtotime('+1 year'))."\">".date('Y', strtotime('+1 year'))."</option>";
		?>
	</select>
	<?php
}


//If Create button was pressed, we proceed this way to insert a new event
if ($_POST['submit']=="Create") {
	if(!empty($_POST['day']) && !empty($_POST['month']) && !empty($_POST['year']) && !empty($_POST['event'])){
	$title=$_POST['event'];
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$date=$year."-".$month."-".$day;

	$q="INSERT INTO `events`(`eventName`, `eventDate`) VALUES (\"$title\",\"$date\")";
	$ri=@mysqli_query($dbc,$q);

	if ($ri) {
		echo "Event created!";
	} else {
		echo "An error has occurred. Please, try again later.<br />";
		echo "If error persists, contact an administrator.";
	}
	
	echo "<br /><br />";
	echo "<input type=\"button\" value=\"Create more?\" onClick=\"location.href='create.php'\" />";
	}
	else{
		echo 'You must fill in all the fields';
		echo "<input type=\"button\" value=\"Go back\" onClick=\"location.href='create.php'\" />";
	}

//If Update button was pressed, we proceed this way to update an existent event
} elseif ($_POST['submit']=="Update")  {
	$title=$_POST['event'];
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$date=$year."-".$month."-".$day;
	$eventName=$_COOKIE['eventName'];
	$eventDate=$_COOKIE['eventDate'];
	
	if (!empty($title) && !empty($day)) {
		$q="UPDATE events SET eventName='".$title."', eventDate='".$date."' WHERE eventName=\"".$eventName."\" AND eventDate=\"".$eventDate."\"";
		$ru=@mysqli_query($dbc,$q);
	} elseif (!empty($title)) {		
		$q="UPDATE events SET eventName='".$title."' WHERE eventName=\"".$eventName."\" AND eventDate=\"".$eventDate."\"";
		$ru=@mysqli_query($dbc,$q);
	} elseif (!empty($day)) {
		$q="UPDATE events SET eventDate='".$date."' WHERE eventName=\"".$eventName."\" AND eventDate=\"".$eventDate."\"";
		$ru=@mysqli_query($dbc,$q);
	}		

	if ($ru) {
		echo "Event updated! <br />";
	} elseif (!$ru) {
		echo "An error has occurred. Please, try again later.<br />";
		echo "If error persists, contact an administrator.";
	}
	
	echo "<br /><br />";
	echo "<input type=\"button\" value=\"Update more?\" onClick=\"location.href='create.php'\" />";
	

} else {
	?>
	<div id="createN">
		<h3>Create an event</h3>
		<!--Display a form to create a new event-->

		<form action="" method="POST">
			<?php
			createSelectDate();
			?>
			<br /><br />

			Introduce event name: <br /> 

			<input type="text" name="event" />
			<br>
			<input type="submit" name="submit" value="Create" />
		</form>

	</div>
	<div id="createU">

		<h3>Update an event</h3>

		<!--Display all active events-->
		<form action="" method="POST">
			<?php
		//If eventName is not SET, show the form to select one event
			if (!isset($_POST['eventName'])) {
				?>
				<select name="eventName">
					<?php
					$q="SELECT DISTINCT eventName FROM events WHERE eventDate>now()";
					$r=@mysqli_query($dbc,$q);
					while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
						echo "<option value=\"".$row['eventName']."\">".$row['eventName']."</option>";
					}
					?>
				</select>
				<br>
				<input type="submit" name="Check" value="Check" />

				<?php
		} //If eventDate is not set, select an event date
		elseif (!isset($_POST['eventDate'])) { ?>
		
		<select name="eventName">
			<?php echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>"; ?>
		</select>
		<select name="eventDate">
			<?php
			$q="SELECT eventDate FROM events WHERE eventName=\"".$_POST['eventName']."\"";
			$r=@mysqli_query($dbc,$q);
			while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				echo "<option value=\"".$row['eventDate']."\">".date("d-m-Y", strtotime($row['eventDate']))."</option>";
			}
			?>		
		</select>
		<input type="submit" name="Set" value="Set" />
		
		<?php
	}	

		//If eventName and eventDate are set, we proceed to show the form to update DB
	if (isset($_POST['eventName']) && isset($_POST['eventDate'])) {
		setcookie("eventName",$_POST['eventName']);
		setcookie("eventDate",$_POST['eventDate']);
		$eventName=$_POST['eventName'];
		$eventDate=$_POST['eventDate'];
		echo "Updating event ".$eventName." on ".date("d-m-Y", strtotime($eventDate));
		echo "<br />";
		createSelectDate ();

		echo "<br />Introduce new event name: <br />";
		
		echo "<input type=\"text\" name=\"event\" />";
		echo "<input type=\"submit\" name=\"submit\" value=\"Update\" />";
		
	}
	?>


	
</form>
</div
<?php
}

//Require footer
require('./requireFooter.php');
?>