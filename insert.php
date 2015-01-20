<!-- File: insert.php -->
<?php
$pageTitle = 'Manage Lists';
require('./requireHeader.php');
require('./requireDB.php');
require('./requireFunctions.php');
require('./requireGest.php');

/*do this if the form is send*/
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['submit'] == "GO")){

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

						/*make the query to the database to insert a register in the emailList table*/
						$qInsert = "INSERT INTO emailList (email, parentName, parentSurname, studentCode, course) VALUES ('" . $email . "','" . $pname . "','" . $psurname . "','" . $scode . "','" . $course ."')";
						/*run the query*/
						$rInsert = @mysqli_query ($dbc, $qInsert);
						
						/*reload the insert form*/
						header('Location: ./insert.php');
					}
						#error if the student code field is not valid
					else{
						echo '<p>The student code you entered is not valid. Only numbers are allowed.</p>';
						echo $back;
					}

				}
					#error if the parent surname field is not valid
				else{
					echo '<p>The parent surname you entered is not valid. Only letters and spaces are allowed</p>';
					echo $back;
				}

			}
				#error if the parent name field is not valid
			else{
				echo '<p>The parent name you entered is not valid. Only letters and spaces are allowed</p>';
				echo $back;
			}

		}
			#error if the email field is not valid
		else{
			echo '<p>The email address you entered is not valid.</p>';
			echo $back;
		}

	}
		#error if any field is empty
	else{
		echo '<p>You must fill in all the fields.</p>';
		echo $back;
	}
}
/*do this if the form is not send*/
else{
	?>
	<div id="gestForm">
		<!-- show the form -->
		<form action="" method="POST">
			<p>Email: <input type="text" name="email" /></p>
			<p>Parent name: <input type="text" name="pname" size="10" /></p>
			<p>Parent surname: <input type="text" name="psurname" /></p>
			<p>Student code: <input type="text" name="scode" size="10" /></p>

			<!-- drop down list for the courses by taking the information from the database -->
			<?php
			echo 'Course: <select name="course" value="">Course</option>';
			foreach ($rCourse as $row){
				echo "<option value='" . $row[courseName] . "'>" . $row[courseName] . "</option>"; 
			}
			echo "</select>";
			?>

			<!-- submenu with the action buttons -->
			<div id="gestSubmenu">
				<input type="submit" value="GO" name="submit">
				<input type="reset" value="CLEAR" name="reset">
			</div>
		</form>
	</div>

	<?php
}
require('./requireEmails.php');
require('./requireFooter.php');
?>