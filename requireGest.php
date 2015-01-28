<!-- File: requireGest.php -->
<!-- shows the buttons to load each different form -->
<div id="actions">
	<div id="board">
		<input type="button" value="INSERT" class="<?php if($subPage == 'insert'){ echo 'navon';}else{echo 'navoff';} ?>" onclick="location.href='insert.php'">
		<input type="button" value="UPDATE" class="<?php if($subPage == 'update'){ echo 'navon';}else{echo 'navoff';} ?>" onclick="location.href='update.php'">
		<input type="button" value="DELETE" class="<?php if($subPage == 'delete'){ echo 'navon';}else{echo 'navoff';} ?>" onclick="location.href='delete.php'">
	</div>
</div>

<?php
/*make the query to the database for the drop down list of the courses names*/
$qCourse = "SELECT courseName FROM courses";
/*run the query*/
$rCourse = @mysqli_query ($dbc, $qCourse);
?>