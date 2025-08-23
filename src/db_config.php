<?php
/*
 * Db_Config.php
 *
 * This script initializes the database schema and seeds it with initial data.
 * It is intended to be run from the command line, for example, when a Docker
 * container starts for the first time.
 */

echo "--- Database Configuration Started ---\n";

// Load dependencies
require_once(__DIR__.'/db_functions.php');

// --- 1. Configuration ---
// Use environment variables for database credentials.
// These are set in your docker-compose.yml file.
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

if (!$host || !$db || !$user || !$pass) {
    fwrite(STDERR, "ERROR: Database environment variables (DB_HOST, DB_NAME, DB_USER, DB_PASSWORD) are not set.\n");
    exit(1);
}

// --- 2. Database Connection & Creation ---
echo "Connecting to MySQL server at '$host'...\n";
// Connect to the MySQL server first, without selecting a specific database.
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    fwrite(STDERR, "ERROR: Failed to connect to MySQL: " . mysqli_connect_error() . "\n");
    exit(1);
}
echo "Connection successful.\n";

// Create the database if it doesn't exist.
$create_db_sql = "CREATE DATABASE IF NOT EXISTS `$db`";
if (mysqli_query($conn, $create_db_sql)) {
    echo "Database '$db' is ready.\n";
} else {
    fwrite(STDERR, "ERROR: Could not create or verify database '$db': " . mysqli_error($conn) . "\n");
    mysqli_close($conn);
    exit(1);
}

// Now, select the specific database to use for the rest of the script.
mysqli_select_db($conn, $db);
echo "Selected database '$db'.\n";


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


// --- 4. Data Seeding ---
echo "\nImporting data from CSV files...\n";
$dataDir = __DIR__ . '/data/';
$seed_files = [
    "Ammo"       => $dataDir . "ammo.csv",
    "Animals"    => $dataDir . "animals.csv",
    "Armor"      => $dataDir . "armor.csv",
    "Artifact"   => $dataDir . "artifact.csv",
    "Gear"       => $dataDir . "gear.csv",
    "MagicItems" => $dataDir . "magical.csv",
    "Potions"    => $dataDir . "oils.csv", // Note: 'oils.csv' is used for the 'Potions' table.
    "Weapons"    => $dataDir . "weapons.csv",
];

0.3
// Import data using the new consolidated and secure function
$columns_basic = ['itemName', 'value', 'weight', 'type'];
$columns_detailed = ['itemName', 'value', 'weight', 'type', 'details'];

addDataFromCsv($conn, "Ammo", $seed_files['Ammo'], $columns_basic);
addDataFromCsv($conn, "Animals", $seed_files['Animals'], $columns_basic);
addDataFromCsv($conn, "Artifact", $seed_files['Artifact'], $columns_basic);
addDataFromCsv($conn, "Gear", $seed_files['Gear'], $columns_basic);
addDataFromCsv($conn, "MagicItems", $seed_files['MagicItems'], $columns_basic);
addDataFromCsv($conn, "Potions", $seed_files['Potions'], $columns_basic);
addDataFromCsv($conn, "Armor", $seed_files['Armor'], $columns_detailed);
addDataFromCsv($conn, "Weapons", $seed_files['Weapons'], $columns_detailed);
echo "Data import finished.\n";


// --- 5. Post-Processing ---
echo "\nCreating combined Equipment table...\n";
equipTable($conn);
echo "Equipment table created.\n";

echo "Adding default 'Party' player...\n";
addPlayerData($conn, "Party", null, null, null, null);
addPlayertoCoins($conn, "Party");
echo "'Party' player added.\n";


// --- 6. Completion ---
mysqli_close($conn);
echo "\n--- Database Configuration Complete ---\n";