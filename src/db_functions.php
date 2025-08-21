<?php
$csvMimes =     $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

 

function makeDb($con, $db){
    //creates the main database if it is not already created
 
    $db_select = mysqli_select_db($con, $db);
    $db_create = "CREATE DATABASE ".$db; //create database
    
    if(!$db_select) {
        
        /*database could not be selected or is not created so we'll go ahead
         * and create one and throw an error if we can't*/

        if (!mysqli_query($con, $db_create)){
            echo "<script>alert('Error creating database')</script>";
            exit(1);
        }
        else {
            echo "Database created successfully. \n";
            
        }
        
      }
    else{
        echo "<p>Database selected!</p>";
    }
    
    
}

/*===== CREATE THE TABLES ============*/

function createTableSQL($tabName, $columns){
    
    /*CREATES THE SQL Statement for Table Creation*/
    
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
    return $sql;
}
function createTable($db_con, $tabName, $sql){
    
    /*Creates the a table. The table name and sql statement variables are set 
    outside the function.*/
    $check_sql = "SHOW TABLES LIKE '".$tabName."'";
    $result = mysqli_query($db_con, $check_sql);

    if (mysqli_num_rows($result) == 0){
        //table does not exist. Attempt to create table
        if (!mysqli_query($db_con, $sql)) {
            echo "<script>alert('Error creating the ".$tabName." table: ".mysqli_error($db_con)."')</script>";
            exit(1);
        }
        else{
            echo "<p>".$tabName." table created successfully!\n</p>";
        }
    } else {
        echo "<p>".$tabName." table exists!\n</p>";
    }
    return;
}

/*CREATE THE TABLES*/

function playerTable($db_con){
    //Create the player table. The table is empty until the user adds the data.
    
    //Check if the Players Table exists and create it if it does not.
    
    $tabName = "Players";
    
    $columns = array(
	"id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
	"playerName VARCHAR (30) NOT NULL",
	"charName VARCHAR (30)",
	"class VARCHAR (30)",
	"race VARCHAR (30)",
	"level INT(2)");
    
     $sql = createTableSQL($tabName, $columns);
     createTable($db_con, $tabName, $sql);
     
     return;
}

