<?php
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

$url=$_SERVER[QUERY_STRING];
$url=explode('?',$url);
$contador=count($url);
$eventDate=$url[$contador-1];
$eventName=$url[$contador-2];

$q="UPDATE events SET answerYes=answerYes+1, answerNa=answerNa-1 WHERE eventName='".$eventName."' AND eventDate='".$eventDate."'";
$r=@mysqli_query($dbc,$q);

if ($r){
	echo '<div class="answer">';
	echo "Your election has been registered. Thank you.";
	echo '</div>';
}
else{
	echo '<div class="answer">';
	echo "An error has occurred. Please, try again later.";
	echo '</div>';
}

//Require footer
require('./requireFooter.php');
?>