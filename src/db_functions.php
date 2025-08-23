<?php
/**
 * This function is intended for initial, one-time database setup from a CLI script.
 * It is largely redundant if using the db_config.php script which handles this logic.
 *
 * @param mysqli $con The database connection.
 * @param string $db The name of the database to create.
 * @return void
 */
function makeDb($con, $db){
    // Creates the main database if it is not already created.
 
    if (!mysqli_select_db($con, $db)) {
        // Database could not be selected, so we'll try to create it.
        // Database names cannot be parameterized, so ensure $db is from a trusted source (e.g., config file).
        $db_create = "CREATE DATABASE `" . mysqli_real_escape_string($con, $db) . "`";
        
        if (!mysqli_query($con, $db_create)){
            error_log('Error creating database ' . $db . ': ' . mysqli_error($con));
            exit(1); // Exit is appropriate for a setup script.
        } else {
            echo "Database created successfully. \n";
            mysqli_select_db($con, $db);
        }
    } else {
        echo "<p>Database selected!</p>";
    }
}

/*===== CREATE THE TABLES ============*/

/**
 * Creates the SQL statement for table creation.
 *
 * @param string $tabName The name of the table.
 * @param array $columns An array of column definitions.
 * @return string The generated SQL CREATE TABLE statement.
 */
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
/**
 * Creates a table in the database if it does not already exist.
 * Intended for use in setup scripts.
 *
 * @param mysqli $db_con The database connection.
 * @param string $tabName The name of the table to create.
 * @param string $sql The full CREATE TABLE SQL statement.
 * @return bool True on success, false on failure.
 */
function createTable($db_con, $tabName, $sql){
    
    // Table names are hardcoded in this app, but escaping is good practice.
    $escapedTabName = mysqli_real_escape_string($db_con, $tabName);
    $check_sql = "SHOW TABLES LIKE '" . $escapedTabName . "'";
    $result = mysqli_query($db_con, $check_sql);

    if ($result === false) {
        error_log("Failed to check for table " . $tabName . ": " . mysqli_error($db_con));
        exit(1); // Exit for setup scripts
    }

    if (mysqli_num_rows($result) == 0){
        //table does not exist. Attempt to create table
        if (!mysqli_query($db_con, $sql)) {
            error_log("Error creating the " . $tabName . " table: " . mysqli_error($db_con));
            exit(1); // Exit for setup scripts
        }
        else{
            echo "<p>".$tabName." table created successfully!\n</p>";
        }
    } else {
        echo "<p>".$tabName." table exists!\n</p>";
    }
    return true;
}

/* The following functions define schemas and create tables. They are well-structured for the setup script. */

