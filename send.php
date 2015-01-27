<!-- File: send.php -->
<?php
$pageTitle = 'Event Sender';
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

/*if the session is set show the page content*/
if(isset($_SESSION['login'])){
//If title and message is set, send email
if (!empty($_POST['title']) && !empty($_POST['message'])) {

	if ($_POST['submit']=="Send") {
		
		$title = $_POST['title'];
		$event = $_COOKIE['eventName'];
		$eventDate = $_COOKIE['eventDate'];

		$q = "SELECT parentName,email FROM emailList";
		$r = @mysqli_query($dbc,$q);
		$numr = mysqli_num_rows($r);

		if ($numr > 0) {
			$cont = 0;
			while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$message=$_POST['message'];
				$message.="\n\n\n\n\n\nPor favor, confirma si asistirás:\n
				<a href='http://dcabjan.nfshost.com/cabot/ans_yes.php?" . urlencode($event) . "?" . urlencode($eventDate) ."'>Asistiré</a>
				\n<a href='http://dcabjan.nfshost.com/cabot/ans_no.php?" . urlencode($event) . "?" . urlencode($eventDate) ."'>No asistiré</a>";
				$saludo="Estimado/a ".$row['parentName'].",\n\n";
				$message=$saludo.$message;
				mail($row['email'], $title, $message); //We send the email
				$cont+=1;
			}

			$q = "UPDATE events SET answerNa=".$cont." WHERE eventName='".$event."' AND eventDate='".$eventDate."'";
			@mysqli_query($dbc,$q);

			echo "Your e-mail has been sent!"; //Confirmation
		}
		else {
			echo "An error has ocurred. Please, try again later.<br />";
			echo "If the error persists, contact an administrator.";
		}
		unset($_COOKIE['eventName']);
		unset($_COOKIE['eventDate']);
	}
}
else{//Else, show the form
	?>

	<form id="formSend1" action="" method="POST">
		Select an event:
		<select name="eventName">

			<?php
			$q = "SELECT DISTINCT(eventName) FROM events WHERE eventDate>now()";
			$r = @mysqli_query($dbc,$q);

			if (isset($_POST['eventName'])){
				echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>";	
			}
			else {
				while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
					echo "<option value=\"".$row['eventName']."\">".$row['eventName']."</option>";	
				}
			}
			?>

		</select>

		<?php
		if (!isset($_POST['eventName'])){
			echo "&nbsp<input type=\"submit\" name=\"submitCheck\" value=\"Show dates\" />";
		}
		else if (($_POST['submitSet'] == 'Show') || ($_POST['submitCheck'] != 'Select')){
			echo "<div id='butDate'><br><br>Select the date: <select name=\"eventDate\">";
			$q = "SELECT eventDate FROM events WHERE eventName='".$_POST['eventName']."'";
			$r = @mysqli_query($dbc,$q);
			while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$date = $row['eventDate'];
				$newDate = date("d-m-Y", strtotime($date));
				echo "<option value=\"" . $row['eventDate'] . "\">" . $newDate . "</option>";		
			}
		}
		?>

	</select>
	<?php		
	if (isset($_POST['eventName']) && !(isset($_POST['eventDate']))){
		echo "<input type=\"submit\" name=\"submitSet\" value=\"Select\" />";
	}
}
if (empty($_POST['title']) && empty($_POST['message'])){
	?>
</div>
</form>
<br />
<div id="divSend2">
	<form id="formSend2" action="" method="POST">
		Subject:
		<br>

		<?php
		if (!isset($_POST['title'])){
			echo "<input id='sendText' maxlength='70' type=\"text\" name=\"title\" />";
		}
		else{
			echo "<input id='sendText' maxlength='70' type=\"text\" name=\"title\" value=\"".$_POST['title']."\" />";
		}

			if ($_POST['submitSet']=="Set") { //If "Check" was pressed, we show all eventDates related to event name selected
			echo "<select name=\"eventName\">";
			echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>";
			echo "</select>";

			echo "<select name=\"eventDate\">";
			$date=$_POST['eventDate'];
			$newDate=date("d-m-Y", strtotime($date));
			echo "<option value=\"".$_POST['eventDate']."\">".$newDate."</option>";	
			echo "</select>";

			$_COOKIE['eventName'] = $_POST['eventName'];
			$_COOKIE['eventDate'] = $_POST['eventDate'];
				
		}

		?>

		<br><br>
		Message:
		<br>

		<?php
		if (!isset($_POST['message'])){
			echo "<textarea maxlength='700' name=\"message\"></textarea>";
		}
		else{
			echo "<textarea maxlength='700' name=\"message\">".$_POST['message']."</textarea>";
		}
		?>

		<br />
		<div class="send">
			<input type="submit" name="submit" value="Send" />
			<input type="button" class="navoff" value="Reset all" onclick="location.href='send.php'">
		</div>
	</form>
</div>

<?php
}
}
else{
	echo '<div class="answer">';
	echo 'YOU ARE NOT LOGGED.<br>';
	echo '<form action="./login.php">';
    echo '<input class="navoff" type="submit" value="Login">';
	echo '</form>';
	echo '</div>';
}

/*Require footer*/
require('./requireFooter.php');
?>