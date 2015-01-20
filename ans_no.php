<?php
//Require database connection and header
require('./requireHeader.php');
require('./requireDB.php');

$url=$_SERVER[QUERY_STRING];
$url=explode('?',$url);
$contador=count($url);
$eventDate=$url[$contador-1];
$eventName=$url[$contador-2];

$q="UPDATE events SET answerNo=answerNo+1, answerNa=answerNa-1 WHERE eventName='".$eventName."' AND eventDate='".$eventDate."'";
$r=@mysqli_query($dbc,$q);

if ($r)
	echo "Your election has been registered. Thank you.";
else
	echo "An error has occurred. Please, try again later.";


//Require footer
require('./requireFooter.php');
?>