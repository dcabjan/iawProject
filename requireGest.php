<!-- File: requireGest.php -->
<?php
/*contains button that loads the previous URL in the history list*/
$back = '<input type="button" id="btnBack" value="Go Back" onClick="window.history.back()" \">';
?>

<div id="actions">
	<div id="board">
		<a href='insert.php'>INSERT</a>
		<a href='update.php'>UPDATE</a>
		<a href='delete.php'>DELETE</a>
	</div>
</div>

<?php
/*make the query to the database for the drop down list of the courses names*/
$qCourse = "SELECT courseName FROM courses";
/*run the query*/
$rCourse = @mysqli_query ($dbc, $qCourse);
?>