<?php


require(__DIR__.'/dbconf.php');
require(__DIR__.'/db_functions.php');

$db_con = mysqli_connect($host, $user, $pass, $db); 

if (isset($_POST['treas_search'])){
    
    $itemName = $_POST['treas_search'];
    
    echo $itemName; ?>

<ul id='treas_list'>

<?php 
$sql = "SELECT itemName FROM Equipment WHERE itemName LIKE '%".$itemName."%' ";

$query= mysqli_query($db_con, $sql) or die("Cannot connect to database");

while($row=mysqli_fetch_assoc($query))
{ ?>
	<li onclick='fill("#treas_display","#treas_search","<?php echo $row['itemName'];?>")'>

	<a>
	
	<?php echo $row['itemName'];?>
	
	</li></a>
	
	<?php 

}}
?>
</ul>
<?php
mysqli_close($db_con);
?>