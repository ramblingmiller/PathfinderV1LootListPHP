<?php
/*
 * Db_Config.php
 *
 * This script initializes the database schema and seeds it with initial data.
 * It is intended to be run from the command line, for example, when a Docker
 * container starts for the first time.
 */

/*===== DATABASE AND TABLE SETUP FUNCTIONS ============*/

/**
 * Creates the SQL statement for table creation.
 *
 * @param string $tabName The name of the table.
 * @param array $columns An array of column definitions.
 * @return string The generated SQL CREATE TABLE statement.
 */
function createTableSQL($tabName, $columns){
    $sql = 'CREATE TABLE ' .$tabName.' (';
    for ($i = 0; $i < count($columns); $i++){
        $sql .= $columns[$i];
        if($i < count($columns)-1){
            $sql .= ", ";
        } else {
            $sql .= ")";
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
    $escapedTabName = mysqli_real_escape_string($db_con, $tabName);
    $check_sql = "SHOW TABLES LIKE '" . $escapedTabName . "'";
    $result = mysqli_query($db_con, $check_sql);

    if ($result === false) {
        error_log("Failed to check for table " . $tabName . ": " . mysqli_error($db_con));
        exit(1); // Exit for setup scripts
    }

    if (mysqli_num_rows($result) == 0){
        if (!mysqli_query($db_con, $sql)) {
            error_log("Error creating the " . $tabName . " table: " . mysqli_error($db_con));
            exit(1); // Exit for setup scripts
        }
        else{
            echo $tabName." table created successfully.\n";
        }
    } else {
        echo $tabName." table exists.\n";
    }
    return true;
}

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
        "type VARCHAR(20)"];
    
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
    PRIMARY KEY (playerName))";
    
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

/**
 * Adds data from a TSV (Tab-Separated Values) file to a table if the table is empty.
 *
 * @param mysqli $db_con The database connection.
 * @param string $tabName The name of the table to insert into.
 * @param string $file The path to the TSV file.
 * @param array $columns The list of column names in the table corresponding to file columns.
 * @return void
 */
function addDataFromTsv($db_con, $tabName, $file, $columns) {
    $escapedTabName = mysqli_real_escape_string($db_con, $tabName);
    $result = mysqli_query($db_con, "SELECT 1 FROM `{$escapedTabName}` LIMIT 1");

    if ($result && mysqli_num_rows($result) > 0) {
        echo "Table `{$tabName}` is not empty. Skipping data import.\n";
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
    echo "Data imported into `{$tabName}`.\n";
}

echo "--- Database Configuration Started ---\n";

// Load dependencies

require_once(__DIR__.'/../Model/Player.php');

// --- 1. Configuration ---
// Use environment variables for database credentials, which are more secure and flexible.
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

if (!$host || !$db || !$user || !$pass) {
    fwrite(STDERR, "ERROR: Database environment variables (DB_HOST, DB_NAME, DB_USER, DB_PASSWORD) are not set.\n");
    exit(1);
}

// --- 2. Database Connection & Creation ---
// Enable error reporting for mysqli to throw exceptions on errors.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = null; // Initialize to null
try {
    echo "Connecting to MySQL server at '$host'...\n";
    // Connect to the MySQL server first, without selecting a specific database.
    $conn = mysqli_connect($host, $user, $pass);
    echo "Connection successful.\n";

    // Create the database if it doesn't exist.
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db`");
    echo "Database '$db' is ready.\n";

    // Select the database and set the charset.
    $conn->select_db($db);
    $conn->set_charset('utf8mb4');
    echo "Selected database '$db' and set charset to utf8mb4.\n";

    // --- 3. Table Creation ---
    echo "\nCreating database tables...\n";
    playerTable($conn);
    ammoTable($conn);
    animalsTable($conn);
    armorTable($conn);
    artifactTable($conn);
    gearTable($conn);
    potionsTable($conn);
    magicItemsTable($conn);
    weaponsTable($conn);
    coinsTable($conn);
    treasureTable($conn);
    echo "Table creation process finished.\n";

    // --- 4. Data Seeding (in a transaction) ---
    echo "\nImporting data from TSV files...\n";
    $dataDir = dirname(__DIR__, 2) . '/data/';
    
    $seed_config = [
        'Ammo'       => ['file' => 'ammo.csv', 'columns' => ['itemName', 'value', 'weight', 'type']],
        'Animals'    => ['file' => 'animals.csv', 'columns' => ['itemName', 'value', 'weight', 'type']],
        'Armor'      => ['file' => 'armor.csv', 'columns' => ['itemName', 'value', 'weight', 'type', 'details']],
        'Artifact'   => ['file' => 'artifact.csv', 'columns' => ['itemName', 'value', 'weight', 'type']],
        'Gear'       => ['file' => 'gear.csv', 'columns' => ['itemName', 'value', 'weight', 'type']],
        'MagicItems' => ['file' => 'magical.csv', 'columns' => ['itemName', 'value', 'weight', 'type']],
        'Potions'    => ['file' => 'oils.csv', 'columns' => ['itemName', 'value', 'weight', 'type']],
        'Weapons'    => ['file' => 'weapons.csv', 'columns' => ['itemName', 'value', 'weight', 'type', 'details']],
    ];

    $conn->begin_transaction();
    echo "Transaction started for data seeding.\n";

    foreach ($seed_config as $tableName => $config) {
        $filePath = $dataDir . $config['file'];
        addDataFromTsv($conn, $tableName, $filePath, $config['columns']);
    }

    $conn->commit();
    echo "Transaction committed. Data import finished.\n";

    // --- 5. Post-Processing ---
    echo "\nCreating combined Equipment table...\n";
    equipTable($conn);
    echo "Equipment table created.\n";

    echo "Adding default 'Party' player...\n";
    // Use the Player model to add the default player, which also handles the Coins table entry.
    $playerModel = new Player($conn);
    $playerModel->addPlayer("Party", null, null, null, null);
    echo "'Party' player added.\n";

} catch (mysqli_sql_exception $e) {
    fwrite(STDERR, "DATABASE SETUP FAILED: " . $e->getMessage() . "\n");
    if ($conn && $conn->thread_id) {
        $conn->rollback();
        echo "Transaction rolled back.\n";
    }
    exit(1);
} finally {
    if ($conn && $conn->thread_id) {
        $conn->close();
    }
}

echo "\n--- Database Configuration Complete ---\n";
