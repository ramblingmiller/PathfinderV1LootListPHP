<?php
require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$db_con = mysqli_connect($host, $user, $pass, $db);

$qty =floatval($_POST['qty']);
$itemName = $_POST['itemName'];
$tr_play = $_POST['tr_play'];
$broken = $_POST['broken'];
$playerName = $_POST['playerName'];

$array[] = "";
$column="";
$x = 0;

if(empty($itemName)){
    echo "You must add a treasure";
    return;
    
}

if(empty($tr_play)){
    
    $tr_play = "Party";
}

if(empty($playerName)){
    $playerName = "All";
}

if($broken = "false"){
    $broken = "0"; // 0 is false
}
else {
    
    $broken = "1"; //1 is true
}

addTreasure($db_con, $qty, $itemName, $tr_play, $broken);

if(empty($playerName)){
    
    $playerName = "All";
}

if ($playerName == "All"){
    
    $sql = "Select * from Treasure";
    
}

else {
    
    $sql = "Select * FROM Treasure WHERE playerName = '".$playerName."'";
    
}


$query= mysqli_query($db_con, $sql) or die("Cannot connect to database");

echo "<tr>";

echo "<th> ID </th>";

echo "<th>Item Name</th>";

echo "<th>Quantity</th>";

echo "<th>Gold Value</th>";

echo "<th> Player Name </th>";

echo "<th>Broken</th>";

echo "<th>Sold</th>";

echo "</tr>";

while($row=mysqli_fetch_assoc($query))
{
    $x = $x+1;
    
    $array[] = $row[$column];
    
    if($row['broken'] == "1"){//1 is true
        
        $row['broken'] = "X";
    }
    else {
        
        $row['broken'] = "";
    }
    
    if ($row['sold'] == "1"){
        
        $row['sold'] == "X";
    }
    
    else{
        
        $row['sold'] == "";
    }
    
    echo "<tr id='".$x."'>";
    
    echo "<td>".$row['id']."</td>";
    
    echo "<td>".$row['itemName']."</td>";
    
    echo "<td>".$row['qty']."</td>";
    
    echo "<td>".$row['value']."</td>";
    
    echo "<td>";?>
        
    <select id="player<?php echo $x ?>" onchange="changePlayer(<?php echo $x?>)">
    
    <?php 
        $playsql = "SELECT playerName from Players";
        
        $query2 = mysqli_query($db_con, $playsql) or die("Cannot connect to database");
        
        while($row2=mysqli_fetch_assoc($query2))
        {
            $array2[] = $row2[$column2];
            
            $player = $row2['playerName'];
            
            if($player == $row['playerName']){
                
                echo "<option value=".$player." selected>".$player."</option>";
            }
            
            else {
                echo "<option value=".$player.">".$player."</option>";
            }
        }
    
    echo "</select>";
    
    echo "</td>";
    
    echo "<td>".$row['broken']."</td>";
    
    echo "<td>".$row['sold']."</td>";
    
    echo "<td>";
    
    echo "<input type='button' value='Delete' class='delete' onclick='deleteRow(".$x.")'>";
   
    echo "</td>";
    
    
    echo "</tr>";
             
    }
    
    echo "</table>";
    

mysqli_close($db_con);

?>