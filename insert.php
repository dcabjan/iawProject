<!-- File: insert.php -->
<?php
$pageTitle = 'Manage Lists';
$subPage = 'insert';
require('./requireHeader.php');
require('./requireDB.php');
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

	#check if all the fields are filled in
		if(!empty($email) && !empty($pname) && !empty($psurname) && !empty($scode) && !empty($course)){

		#check if the email is a valid email
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){

			#check if the parent name field only contains letters and spaces
				if(ctype_alpha(str_replace(' ', '', $pname))){

				#check if the parent surname field only contains letters and spaces
					if(ctype_alpha(str_replace(' ', '', $psurname))){

					#check if the student code field only contains numbers
						if(ctype_digit($scode)){

							/*count the number of rows before executing the query*/
							$a = @mysqli_query($dbc, "SELECT * FROM emailList");
							$numa = mysqli_num_rows($a);

							/*make the query to the database to insert a register in the emailList table*/
							$qInsert = "INSERT INTO emailList (email, parentName, parentSurname, studentCode, course) VALUES ('" . $email . "','" . $pname . "','" . $psurname . "','" . $scode . "','" . $course ."')";
							/*run the query*/
							$rInsert = @mysqli_query ($dbc, $qInsert);

							/*count the number of rows after executing the query*/
							$b = @mysqli_query($dbc, "SELECT * FROM emailList");
							$numb = mysqli_num_rows($b);
							
							/*if the number of rows have changed the register has been inserted */
							if($numa != $numb){
								echo '<p>The register has been inserted succesfully.<br>';
								echo '<input type="button" class="navoff submit" value="New Insert" onclick="location.href=\'insert.php\'">';
							}
							/*if the number of rows are the same the register hasn't been inserted*/
							else{
								echo 'An error has ocurred. Please, review the information.<br>';
								echo 'If the error persists, contact an administrator.<br>';
								echo '<input type="button" class="navoff submit" value="Try again" onclick="history.back()">';
							}
						}
						#error if the student code field is not valid
						else{
							echo '<p>ERROR</p>';
							echo '<p>The student code you entered is not valid. Only numbers are allowed.</p>';
							echo $back;
						}

					}
					#error if the parent surname field is not valid
					else{
						echo '<p>ERROR</p>';
						echo '<p>The parent surname you entered is not valid. Only letters and spaces are allowed</p>';
						echo $back;
					}

				}
				#error if the parent name field is not valid
				else{
					echo '<p>ERROR</p>';
					echo '<p>The parent name you entered is not valid. Only letters and spaces are allowed</p>';
					echo $back;
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
/*do this if the form is not send*/
else{
	?>

	<div id="gestForm">
		<!-- show the form -->
		<form action="" method="POST">
			<div class="operForm">
				<p>Email: <input type="text" name="email" size="37" maxlength="40" /></p>
				<p>Parent name: <input type="text" name="pname" size="17" maxlength="20" /></p>
				<p>Parent surname: <input type="text" name="psurname" size="22" maxlength="25" /></p>
				<p>Student code: <input type="text" name="scode" size="10" maxlength="11" /></p>

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
			<div class="send" id="gestSubmenu">
				<input type="submit" value="Go" name="submit">
				<input type="reset" value="Clear" name="reset">
			</div>
		</form>
	</div>

	<?php
}
require('./requireEmails.php');
require('./requireFooter.php');
?>