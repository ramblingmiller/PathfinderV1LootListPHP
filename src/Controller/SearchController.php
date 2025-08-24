<?php

/**
 * Search Controller
 *
 * This controller replaces the old treasure_search.php and tr_player_search.php scripts.
 * It handles live search AJAX requests from the front-end and returns HTML snippets.
 */

// To accommodate a new, more standard directory structure, I'm assuming `dbconf.php`
// has been moved to a `config` directory at the project root.
require_once __DIR__ . '/../../config/dbconf.php';
require_once __DIR__ . '/../Model/Player.php';
require_once __DIR__ . '/../Model/Search.php';

/**
 * Establishes and returns a database connection.
 *
 * @return mysqli|null The database connection object or null on failure.
 */
function getDbConnection(): ?mysqli
{
    // These variables ($host, $user, $pass, $db) are expected to be in dbconf.php
    global $host, $user, $pass, $db;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $db_con = new mysqli($host, $user, $pass, $db);
        $db_con->set_charset('utf8mb4');
        return $db_con;
    } catch (mysqli_sql_exception $e) {
        error_log("Database connection error in SearchController.php: " . $e->getMessage());
        // For a live search, it's best not to output an error to the client.
        return null;
    }
}

/**
 * Renders a search suggestion div using data attributes for improved security and maintainability.
 *
 * @param string $displayText The text to display to the user.
 * @param array  $dataAttributes An associative array of data attributes to add to the div.
 */
function renderSuggestion(string $displayText, array $dataAttributes): void
{
    $dataAttrString = '';
    foreach ($dataAttributes as $key => $value) {
        // Prepending 'data-' to the key is standard for data attributes.
        $dataAttrString .= ' data-' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
        $dataAttrString .= '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
    }

    $escapedDisplayText = htmlspecialchars($displayText, ENT_QUOTES, 'UTF-8');

    // Note: The frontend JavaScript 'fill' function will need to be updated to read from these data attributes.
    echo "<div class='search-suggestion'{$dataAttrString}>{$escapedDisplayText}</div>";
}

/**
 * Handles treasure search requests.
 *
 * @param mysqli $db_con The database connection object.
 */
function handleTreasureSearch(mysqli $db_con): void
{
    $query = trim($_POST['treas_search'] ?? '');
    if (empty($query)) {
        return;
    }

    $searchModel = new Search($db_con);
    $items = $searchModel->searchEquipment($query);

    foreach ($items as $item) {
        renderSuggestion($item['itemName'], [
            'fill-target' => '#treas_display',
            'search-box' => '#treas_search',
            'name' => $item['itemName'],
            'value' => (float)$item['value'],
        ]);
    }
}

/**
 * Handles player search requests.
 *
 * @param mysqli $db_con The database connection object.
 */
function handlePlayerSearch(mysqli $db_con): void
{
    $query = trim($_POST['play_search'] ?? '');
    if (empty($query)) {
        return;
    }

    $playerModel = new Player($db_con);
    $players = $playerModel->searchByName($query);

    foreach ($players as $player) {
        renderSuggestion($player['playerName'], [
            'fill-target' => '#play_display',
            'search-box' => '#play_search',
            'name' => $player['playerName'],
        ]);
    }
}

// --- Main execution logic ---

$db_con = getDbConnection();

if ($db_con) {
    try {
        // Route the request based on the POST variable.
        if (isset($_POST['treas_search'])) {
            handleTreasureSearch($db_con);
        } elseif (isset($_POST['play_search'])) {
            handlePlayerSearch($db_con);
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Database query error in SearchController.php: " . $e->getMessage());
        // Silently fail for the user on an AJAX search.
    } finally {
        $db_con->close();
    }
}
