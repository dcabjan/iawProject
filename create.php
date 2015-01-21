<?php
$pageTitle = 'Create Event';
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

$meses=array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");

//If form is properly filled, we create a new event on database
if (!empty($_POST['event'])) {
	$title=$_POST['event'];
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$date=$year."-".$month."-".$day;

	$q="INSERT INTO `events`(`eventName`, `eventDate`) VALUES (\"$title\",\"$date\")";
	$r=@mysqli_query($dbc,$q);

	if ($r) {
		echo "Event created!";
	} else {
		echo "An error has occurred. Please, try again later.<br />";
		echo "If error persists, contact an administrator.";
	}
}
else {
?>
<!--Display a form to create a new event-->
	<form action="" method="POST">
		Select event date: <br />
		<select name="day">
			<?php
			for ($i=1;$i<32;$i++) {
				echo "<option value=\"".$i."\">".$i."</option>";
			}
			?>
		</select>
		
		<select name="month">
		<?php
		foreach ($meses as $k=>$v) {
			echo "<option value=\"".$k."\">".$v."</option>";
		}
		?>
		</select>

		<select name="year">
		<?php
			echo "<option value=\"".date("Y")."\">".date("Y")."</option>";
			echo "<option value=\"".date('Y', strtotime('+1 year'))."\">".date('Y', strtotime('+1 year'))."</option>";
		?>
		</select>

		<br /><br />

		Introduce event name: <br /> 
		<input type="text" name="event" />

		<input type="submit" name="submit" value="submit" />
	</form>

<?php
}
?>

<?php
//Require footer
require('./requireFooter.php');
?>