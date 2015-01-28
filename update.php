<!-- File: update.php -->
<?php
$pageTitle = 'Manage Lists';
$subPage = 'update';
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
			$pname = $_POST['pname'];
			$psurname = $_POST['psurname'];
			$scode = $_POST['scode'];
			$course = $_POST['course'];

			/*make the query to the database to select the fields that the user doesn't fill in*/
			$qSelect = "SELECT parentName, parentSurname, studentCode, course FROM emailList WHERE email='" . $email . "'";
			/*run the query*/
			$rSelect = @mysqli_query ($dbc, $qSelect);
			$select = mysqli_fetch_array($rSelect, MYSQLI_ASSOC);

			#check if the email field and at least another field is filled in to update the emailList table
			if(!empty($email) && (!empty($pname) || !empty($psurname) || !empty($scode) || !empty($course))){

				#check if the email is a valid email
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){

					#initialize error display variable
					$error = 0;

					#do if the student code field is filled in
					if(!empty($scode)){

						#check if the student code field only contains numbers
						if (!ctype_digit($scode)){
							$error = 3;
						}
					}
					#autofill field if student code is empty
					else{
						$scode = $select['studentCode'];
					}
					#do if the parent surname field is filled in
					if(!empty($psurname)){
						
						#check if the parent surname field only contains letters and spaces
						if (!ctype_alpha(str_replace(' ', '', $psurname))){
							$error = 2;
						}
					}
					#autofill field if parent surname is empty
					else{
						$psurname = $select['parentSurname'];
					}
					#do if the parent name field is filled in
					if(!empty($pname)){
						
						#check if the parent name field only contains letters and spaces
						if(!ctype_alpha(str_replace(' ', '', $pname))){
							$error = 1;
						}
					}
					#autofill field if parent name is empty
					else{
						$pname = $select['parentName'];
					}			
					#when update, if user don't update course, get it from db
					if (empty($course)){					
						$course = $select['course'];
					}

					switch ($error){
						case 0:
						/*get row values before updating row*/
						$a = @mysqli_query($dbc, "SELECT * FROM emailList WHERE email='" . $email . "'");
						$rowa = mysqli_fetch_array($a, MYSQLI_ASSOC);

						/*make the query to the database to update a register in the emailList table*/
						$qUpdate = "UPDATE emailList SET parentName='" . $pname . "', parentSurname='" . $psurname . "', studentCode='" . $scode . "', course='" . $course ."' WHERE email='" . $email . "'";
						/*run the query*/
						$rUpdate = @mysqli_query ($dbc, $qUpdate);

						/*get row values before updating row*/
						$b = @mysqli_query($dbc, "SELECT * FROM emailList WHERE email='" . $email . "'");
						$rowb = mysqli_fetch_array($b, MYSQLI_ASSOC);

						/*if the value of the rows have changed the register has been inserted */
						if($rowa != $rowb){
							echo '<p>The register has been updated succesfully.<br>';
							echo '<input type="button" class="navoff submit" value="New Update" onclick="location.href=\'update.php\'">';
						}
						/*if the number of rows are the same the register hasn't been inserted*/
						else{
							echo 'An error has ocurred. Please, review the information.<br>';
							echo 'If the error persists, contact an administrator.<br>';
							echo '<input type="button" class="navoff submit" value="Try again" onclick="history.back()">';
						}
						break;
						case 1:
						/*error if the parent name field is not valid*/
						echo '<p>ERROR</p>';
						echo '<p>The parent name you entered is not valid. Only letters and spaces are allowed</p>';
						echo $back;
						break;
						case 2:
						/*error if the parent surname field is not valid*/
						echo '<p>ERROR</p>';
						echo '<p>The parent surname you entered is not valid. Only letters and spaces are allowed</p>';
						echo $back;
						break;				
						case 3:
						/*error if the student code field is not valid*/
						echo '<p>ERROR</p>';
						echo '<p>The student code you entered is not valid. Only numbers are allowed.</p>';
						echo $back;
						break;
					}
				}
				#error if the email field is not valid
				else{
					echo '<p>ERROR</p>';
					echo '<p>The email address you entered is not valid.</p>';
					echo $back;
				}
			}
			#error if any field is empty
			else{
				echo '<p>ERROR</p>';
				echo '<p>You must fill in all the fields.</p>';
				echo $back;
			}
			?>

		</div>

		<?php
	}
	/*show the form if this is not send*/
	else{
		?>
		<div id="gestForm">
			<!-- show the form -->
			<form action="" method="POST">
				<div class="operForm">
					<p>Email: <input type="text" name="email" /></p>
					<p>Parent name: <input type="text" name="pname" size="10" /></p>
					<p>Parent surname: <input type="text" name="psurname" /></p>
					<p>Student code: <input type="text" name="scode" size="10" /></p>

					<!-- drop down list for the courses by taking the information from the database -->
					<?php
					echo 'Course: <select name="course" value="">Course</option>';
					echo "<option value=\"\" selected=\"selected\" disabled>Select a course...</option>"; 
					foreach ($rCourse as $row){
						echo "<option value='" . $row[courseName] . "'>" . $row[courseName] . "</option>"; 
					}
					echo "</select>";
					?>

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
	require('./requireEmails.php');
}
/*if the user is not logged then show an error message and a button to go to the login page*/
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

