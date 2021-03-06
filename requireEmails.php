<!-- File: requireEmails.php -->
<!-- drop down list to filter the emails by course -->
<div id="gestFilter">

	Select a course to filter:
	<form action="" class="send" method="post">
		<select name="course">
			<option value="All">All</option>";
			<?php
			foreach ($rCourse as $row){			
				echo "<option value='" . $row[courseName] . "'>" . $row[courseName] . "</option>"; 
			}
			?>
		</select>
		<input type="submit" name="submit" value="Filter" />
	</form>	
</div>

<?php
/*make the query to the database to list the email registers*/
if (($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['submit'] == "Filter")){
	if ($_POST['course'] == "All"){
		$qEmail = "SELECT email, parentName, parentSurname, studentCode, course FROM emailList";
	}
	else if ($_POST['submit'] == "Filter"){
		$qEmail = "SELECT email, parentName, parentSurname, studentCode, course FROM emailList WHERE course='" . $_POST['course'] . "'";
	}
}
/*if no filter is selected make the query to show all registers*/
else
{
	$qEmail = "SELECT email, parentName, parentSurname, studentCode, course FROM emailList";
}
/*run the query*/
$rEmail = @mysqli_query ($dbc, $qEmail);
?>

<!-- displays the email registers -->
<div id="list">

	<?php
	/*create the table*/
	echo '<table id="userTable">';
	/*create the static row with the titles for each column*/
	echo '<tr><th>EMAIL</th><th>PARENT NAME</th><th>PARENT SURNAME</th><th>STUDENT CODE</th><th>COURSE</th></tr>';
	/*take the values from the database for each email register*/
	while ($row = mysqli_fetch_array($rEmail, MYSQLI_ASSOC)) {
		echo '<tr><td>' . $row['email'] . '</td><td>' . $row['parentName'] . '</td><td>' . $row['parentSurname'] . '</td><td>' . $row['studentCode'] . '</td><td>' . $row['course'] . '</td></tr>';
	}
	/*close the table*/
	echo '</table>';
	?>

</div>