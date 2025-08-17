<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>

<!-- Required meta tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Stylesheets -->
	<link rel="stylesheet" href="styles/stylesheet.css">
    <link rel="stylesheet" href="styles/bootstrap.css">


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src = "js/jquery-3.3.1.js"></script>
	<script src = "js/jquery.tabledit.js"></script>
	<script src = "js/js_functions.js"></script>
	<script src = "js/popper.js"></script>
	<script src = "js/bootstrap.bundle.js"></script>



<title>Treasure List</title>

</head>
    <body>
  <!--- The Header Section  ---->
<div class = "header">
	<h1> Pathfinder Treasure List</h1>
</div>

<!-- End Header Section -->

<!-- Left Menu  -->
<div class="leftmenu">
	<button type="button" id="addplayer_btn" class = "btn" data-toggle="modal" data-target="#playerPopup" >Add New Player</button>
	<button type="button" id="newtreasure_btn" class = "btn" data-toggle="modal" data-target="#treasurePopup">Add Treasure</button>

</div>
<!-- End Left Menu  -->

<!-- Player Popup -->
<div id="playerPopup" class="modal fade" role="dialog">
	<div class = "modal-dialog">
	
		<div  class = "modal-content">
			<div class = "modal-header">
				<h4 class="modal-title"> New Player</h4>
		     	<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class = "modal-body" id="addPlayer">
				<form id="newplayerform">
				<div>
					<label for = "playername"><b>Player Name:</b></label>
					<input type = "text" id = "playerName" required />
				</div>
				<div>
					<label for = "charName"><b>Character Name:</b></label>
					<input type = "text" id = "charName" />
				</div>
				<div>
					<label for = "charClass"><b>Class</b></label>
					<input type = "text" id = "charClass" />
				</div>
				<div>
					<label for = "charRace"><b>Race</b></label>
					<input type = "text" id = "charRace" />
				</div>
				<div>
					<label for = "charLevel"><b>Level</b></label>
					<input type = "number" id = "charLevel" min ="1" max ="20"/>
				</div>
				<div>
					<button type = "submit" class = "btn" id="newPlayer_btn"> Add Player</button>
				</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
<!-- End Add Player Table -->

<!-- Treasure Popup -->
<div id = "treasurePopup" class="modal fade" role="dialog">
	<div class = "modal-dialog">
			<div  class = "modal-content">
			
				<div class = "modal-header">
					<h4 class="modal-title"> Add Treasure</h4>
		     		<button type="button" class="close" data-dismiss="modal">&times;</button>
		     	</div>
		     <div class = "modal-body" id="addTreasure">
		    
		     	<form id="addtreasureform">
		     	
		     		<div>
    					<label for="treas_search"><b>Treasure: </b></label>
    					<input type="text" id="treas_search" placeholder="Search For Treasure" />
					</div>
					
					<div id = "treas_display"></div>
					
			
					<div>
						<label for="numofitems"><b>Number of Items: </b></label>
						<input type = "number" id="numofitems" min="1" value="1"/>
					</div>
					
					
					<div>
						<label for="player"><b>Player: </b></label>
						<input type="text" id="play_search" placeholder="Search For Player" />
					</div>
					
					<div id="play_display">	</div>
					
					<div>
						<label for="broken"><b>Broken: </b></label>
						<input type="checkbox" id="treasbrok" name="broken"/>
					
					</div>
					<div>
						<button type = "submit" class="btn" id="addTreasure_btn"> Add Treasure</button>
					</div>
				</form>
			</div>
						
		</div>
		     	
	</div>
</div>

<!-- End Treasure Popup -->

<!-- Player Navigation -->
<nav id ="playernav" class = "navdiv">
	
</nav>
<!-- End Player Navigation -->

<!-- Main Body Section -->

<!-- Coin Section -->
<div id="coins">


</div>
<form id = 'addcoinfm'>
<input type='number' class='addgold' id='gold' step='0.01' required />
<button type='submit' class='btn' id='addCoins_btn'> Add Gold</button>
</form>
</div>

</div>
	


<!-- End Coin Section -->

<!-- Treasure Table -->
<div class = "mainbody tableheader">
<h2 class = "mainbody"> Treasure List</h2>
</div>

<div id="treasuretable">

    <table id="trtable" class="table">
    
    
</div>
<!-- End Treasure Table -->
  

    </body>

</html>