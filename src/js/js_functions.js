
//Global variables
var player = "All";
var dataString = "playerName=" + player;

$(document).ready(function(){
	//Add the Gold output for the party
	$.ajax({
		type: "POST",
		url: "coin_amount.php",
		data: dataString,
		cache: false,
		success: function(postresult){
			 $("#coins").html(postresult);}
	});
	// Add the treasure to the treasure table	
	$.ajax({
		type: "POST",
		url: "treasure_table.php",
		data: dataString,
		cache: false, 
		success: function(postresult){
			$("#trtable").html(postresult);}
	});
	
	//Add the navigation links with the player names
	$.post("player_tab.php", function(postresult){
		$("#playernav").html(postresult);});
		
	
	$("#treas_search").keyup(function(){
		var itemName = $("#treas_search").val();
	
		if (itemName == ""){
			$("#treas_display").html("");
		}
		
		else {
			$.ajax({
				type: "POST",
				url: "treasure_search.php",
				data: {treas_search: itemName}, //Assign the value of name to treas_search
				success: function(html){
					$("#treas_display").html(html).show();
				}
				
			});
		}
	
	});
	
	
	$("#play_search").keyup(function(){
		
		var playerName = $("#play_search").val();
		
		if (playerName == ""){
			$("#play_display").html("");
		}
		
		else{
			$.ajax({
				type: "POST",
				url: "tr_player_search.php",
				data: {play_search: playerName},
				success: function(html){
					$("#play_display").html(html).show();
				}
			});
		}
	});
	
});	
//Change the Coin section and the Treasure section when a player's name is clicked.
$(document).on('click','.player', function(){
	//set the new playerName
    player = $(this).attr("name");

    var dataString = 'playerName='+ player;
    
    //Show the gold amount for the selected player
    $.ajax({
        type: "POST",
        url: "coin_amount.php",
        data: dataString,
        cache: false,
        success: function(postresult){
            $("#coins").html(postresult);}
    });
    //Show only the treasure for the selected player
	$.ajax({
		type: "POST",
		url: "treasure_table.php",
		data: dataString,
		cache: false, 
		success: function(postresult){
			$("#trtable").html(postresult);}
	});
    
   return false;
   });


//Add the gold through the Add Gold button
$(document).on('click','#addCoins_btn', function(){
	
	var gold = $("#gold").val();
	var dataString = 'gold='+ gold + '&playerName='+ player;

	$.ajax({
		type:"POST",
		url: "add_coins.php",
		data: dataString,
		cache: false,
		success: function(postresult){
			$("#coins").html(postresult);}
	});
			
	$("#addcoinfm")[0].reset();
return false;
});


//Change the Coin section and the Treasure section when a player's name is clicked.
$(document).on('click','.player', function(){
	//set the new playerName
    player = $(this).attr("name");

    var dataString = 'playerName='+ player;
    
    //Show the gold amount for the selected player
    $.ajax({
        type: "POST",
        url: "coin_amount.php",
        data: dataString,
        cache: false,
        success: function(postresult){
            $("#coins").html(postresult);}
    });
    //Show only the treasure for the selected player
	$.ajax({
		type: "POST",
		url: "treasure_table.php",
		data: dataString,
		cache: false, 
		success: function(postresult){
			$("#trtable").html(postresult);}
	});
    
   return false;
   });


//Add the gold through the Add Gold button
$(document).on('click','#addCoins_btn', function(){
	
	var gold = $("#gold").val();
	var dataString = 'gold='+ gold + '&playerName='+ player;

	$.ajax({
		type:"POST",
		url: "add_coins.php",
		data: dataString,
		cache: false,
		success: function(postresult){
			$("#coins").html(postresult);}
	});
			
	$("#addcoinfm")[0].reset();
return false;
});

	
//Change the Coin section and the Treasure section when a player's name is clicked.
$(document).on('click','.player', function(){
	//set the new playerName
    player = $(this).attr("name");

    var dataString = 'playerName='+ player;
    
    //Show the gold amount for the selected player
    $.ajax({
        type: "POST",
        url: "coin_amount.php",
        data: dataString,
        cache: false,
        success: function(postresult){
            $("#coins").html(postresult);}
    });
    //Show only the treasure for the selected player
	$.ajax({
		type: "POST",
		url: "treasure_table.php",
		data: dataString,
		cache: false, 
		success: function(postresult){
			$("#trtable").html(postresult);}
	});
    
   return false;
   });