function playerTable($db_con){
    $tabName = "Players";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "playerName VARCHAR (30) NOT NULL",
        "charName VARCHAR (30)",
        "class VARCHAR (30)",
        "race VARCHAR (30)",
        "level INT(2)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function ammoTable($db_con){
    $tabName = "Ammo";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function animalsTable($db_con){
    $tabName = "Animals";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function armorTable($db_con){
    $tabName = "Armor";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)",
        "details VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function artifactTable($db_con){
    $tabName = "Artifact";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)");
    
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function gearTable($db_con){
    $tabName = "Gear";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function potionsTable($db_con){
    $tabName = "Potions";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function magicItemsTable($db_con){
    $tabName = "MagicItems";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function weaponsTable($db_con){
    $tabName = "Weapons";
    $columns = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "itemName VARCHAR (100) NOT NULL",
        "value FLOAT(10,2)",
        "weight FLOAT(8,2)",
        "type VARCHAR(20)",
        "details VARCHAR(20)"
    ];
    $sql = createTableSQL($tabName, $columns);
    createTable($db_con, $tabName, $sql);
}

function equipTable($db_con){
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
}

function coinsTable($db_con){
    $sql = "CREATE TABLE Coins 
    (playerName VARCHAR(30) NOT NULL,
    gold FLOAT(10,2),
    PRIMARY KEY (playerName))"; // Added primary key for performance and integrity
    
    createTable($db_con, "Coins", $sql);
}

function treasureTable($db_con){
    $sql = "CREATE TABLE Treasure
    (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    qty INT,
    itemName VARCHAR(100) NOT NULL,
    value FLOAT(10,2),
    playerName VARCHAR(30),
    broken BOOLEAN DEFAULT 0,
    sold BOOLEAN DEFAULT 0)";
    
    createTable($db_con, "Treasure", $sql);
}

/* END TABLE CREATION */

/* =========== ADD DATA FILES TO DATABASE FROM CVS FILES ==============*/
/**
 * Adds data from a TSV (Tab-Separated Values) file to a table if the table is empty.
 * Uses prepared statements to prevent SQL injection.
 *
 * @param mysqli $db_con The database connection.
 * @param string $tabName The name of the table to insert into.
 * @param string $file The path to the TSV file.
 * @param array $columns The list of column names in the table corresponding to file columns.
 * @return void
 */
function addDataFromCsv($db_con, $tabName, $file, $columns) {
    $escapedTabName = mysqli_real_escape_string($db_con, $tabName);
    $result = mysqli_query($db_con, "SELECT 1 FROM `{$escapedTabName}` LIMIT 1");

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<p>Table `{$tabName}` is not empty. Skipping data import.</p>";
        return;
    }

    if (!file_exists($file) || !is_readable($file)) {
        error_log("Data file does not exist or is not readable: {$file}");
        return;
    }

    $handle = fopen($file, "r");
    if (!$handle) {
        error_log("Could not open data file: {$file}");
        return;
    }

    $columnNames = implode(', ', array_map(fn($c) => "`$c`", $columns));
    $placeholders = implode(', ', array_fill(0, count($columns), '?'));
    $sqlInsert = "INSERT INTO `{$escapedTabName}` ({$columnNames}) VALUES ({$placeholders})";

    $stmt = $db_con->prepare($sqlInsert);
    if (!$stmt) {
        error_log("Error preparing statement for `{$tabName}`: " . $db_con->error);
        fclose($handle);
        return;
    }

    // Assuming all columns from CSV are strings for simplicity in binding.
    // MySQL will cast them to the correct column types.
    $types = str_repeat('s', count($columns));
    
    // Skip header row
    fgetcsv($handle, 10000, "\t");

    while (($data = fgetcsv($handle, 10000, "\t")) !== false) {
        if (count($data) !== count($columns)) {
            error_log("Row in {$file} has incorrect number of columns. Expected " . count($columns) . ", got " . count($data) . ". Skipping.");
            continue;
        }
        $stmt->bind_param($types, ...$data);
        if (!$stmt->execute()) {
            error_log("Error importing data into `{$tabName}`: " . $stmt->error);
        }
    }

    $stmt->close();
    fclose($handle);
    echo "<p>Data imported into `{$tabName}`.</p>";
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
        // Handle nulls for non-required fields
        $charName = empty($charName) ? null : $charName;
        $charClass = empty($charClass) ? null : $charClass;
        $charRace = empty($charRace) ? null : $charRace;
        $charLvl = empty($charLvl) ? null : (int)$charLvl;

        $stmt->bind_param("ssssi", $playerName, $charName, $charClass, $charRace, $charLvl);

        if (!$stmt->execute()) {
            error_log("Error inserting player data: " . $stmt->error);
        }
    }
    $stmt->close();
}

function addPlayertoCoins($db_con, $playerName){
    /*Adds a player to the Coins table if they don't already exist.*/

    // Using INSERT ... ON DUPLICATE KEY UPDATE is more efficient than SELECT then INSERT.
    // This requires a UNIQUE key or PRIMARY KEY on playerName, which was added to coinsTable().
    $stmt = $db_con->prepare("INSERT INTO Coins (playerName, gold) VALUES (?, 0) ON DUPLICATE KEY UPDATE playerName=playerName");
    if (!$stmt) {
        error_log("Prepare failed (insert coins): " . $db_con->error);
        return false;
    }
    $stmt->bind_param("s", $playerName);
    
    if (!$stmt->execute()){
        error_log("Error adding player to Coins table: " . $stmt->error);
        $stmt->close();
        return false;
    }
    $stmt->close();
    return true;
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
        $val = (float)$row['value'];
    }
    $stmt->close();

    // 2. Check if the player already has this item (and it's not broken differently)
    $old_qty = 0;
    $stmt = $db_con->prepare("SELECT qty FROM Treasure WHERE itemName = ? AND playerName = ? AND broken = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . $db_con->error);
        return;
    }
    $stmt->bind_param("ssi", $itemName, $playerName, $broken);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $old_qty = (int)$row['qty'];
    }
    $stmt->close();

    // 3. If they have an identical item (same name, same broken status), update the quantity.
    //    Otherwise, insert a new record.
    if ($old_qty > 0){
        $newqty = $old_qty + $qty;
        $newval = $val * $newqty;
        
        $stmt = $db_con->prepare("UPDATE Treasure SET qty=?, value=? WHERE itemName = ? AND playerName = ? AND broken = ?");
        $stmt->bind_param("idssi", $newqty, $newval, $itemName, $playerName, $broken);
        if (!$stmt->execute()) {
            // It's better to log errors than echo them, especially for AJAX calls.
            error_log("Error updating treasure: " . $stmt->error);
        }
        $stmt->close();
    }
    else {
        $newval = $val * $qty;
                
        $stmt = $db_con->prepare("INSERT INTO Treasure (qty, itemName, value, playerName, broken) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isdsi", $qty, $itemName, $newval, $playerName, $broken);
       
        if (!$stmt->execute()){
            error_log("Error inserting treasure: " . $stmt->error);
        }
        $stmt->close();
    }
}

