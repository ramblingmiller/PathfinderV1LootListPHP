<?php
require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$itemName = $_POST['itemName'];
$playerName = $_POST['playerName'];

$db_con = mysqli_connect($host, $user, $pass, $db);

$sql = "DELETE FROM Treasure where itemName = '".$itemName."' AND playerName = '".$playerName."'";

mysqli_query($db_con, $sql) or die("Cannot connect to database");

mysqli_close($db_con);

?>