//Add the gold through the Add Gold button
$(document).on('click','#addCoins_btn', function(){
	
	var gold = $("#gold").val();
	var dataString = 'gold='+ gold + '&playerName='+ player;

	$.ajax({
		type:"POST",
		url: "add_coins.php",
		data: dataString,
		cache: false,
		success: function(postresult){
			$("#coins").html(postresult);}
	});
			
	$("#addcoinfm")[0].reset();
return false;
});

//Add the new player information through the Add Player button
$(document).on('click', '#newPlayer_btn', function(){
	var pn = $("#playerName").val();
	var cn = $("#charName").val();
	var cc = $("#charClass").val();
	var cr = $("#charRace").val();
	var cl = $("#charLevel").val();
	
	var dataString = 'playerName='+ pn + '&charName='+ cn + '&charClass='+ cc + '&charRace='+ cr + '&charLvl=' + cl;
	// AJAX Code To Submit Form.
	$.ajax({
		type: "POST",
		url: "new_player.php",
		data: dataString,
		cache: false,
		success: function(postresult){
			$("#playernav").html(postresult);}
	});

	//Reset the form after submission
	$("#newplayerform")[0].reset();
	
	return false;
});


$(document).on('click', '#addTreasure_btn', function(){
	
	var item = $("#treas_search").val();
	var itemName = encodeURIComponent(item);
	var qty = $("#numofitems").val();
	var tr_play = $("#play_search").val();
	var broken = $("input[id='treasbrok']").is(':checked');
	
	var dataString = "qty="+qty+"&itemName=" + itemName +"&tr_play=" + tr_play+"&broken="+broken+"&playerName="+player;
	
	$.ajax({
		method: "POST",
		url: "add_treasure.php",
		data: dataString,
		cache: false,
		success: function(postresult){
			$("#trtable").html(postresult);}
	});
	$("#addtreasureform")[0].reset();
	
	return false;
});

function fill(div_name, cl_name, value){
	$(cl_name).val(value);

	$(div_name).hide();
}



function deleteRow(x){
    var xhttp = new XMLHttpRequest();
    var item=document.getElementById("trtable").rows[x].cells[1].innerHTML;
    var playselect=document.getElementById("player"+x);
	var player=playselect.options[playselect.selectedIndex].value;
    console.log(item, player);
    var conVal = confirm("Are you sure you want to delete this row?");
    	if(conVal == true){
    		document.getElementById("trtable").deleteRow(x);
    		xhttp.open("POST", "delete_treasure.php", true);
		    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    xhttp.send("itemName=" + item +"&playerName=" + player);
		    document.getElementById("addtreasureform").reset();
    	}
    	else{
    		return false;
    	}
    }


function changePlayer(x){
	var xhttp = new XMLHttpRequest();
	
	var id=document.getElementById("trtable").rows[x].cells[0].innerHTML;
	var item=document.getElementById("trtable").rows[x].cells[1].innerHTML;
	var qty=document.getElementById("trtable").rows[x].cells[2].innerHTML;
	var playselect=document.getElementById("player"+x);
	var player=playselect.options[playselect.selectedIndex].value;
	var broken=document.getElementById("trtable").rows[x].cells[5].innerHTML;
	
	if(broken == ""){
		broken = 0;
	}
	
	else{ broken = 1; }
	console.log(id, item, qty, player, broken)
	if(qty > 1){
		
		var tradeqty=prompt("There are "+qty+" of "+item+".\n How many do you want to trade?");
		
		qty=qty-tradeqty;
		
		console.log(tradeqty, qty);
	}
	else{
		var tradeqty=0;
		
		console.log(tradeqty);
		
		}
	xhttp.open("POST", "trade_item.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" +id+ "&itemName=" + item +"&playerName=" + player +"&qty=" +qty+ "&tradeqty="+tradeqty+"&broken="+broken);

    location.reload();
}