/*============ End User Input Functions =============== */

/**
 * Securely selects data from a database table.
 *
 * @param mysqli $db_con The database connection.
 * @param array|string $columns The column(s) to select. Use '*' for all.
 * @param string $table The table to select from.
 * @param string|null $condition The column for the WHERE clause.
 * @param string|null $key The value for the WHERE clause.
 * @return mysqli_result|false The result object on success, or false on failure.
 */
function selectData($db_con, $columns, $table, $condition = null, $key = null){
    // A whitelist of allowed tables is crucial to prevent SQL injection on table names.
    $allowed_tables = ['Players', 'Coins', 'Treasure', 'Equipment'];
    if (!in_array($table, $allowed_tables)) {
        error_log("Disallowed table access attempt: " . $table);
        return false;
    }

    // For columns, prevent injection by removing backticks and wrapping in them.
    // A better approach is to whitelist columns per table.
    if (is_array($columns)) {
        $select_cols = implode(', ', array_map(fn($col) => "`" . str_replace("`", "", $col) . "`", $columns));
    } else {
        $select_cols = ($columns === '*') ? '*' : "`" . str_replace("`", "", $columns) . "`";
    }

    $sql = "SELECT {$select_cols} FROM `{$table}`";
    
    if (!empty($condition)) {
        // Also validate the condition column name
        $condition_col = "`" . str_replace("`", "", $condition) . "`";
        $sql .= " WHERE {$condition_col} = ?";
        
        $stmt = $db_con->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed for selectData: " . $db_con->error . " (SQL: $sql)");
            return false;
        }
        $stmt->bind_param("s", $key);
        if (!$stmt->execute()) {
            error_log("Execute failed for selectData: " . $stmt->error);
            return false;
        }
        $query = $stmt->get_result();

    } else {
        $query = mysqli_query($db_con, $sql);
    }
    
    if (!$query) {
        error_log("Database query failed: " . mysqli_error($db_con));
        return false;
    }
    
    return $query;
}
?>
