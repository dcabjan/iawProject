<?php
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

//If title and message is set, send email

if (!empty($_POST['title']) && !empty($_POST['message'])) {
if ($_POST['submit']=="Send") {
	$title=$_POST['title'];
	$event=$_POST['eventName'];
	$eventDate=$_POST['eventDate'];
	$message=$_POST['message'];
  	$message.="\n\n\n\n\n\nPor favor, confirma si asistirás:\n
  	<a href=\"http://dcabjan.nfshost.com/iawProject/ans_yes.php?$event?$eventDate\">Asistiré</a>
  	\n<a href=\"http://dcabjan.nfshost.com/iawProject/ans_no.php?$event?$eventDate\">No asistiré</a>";

  	$q="SELECT parentName,email FROM emailList";
  	$r=@mysqli_query($dbc,$q);
	$numr=mysqli_num_rows($r);

	if ($numr>0) {
		$cont=0;
	  	while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
	  		$message="Estimado ".$row['parentName'].",\n\n".$message;
			mail($row['email'], $title, $message); //We send the email
			$cont+=1;
		}

	  	$q="UPDATE events SET answerNa=".$cont." WHERE eventName='".$event."' AND eventDate='".$eventDate."'";
	  	@mysqli_query($dbc,$q);

		echo "Your e-mail has been sent!"; //Confirmation

	} else {
	 	echo "An error has ocurred. Please, try again later.<br />";
	 	echo "If the error persists, contact an administrator.";
	}
}  
}

	else  { //Else, show the form
	?>

				<form action="" method="POST">
				<?php
				if (!($_POST['submitSet']=="Set")) {
				?>

				Select an event and press "Check"
				<select name="eventName">
				<?php
				$q="SELECT eventName FROM events WHERE eventDate>now()";
  				$r=@mysqli_query($dbc,$q);
  				if (isset($_POST['eventName']))
					echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>";	
				else {
	  				while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
		  				echo "<option value=\"".$row['eventName']."\">".$row['eventName']."</option>";				
		  			}
	  			}
				?>
				</select>
				<?php
				}

				if ($_POST['submitCheck']=="Check") { //If "Check" was pressed, we show all eventDates related to event name selected
					echo "<select name=\"eventDate\">";
					$q="SELECT eventDate FROM events WHERE eventName='".$_POST['eventName']."'";
	  				$r=@mysqli_query($dbc,$q);
	  				while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
	  					$date=$row['eventDate'];
	  					$newDate=date("d-m-Y", strtotime($date));
		  				echo "<option value=\"".$row['eventDate']."\">".$newDate."</option>";				
		  			}
		  		}

		  				  		
					?>
				</select>
				<?php
				if (!isset($_POST['eventName']))
					echo "<input type=\"submit\" name=\"submitCheck\" value=\"Check\" />";
				elseif (!isset($_POST['eventDate']))
					echo "<input type=\"submit\" name=\"submitSet\" value=\"Set\" />";
				?>
			</form>



		<form action="" method="POST">
			Subject
			<br />
			<?php
			if (!isset($_POST['title']))
				echo "<input type=\"text\" name=\"title\" />";
			else
				echo "<input type=\"text\" name=\"title\" value=\"".$_POST['title']."\" />";
			

				
			if ($_POST['submitSet']=="Set") { //If "Check" was pressed, we show all eventDates related to event name selected
		  			echo "<select name=\"eventName\">";
		  			echo "<option value=\"".$_POST['eventName']."\">".$_POST['eventName']."</option>";
		  			echo "</select>";

		  			echo "<select name=\"eventDate\">";
		  			$date=$_POST['eventDate'];
	  				$newDate=date("d-m-Y", strtotime($date));
		  			echo "<option value=\"".$_POST['eventDate']."\">".$newDate."</option>";	
		  			echo "</select>";	
		  			}

			?>

			<br />
			Message
			<br />
			<?php
			if (!isset($_POST['message']))
				echo "<textarea rows=\"15\" cols=\"50\" name=\"message\"></textarea>";
			else
				echo "<textarea rows=\"15\" cols=\"50\" name=\"message\">".$_POST['message']."</textarea>"; //NO FUNCIONA #######################################
			?>
			<br />

			<input type="submit" name="submit" value="Send" />
		</form>
	  
	<?php
	}
	?>



<?php
//Require footer
require('./requireFooter.php');
?>