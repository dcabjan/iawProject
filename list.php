<?php
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

$q="SELECT * FROM events"; //We make a SELECT to know ALL courses listed in database
$r=@mysqli_query($dbc,$q);
?>

<form action="" method="POST">
<select name="event"> <!--We show the list of events in a dropdown list-->
<option>All</option> <!--By default, 'ALL' will appear-->
<option>Actives</option>
<option>Finished</option>
	<?php/* while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			echo "<option>".$row['eventDate']."</option><br />";
			} */?>
		</select>
<input type="submit" name="submit" value="Filter" />
<br /><br /><br />
</form>

<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		if ($_POST['submit']=="Filter") {
			if ($_POST['event']=="All") { //If  'ALL' is selected in filter, we make a SELECT * and we show all events
				$q="SELECT * FROM events ORDER BY eventDate";
			} elseif ($_POST['event']=="Actives") { //If not, we only show the event that the user has chosen
					//$q="SELECT * FROM events WHERE eventDate>'".$_POST['event']."'";
					$q="SELECT * FROM events WHERE eventDate>'".date('Y/m/d')."' ORDER BY eventDate"; //Active events will be shown
				} elseif ($_POST['event']=="Finished") {
					$q="SELECT * FROM events WHERE eventDate<'".date('Y/m/d')."' ORDER BY eventDate"; //Finished events will be shown
					}
			
			$r=@mysqli_query($dbc,$q); //We execute the query
			$num=mysqli_num_rows($r); //We count the number of returned fields
			
			echo "<p>You are filtering \"".$_POST['event']."\"</p>"; //We show an alert to let know the user what filter has used

			if ($num>0) { //If the number of returned rows is more than 0, we found matches, then we show them in a table
				echo "<form action=\"\" method=\"POST\">";
				echo "<table id=\"emailTable\">";
				echo "<tr style=\"font-weight:bold;text-align:center\"><td>Event Name</td><td>Event Date</td><td>Yes</td><td>No</td><td>Didn't answer</td></tr>";
				while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
					echo "<tr><td>".$row['eventName']."</td><td>".$row['eventDate']."</td><td>".$row['answerYes']."</td><td>".$row['answerNo']."</td><td>".$row['answerNa']."</td></tr>";
				}
				echo "</table>";
			}
		mysqli_close($dbc);
		}
	}
?>				
<?php
//Require footer
require('./requireFooter.php');
?>