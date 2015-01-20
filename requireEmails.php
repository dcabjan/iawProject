<!-- drop down list to filter the emails by course -->
	<div id="gestFilter">

		Filter by course:
		<form action="" method="post">
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