function ammoTable($db_con){
    
    /* Sets the variables for the Ammunition Table*/
    
    $tabName = "Ammo";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
		"value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function animalsTable($db_con){
   /*sets the variables for the Animals tables*/
    
    $tabName = "Animals";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function armorTable($db_con){
    /*sets the variables for the Armor tables*/
    
    $tabName = "Armor";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)",
        "details VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function artifactTable($db_con){
    /*sets the variables for the Artifact tables*/
    
    $tabName = "Artifact";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function gearTable($db_con){
    
    /*sets the variables for the Gear tables*/
    
    $tabName = "Gear";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function potionsTable($db_con){
    
    /*sets the variables for the Oils and Potions tables*/
    
    $tabName = "Potions";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function magicItemsTable($db_con){
    
    /*sets the variables for the Magical Items tables*/
    
    $tabName = "MagicItems";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function weaponsTable($db_con){
    /*sets the variables for the Weapons tables*/
    
    $tabName = "Weapons";
    $columns = array("id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)",
        "details VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
    
    return;
}

function equipTable($db_con){
    /*Creates the Equipment table which combines all the other tables into one large dataset*/
    
    $sql = "CREATE TABLE Equipment AS
    SELECT itemName, value, type from Ammo
    UNION
    SELECT itemName, value, type from Animals
    UNION
    SELECT itemName, value, type from Armor
    UNION
    SELECT itemName, value, type from Artifact
    UNION
    SELECT itemName, value, type from Gear
    UNION
    SELECT itemName, value, type from MagicItems
    UNION
    SELECT itemName, value, type from Potions
    UNION
    SELECT itemName, value, type from Weapons";
    
    createTable($db_con, "Equipment", $sql);
    return;
}

function coinsTable($db_con){
    /* Creates the Table which holds the amount of Gold separated by player*/
    
    $sql = "CREATE TABLE Coins 
    (playerName VARCHAR(30) NOT NULL,
    gold FLOAT(10,2))";
    
    createTable($db_con, "Coins", $sql);
    return;
}

function treasureTable($db_con){
    /*Creates the Treasure table which is separated by player*/
    
    $sql = "CREATE TABLE Treasure
    (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    qty INT,
    itemName VARCHAR(100) NOT NULL,
    value FLOAT(10,2),
    playerName VARCHAR(30),
    broken BOOLEAN DEFAULT 0,
    sold BOOLEAN DEFAULT 0)";
    
    createTable($db_con, "Treasure", $sql);
    return;
    
}

/* END TABLE CREATION */

/* =========== ADD DATA FILES TO DATABASE FROM CVS FILES ==============*/
function addData1($db_con, $tabName, $file){
/*Adds data to the tables that do not have a details column*/
  
    //Adds the data to tables with the columns itemName, value, weight, and type
    $selectSQL = "SELECT 1 FROM ".$tabName." LIMIT 1";
    $result = mysqli_query($db_con, $selectSQL);
    $row_cnt = mysqli_num_rows($result);
    
    if ($row_cnt !== 0){
        //Table is Empty
        echo "<p>".$tabName." is not empty</p>";
    }
    
    else{
        $row = 0;
        
        if (!empty($file)){
            $openFile = fopen($file, "r");
            
        
            while (($column = fgetcsv($openFile, 10000, "\t"))!== FALSE){
                
                $row++;
                if($row == 1) continue;
                
                $sqlInsert = "INSERT into ".$tabName. "(itemName, value, weight, type) VALUES ('". $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3]. "')";
                
                if(!mysqli_query($db_con, $sqlInsert)){
                
                    echo "<p> Error importing data into ".$tabName."</p>";
                }
            }
           fclose($openFile);
        }
    }
    return;
  
}

function addData2($db_con, $tabName, $file){
    /*Adds data to the tables which includes a details column*/
    
    $selectSQL = "SELECT 1 FROM ".$tabName." LIMIT 1";
    $result = mysqli_query($db_con, $selectSQL);
    $row_cnt = mysqli_num_rows($result);
    
    if ($row_cnt !== 0){
        
        echo "<p>".$tabName." is not empty</p>";
    }
    else{
        $row = 0;
        
        if (!empty($file)){
            $openFile = fopen($file, "r");
            
            
            while (($column = fgetcsv($openFile, 10000, "\t"))!== FALSE){
                
                $row++;
                if($row == 1) continue;
                
                $sqlInsert = "INSERT into ".$tabName. "(itemName, value, weight, type, details) VALUES ('". $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3]. "','".$column[4]."')";
                
                if(!mysqli_query($db_con, $sqlInsert)){
                    
                    echo "<p> Error importing data into ".$tabName."</p>";
                }
            }
            fclose($openFile);
        }
    }
    return;
    
}


/*===== ADD DATA FROM USER INPUT ===============*/

function addPlayerData($db_con, $playerName, $charName, $charClass, $charRace, $charLvl){
    /*Adds data to the Player Table from the Add Player form*/

    // Check if the player exists
    $stmt = $db_con->prepare("SELECT 1 FROM Players WHERE playerName = ?");
    $stmt->bind_param("s", $playerName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt->close();

        // Player does not exist, insert new record
        $stmt = $db_con->prepare("INSERT INTO Players (playerName, charName, class, race, level) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $playerName, $charName, $charClass, $charRace, $charLvl);

        if (!$stmt->execute()) {
            error_log("Error inserting player data: " . $stmt->error);
        }
    }
    $stmt->close();
    return;
}

function addPlayertoCoins($db_con, $playerName){
    
    /*Adds Player to the Coins table from the Add Player form*/
    
    $selectSql = "SELECT * FROM Coins WHERE playerName = '".$playerName. "'";
    $result = mysqli_query($db_con, $selectSql);
    $row_cnt = mysqli_num_rows($result);
    
    if (!($row_cnt !== 0)){
        
        $insertPlayerSql = "INSERT INTO Coins (playerName, gold) VALUES ('".$playerName."', 0)";
        
        if (!(mysqli_query($db_con, $insertPlayerSql))){
            echo "Error. Could not add records.\n";
        }
    }
    return;
}


function addTreasure($db_con, $qty, $itemName, $playerName, $broken){
    /*Adds data to the Treasure Table from the Add Treasure form*/
    
    // 1. Get the base value of the item from the Equipment table
    $val = 0;
    // Using prepared statements to prevent SQL injection
    $stmt = $db_con->prepare("SELECT value FROM Equipment WHERE itemName=? LIMIT 1");
    if ($stmt === false) {
        error_log("Prepare failed: " . $db_con->error);
        return;
    }
    $stmt->bind_param("s", $itemName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $val = $row['value'];
    }
    $stmt->close();

    // 2. Check if the player already has this item
    $old_qty = 0;
    $stmt = $db_con->prepare("SELECT qty FROM Treasure WHERE itemName = ? AND playerName = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . $db_con->error);
        return;
    }
    $stmt->bind_param("ss", $itemName, $playerName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $old_qty = (int)$row['qty'];
    }
    $stmt->close();

    // 3. If they do, update the quantity. If not, insert a new record.
    if ($old_qty > 0){
        $newqty = $old_qty + $qty;
        $newval = $val * $newqty;
        
        $stmt = $db_con->prepare("UPDATE Treasure SET qty=?, value=? WHERE itemName = ? AND playerName = ?");
        // Assuming qty is integer, value is double, itemName is string, playerName is string
        $stmt->bind_param("idss", $newqty, $newval, $itemName, $playerName);
        if (!$stmt->execute()) {
            // It's better to log errors than echo them, especially for AJAX calls.
            error_log("Error updating treasure: " . $stmt->error);
        }
        $stmt->close();
    }
    else {
        $newval = $val * $qty;
                
        $stmt = $db_con->prepare("INSERT INTO Treasure (qty, itemName, value, playerName, broken) VALUES (?, ?, ?, ?, ?)");
        // Assuming qty is int, itemName string, value double, playerName string, broken int(0/1)
        $stmt->bind_param("isdsi", $qty, $itemName, $newval, $playerName, $broken);
       
        if (!$stmt->execute()){
            error_log("Error inserting treasure: " . $stmt->error);
        }
        $stmt->close();
    }

return;
}

/*============ End User Input Functions =============== */

function selectData($db_con, $column, $table, $condition, $key){
    /*Function to select data from mysql table and display it on page.
     * $column = the column you want to display
     * $table = the table you want to choose from
     * $condition = the column you for the conditional check
     * $key = the condition you want to check for
     */
    
    if(empty($condition)){
        $sql = "SELECT ".$column." FROM ".$table;
    }
    
    else {
        $sql = "SELECT ".$column." FROM ".$table." WHERE ".$condition. " = '".$key. "'";
    }
    
    $query= mysqli_query($db_con, $sql) or die("Cannot connect to database");
    
    return $query;
    
}

/*function searchDatabase($db_con, $sql, $column){
    /*Function for the Typeahead portion of Add Treasure Form */
    
   /* $query=mysqli_query($db_con, $sql) or die("Cannot connect to database");
    
    while($row=mysqli_fetch_assoc($query))
    {
        $array[] = $row[$column];
    }
    echo json_encode($array);
    
}*/

?>
