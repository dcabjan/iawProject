<!-- File: requireDB.php -->
<?php

// Database access information constants
DEFINE ('DB_USER', 'dcabjan');
DEFINE ('DB_PASSWORD', '*NN&?c8AMoDcc');
DEFINE ('DB_HOST', 'iawproject.db');
DEFINE ('DB_NAME', 'iawProject');

// Make the connection
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding
mysqli_set_charset($dbc, 'utf8');
?>
