<?php
require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$db_con = mysqli_connect($host, $user, $pass, $db); 

$playerName = $_POST['playerName'];
$charName = $_POST['charName'];
$charClass = $_POST['charClass'];
$charRace = $_POST['charRace'];
$charLvl = $_POST['charLvl'];

if(empty($playerName)){
    echo "Player Name is required.";
    mysqli_close($db_con);
    exit;
}
if(empty($charName)){
    $charName="NULL";
}

if(empty($charClass)){
    $charClass = "NULL";
}

if(empty($charRace)){
    $charRace = "NULL";
}

if(empty($charLvl)){
    $charLvl = "0";
}
else{
    //set charLvl to integer for MySQL
    $charLvl = (int)$charLvl;
}

addPlayerData($db_con, $playerName, $charName, $charClass, $charRace, $charLvl);
addPlayertoCoins($db_con, $playerName);

$column = "playerName";
$table = "Players";
$condition = "";
$key = "";

$query = selectData($db_con, $column, $table, $condition, $key);

echo "<a href='#' class='player' name='All'> Everything </a>";

while($row=mysqli_fetch_assoc($query)){
    
    $res[] = $row[$column];
    
    echo "<a href='#' class='player' name='".$row[$column]."'>".$row[$column]."</a>";
}
mysqli_close($db_con);
?>