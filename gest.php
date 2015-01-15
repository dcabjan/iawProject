<?php
$pageTitle = 'Manage Lists';
require('./requireHeader.php');
require('./requireDB.php');

/*make the query to the database for the drop down list of the courses names*/
$qCourse = "SELECT courseName FROM courses";
/*run the query*/
$rCourse = @mysqli_query ($dbc, $qCourse);

/*make the query to the database to list all the email registers*/
$qEmail = "SELECT email, parentName, parentSurname, studentCode, course FROM emailList";
/*run the query*/
$rEmail = @mysqli_query ($dbc, $qEmail);

/*do this if the form is send*/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
}
/*do this if the form is not send*/
else{
	?>
	<div id="gestForm">
		<!-- show the form -->
		<form action=""<?php $_SERVER['PHP_SELF'] ?>"" method="post">
			<p>Email: <input type="text" name="email" /></p>
			<p>Parent name: <input type="text" name="pname" size="10" /></p>
			<p>Parent surname: <input type="text" name="psurname" /></p>
			<p>Student code: <input type="text" name="scode" size="10" /></p>

			<!-- drop down list for the courses by taking the information from the database -->
			<?php
			echo 'Course: <select name="course" value="">Course</option>';
			foreach ($rCourse as $row){
				echo "<option value=" . $row[courseName] . ">" . $row[courseName] . "</option>"; 
			}
			echo "</select>";
			?>

			<!-- submenu with the action buttons -->
			<div id="gestSubmenu">
				<input type="submit" value="INSERT" name="submit">
				<input type="submit" value="UPDATE" name="submit">
				<input type="submit" value="DELETE" name="submit">
			</div>
		</form>
	</div>
	
	<!-- drop down list to filter the emails by course -->
	<div id="gestFilter">

		<?php
		echo 'Course: <select name="course" value="">Course</option>';
		foreach ($rCourse as $row){
			echo "<option selected>" . $row[ALL] . "</option>";
			echo "<option value=" . $row[courseName] . ">" . $row[courseName] . "</option>"; 
		}
		echo "</select>";
		?>

	</div>

	<!-- displays all the email registers -->
	<div id="list">

		<?php
		/*create the table*/
		echo '<table id="emailTable">';
		/*create the static row with the titles for each column*/
		echo '<tr><td align="left">EMAIL</td><td align="left">PARENT NAME</td><td align="left">PARENT SURNAME</td><td align="left">STUDENT CODE</td><td align="left">COURSE</td></tr>';
		/*take the values from the database for each email register*/
		while ($row = mysqli_fetch_array($rEmail, MYSQLI_ASSOC)) {
			echo '<tr><td align="left">' . $row['email'] . '</td><td align="left">' . $row['parentName'] . '</td><td align="left">' . $row['parentSurname'] . '</td><td align="left">' . $row['studentCode'] . '</td><td align="left">' . $row['course'] . '</td></tr>';
		}
		/*close the table*/
		echo '</table>';
		?>

	</div>

	<?php
}
require('./requireFooter.php');
?>