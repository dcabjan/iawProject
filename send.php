<?php
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

//If title and message is set, send email
if (!empty($_POST['title']) && !empty($_POST['message'])) {
	$title=$_POST['title'];
  	$message=$_POST['message'];


  	$q="SELECT email FROM emailList";
  	$r=@mysqli_query($dbc,$q);

  	while ($row=mysqli_fetch_array($r,MYSQLI_ASSOC)) {
		mail($row['email'], $title, $message); //We send the email
	}
  	
	echo "Your e-mail has been sent!"; //Confirmation
  
}
	else  { //Else, show the form
	?>

		<form action="" method="POST">
			Subject
			<br />
			<input type="text" name="title" />
			<br />
			Message
			<br />
			<textarea rows="15" cols="50" name="message"></textarea>
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