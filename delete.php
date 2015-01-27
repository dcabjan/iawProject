<!-- File: delete.php -->
<?php
$pageTitle = 'Manage Lists';
$subPage = 'delete';
require('./requireHeader.php');
require('./requireDB.php');

/*if the session is set show the page content*/
if(isset($_SESSION['login'])){
require('./requireGest.php');

/*do this if the form is send*/
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['submit'] == "Go")){
	?>

	<div id="insError">

		<?php
		$email = $_POST['email'];

	#check if the email field is filled in
		if(!empty($email)){

		#check if the email is a valid email
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){

				/*count the number of rows before executing the query*/
				$a = @mysqli_query($dbc, "SELECT * FROM emailList");
				$numa = mysqli_num_rows($a);

				/*make the query to the database to delete a register in the emailList table*/
				$qDelete = "DELETE FROM emailList WHERE email='" . $email . "'";
				/*run the query*/
				$rDelete = @mysqli_query ($dbc, $qDelete);

				/*count the number of rows after executing the query*/
				$b = @mysqli_query($dbc, "SELECT * FROM emailList");
				$numb = mysqli_num_rows($b);

				/*if the number of rows have changed the register has been inserted */
				if($numa != $numb){
					echo '<p>The register has been deleted succesfully.<br>';
					echo '<input type="button" class="navoff submit" value="New Delete" onclick="location.href=\'delete.php\'">';
				}
				/*if the number of rows are the same the register hasn't been inserted*/
				else{
					echo 'An error has ocurred. Please, review the information.<br>';
					echo 'If the error persists, contact an administrator.<br>';
					echo '<input type="button" class="navoff submit" value="Try again" onclick="history.back()">';
				}
			}
		#error if the email field is not valid
			else{
				echo '<p>ERROR</p>';
				echo '<p>The email address you entered is not valid.</p>';
				echo $back;
			}
		}
	#error if the email address field is empty
		else{
			echo '<p>ERROR</p>';
			echo '<p>You must fill in the email address field.</p>';
			echo $back;
		}
		?>

	</div>

	<?php
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
