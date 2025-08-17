<?php

require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$db_con = mysqli_connect($host, $user, $pass, $db); 

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