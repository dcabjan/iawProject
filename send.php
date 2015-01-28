<?php
$pageTitle = 'Event Sender';
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

if(isset($_SESSION['login'])) {

	//If title and message is set, send email
	if (!empty($_POST['title']) && !empty($_POST['message'])) {
		if ($_POST['submit']=="Send") {
			$title=$_POST['title'];
			$event=$_COOKIE['eventName'];
			$evento=rawurlencode("$event");
			$eventDate=$_COOKIE['eventDate'];
			
		  	$q="SELECT parentName,email FROM emailList";
		  	$r=@mysqli_query($dbc,$q);
			$numr=mysqli_num_rows($r);
			
			if ($numr>0) {
				$cont=0;
			  	while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			  		$message=$_POST['message'];
				  	$message.="\n\n\n\n\n\nPor favor, confirma si asistirás:\n
				  	<a href=\"http://dcabjan.nfshost.com/cabot/ans_yes.php?$evento?$eventDate\">Asistiré</a>
				  	\n<a href=\"http://dcabjan.nfshost.com/cabot/ans_no.php?$evento?$eventDate\">No asistiré</a>";
			  		$saludo="Estimado/a ".$row['parentName'].",\n\n";
			  		$message=$saludo.$message;
					mail($row['email'], $title, $message); //We send the email
					$cont+=1;
				}
			  	$q="UPDATE events SET answerNa=".$cont." WHERE eventName='".$event."' AND eventDate='".$eventDate."'";
			  	@mysqli_query($dbc,$q);

				//echo $message; //This is just for testing e-mail's message without having to wait to receive the e-mail.
				echo "Your e-mail has been sent!"; //Confirmation

				//Destroy the cookies used.
				setcookie("eventName", "", time()-3600);
				setcookie("eventDate", "", time()-3600);

			} else {
			 	echo "An error has ocurred. Please, try again later.<br />";
			 	echo "If the error persists, contact an administrator.";
			}
		}  
	}
	else { //Else, show the form
		echo "<form id=\"formSend1\" action=\"\" method=\"POST\">";
		if ($_POST['submitSet']=="Set") { //If "Check" was pressed, we show all eventDates related to event name selected
  			echo "You have selected the event: ";
  			echo "<select name=\"eventName\">";
  			echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>";
  			echo "</select>";
  			echo "<br /><br />With date: ";
  			echo "<select name=\"eventDate\">";
  			$date=$_POST['eventDate'];
			$newDate=date("d-m-Y", strtotime($date));
  			echo "<option value=\"".$_POST['eventDate']."\">".$newDate."</option>";	
  			echo "</select>";
  			echo "<br /><br />";	
  		
  			setcookie("eventName", $_POST['eventName']);
  			setcookie("eventDate", $_POST['eventDate']);	
  		}
		else if (!($_POST['submitSet']=="Set")) {
			echo "Select an event:";
			echo "<select name=\"eventName\">";

			$q="SELECT DISTINCT(eventName) FROM events WHERE eventDate>now()";
			$r=@mysqli_query($dbc,$q);

			if (isset($_POST['eventName']))
				echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>";	
			else {
				while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
	  				echo "<option value=\"".$row['eventName']."\">".$row['eventName']."</option>";				
	  			}
			}
			
			echo "</select>";
		}

		if ($_POST['submitCheck']=="Check") { //If "Check" was pressed, we show all eventDates related to event name selected
			echo "<div id='butDate'><br><br>Select the date: <select name=\"eventDate\">";
			$q="SELECT eventDate FROM events WHERE eventName='".$_POST['eventName']."'";
			$r=@mysqli_query($dbc,$q);
			while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$date=$row['eventDate'];
				$newDate=date("d-m-Y", strtotime($date));
  				echo "<option value=\"".$row['eventDate']."\">".$newDate."</option>";				
  			}
  		}
  				  		
		echo "</select>";

		if (!isset($_POST['eventName']))
			echo " <input type=\"submit\" name=\"submitCheck\" value=\"Check\" />";
		elseif (!isset($_POST['eventDate']))
			echo " <input type=\"submit\" name=\"submitSet\" value=\"Set\" />";
?>
		</form>
		</div>

		<div id="divSend2">
		<form id="formSend2" action="" method="POST">

			Subject
			<br />

			<?php
			if (!isset($_POST['title']))
				echo "<input id='sendText' maxlength='70' type=\"text\" name=\"title\" />";
			else
				echo "<input id='sendText' maxlength='70' type=\"text\" name=\"title\" value=\"".$_POST['title']."\" />";
			?>

			<br />
			Message
			<br />

		<?php
		if (!isset($_POST['message']))
			echo "<textarea maxlength='700' name=\"message\"></textarea>";
		else
			echo "<textarea maxlength='700' name=\"message\">".$_POST['message']."</textarea>";
		?>

		<br />

		<div class="send">
			<input type="submit" name="submit" value="Send" />
			<input type="button" class="navoff" value="Reset all" onclick="location.href='send.php'">
		</div>

		</form>

	<?php
	}
}
else {
	echo '<div class="answer">';
	echo 'YOU ARE NOT LOGGED.<br>';
	echo '<form action="./login.php">';
    echo '<input class="navoff" type="submit" value="Login">';
	echo '</form>';
	echo '</div>';
}
//Require footer
require('./requireFooter.php');
?>