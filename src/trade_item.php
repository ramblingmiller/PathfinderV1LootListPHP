<?php

require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$id = $_POST['id'];
$itemName = $_POST['itemName'];
$playerName = $_POST['playerName'];
$qty = $_POST['qty'];
$tradeqty = $_POST['tradeqty'];
$broken = $_POST['broken'];

error_log($qty);
error_log($tradeqty);
error_log($playerName);

$db_con = mysqli_connect($host, $user, $pass, $db);

if($tradeqty == 0 || $qty == 0){//straight out trade
    
    $sql = "UPDATE Treasure SET playerName = '".$playerName."' WHERE id = ".$id;
    
    mysqli_query($db_con, $sql) or die("Cannot connect to database");
}

else { //split the amount between two people
    
    //Add the trade information to the database
    addTreasure($db_con, $tradeqty, $itemName, $playerName, $broken);
    
    //get the value for the math.
    $valsql = "SELECT value from Equipment where itemName='".$itemName."' LIMIT 1";
    
    $query = mysqli_query($db_con, $valsql) or die("Could not get value");
    
    while($row=mysqli_fetch_assoc($query)){
        
        $val = $row['value'];
    }
    
    //Then subtract the number of items from the original owner and update the combined value.
      
    $newval = $qty*$val;
    
    $tradesql = "UPDATE Treasure SET qty = ".$qty.", value = ".$newval." WHERE id = ".$id;
    
    mysqli_query($db_con, $tradesql) or die("Cannot connect to database");
}

mysqli_close($db_con);

?>