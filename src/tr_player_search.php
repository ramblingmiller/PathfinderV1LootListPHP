<?php

require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$db_con = mysqli_connect($host, $user, $pass, $db);

if (isset($_POST['play_search'])){
    
    $playerName = $_POST['play_search'];
    
    echo $playerName; ?>
    
<ul id='play_list'>

<?php 
$sql = "SELECT playerName FROM Players WHERE playerName LIKE '%".$playerName."%' ";

$query= mysqli_query($db_con, $sql) or die("Cannot connect to database");

while($row=mysqli_fetch_assoc($query))
{ ?>

<li onclick='fill("#play_display","#play_search","<?php echo $row['playerName'];?>")'>

	<a>
	
	<?php echo $row['playerName'];?>
	
	</li></a>
	
	<?php 

}}
?>
</ul>
<?php 
mysqli_close($db_con);
?>