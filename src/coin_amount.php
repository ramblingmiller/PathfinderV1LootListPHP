<?php

require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$res[]="";

$db_con = mysqli_connect($host, $user, $pass, $db);

$playerName = $_POST['playerName'];

if(empty($playerName)){
    $playerName = "Party";
}

if($playerName == "All"){
    $playerName = "Party";
}


$column = "gold";
$table = "Coins";
$condition = "playerName";
$key = $playerName;

$query = selectData($db_con, $column, $table, $condition, $key);


echo "<div id='coin_text'>";
echo "<h6>".$playerName." Gold: </h6>";
echo "</div>";
echo "<div id='coin_amount'>";

while($row=mysqli_fetch_assoc($query)){
    
    $res[] = $row[$column];
    echo "<p>". $row[$column]. "</p>";
}

echo "</div>";

mysqli_close($db_con);
?>