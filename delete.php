<!-- File: delete.php -->
<?php
$pageTitle = 'Manage Lists';
$subPage = 'delete';
require('./requireHeader.php');
require('./requireDB.php');
require('./requireFunctions.php');
require('./requireGest.php');

/*do this if the form is send*/
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['submit'] == "GO")){

	$email = $_POST['email'];

	#check if the email field is filled in
	if(!empty($email)){

		#check if the email is a valid email
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){

			/*make the query to the database to delete a register in the emailList table*/
			$qDelete = "DELETE FROM emailList WHERE email='" . $email . "'";
			/*run the query*/
			$rDelete = @mysqli_query ($dbc, $qDelete);
			
			/*reload the insert form*/
			header('Location: ./delete.php');
		}
		#error if the email field is not valid
		else{
			echo '<p>The email address you entered is not valid.</p>';
			echo $back;
		}
	}
	#error if the email address field is empty
	else{
		echo '<p>You must fill in the email address field.</p>';
		echo $back;
	}
}
/*do this if the form is not send*/
else{
	?>
	<div id="gestForm">
		<!-- show the form -->
		<form action="" method="POST">
		<div class="operForm">
			<p>Email: <input type="text" name="email" /></p>
		</div>

			<!-- submenu with the action buttons -->
			<div id="gestSubmenu" class="send">
				<input type="submit" value="Go" name="submit">
				<input type="reset" value="Clear" name="reset">
			</div>
		</form>
	</div>
	<?php
}
?>

<?php
require('./requireEmails.php');
require('./requireFooter.php');
?>
