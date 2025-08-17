<?php

/*$tabName = "Equipment";
$columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY", 
    "itemName VARCHAR (100) NOT NULL", 
    "value FLOAT(10,3)", 
    "weight FLOAT(5,3)",
    "type VARCHAR(20)",
    "details VARCHAR(20)");

$sql = 'CREATE TABLE ' .$tabName.' (';

for ($i = 0; $i < count($columns); $i++){
    $sql = $sql .= $columns[$i];
    
    if($i < count($columns)-1){
        $sql = $sql .= ", ";
    }
    
    else {
        $sql = $sql .=")";
    }
}

echo $sql;*/

require(__DIR__.'/db_functions.php' );
getColumnNames($con, "Armor");


?>