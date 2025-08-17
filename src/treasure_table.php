<?php

require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$array[] = "";
$column[]="";
$row[]="";
$playarray[]="";
$playcol[]="";
$playrow[]="";
$soldarray[]="";
$soldcol[]="";
$soldrow[]="";

$playerName = $_POST['playerName'];

$x = 0;

$db_con = mysqli_connect($host, $user, $pass, $db);

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
        
    if ($row['sold'] == "0"){
      
    echo "<tr id='".$x."'>";
    
    echo "<td>".$row['id']."</td>";
    
    echo "<td>".$row['itemName']."</td>";
    
    echo "<td>".$row['qty']."</td>";
    
    echo "<td>".$row['value']."</td>";
    
    echo "<td>";?>
        
    <select id="player<?php echo $x ?>" onchange="changePlayer(<?php echo $x?>)">
    
    <?php 
        $playsql = "SELECT playerName from Players";
        
        $playquery = mysqli_query($db_con, $playsql) or die("Cannot connect to database");
        
        while($playrow=mysqli_fetch_assoc($playquery))
        {
            $array2[] = $playrow[$playcol];          
            $player = $playrow['playerName'];       
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
    
    echo "<td>";?>
    
    <input type="checkbox" id="sold<?php echo $x ?>" onchange="sellItem(<?php echo $x?>)">
       
<?php 
    echo "<td>";
    
    echo "<input type='button' value='Delete' class='delete' onclick='deleteRow(".$x.")'>";
   
    echo "</td>";
    
    
    echo "</tr>";
             
    }
    
    echo "</table>";
}
    
   
    mysqli_close($db_con);
?>