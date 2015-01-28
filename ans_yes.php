<!-- File: ans_yes.php -->
<?php
$pageTitle = 'Answer Yes';
require('./requireHeader.php');
require('./requireDB.php');

$url = $_SERVER[QUERY_STRING];
$url = explode('?', $url);
$contador = count($url);
$eventDate = $url[$contador-1];
$eventName = $url[$contador-2];
$eventName = rawurldecode("$eventName");

/*create query to update the value 'no' in the event table*/
$q = "UPDATE events SET answerYes = answerYes+1, answerNa = answerNa-1 WHERE eventName = '".$eventName."' AND eventDate='".$eventDate."'";
/*execute the query*/
$r = @mysqli_query($dbc, $q);

/*if the user clicks yes, execute the query and show a message*/
if ($r){
	echo '<div class="answer">';
	echo 'Your election has been registered. Thank you.';
	echo '</div>';
}
/*if an error occurs show a message*/
else{
	echo '<div class="answer">';
	echo 'An error has occurred. Please, try again later.';
	echo '</div>';
}

require('./requireFooter.php');
?>