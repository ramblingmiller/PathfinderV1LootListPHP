<?php

// Set headers for JSON response
header('Content-Type: application/json');

// Include necessary files
require_once __DIR__ . '/../dbconf.php';
require_once __DIR__ . '/../Model/Player.php';

// Enable mysqli exceptions for robust error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$response = ['status' => 'error', 'message' => 'Invalid request.'];
$db_con = null;

try {
    // Establish database connection
    $db_con = new mysqli($host, $user, $pass, $db);
    $db_con->set_charset('utf8mb4');

    // Instantiate the model
    $playerModel = new Player($db_con);

    // Determine the action from the request
    $action = $_REQUEST['action'] ?? '';

    // Handle the action
    switch ($action) {
        case 'getPlayers':
            $players = $playerModel->getPlayers();
            $response = ['status' => 'success', 'players' => $players];
            break;

        case 'addPlayer':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $playerName = trim($_POST['playerName'] ?? '');

                if (empty($playerName)) {
                    http_response_code(400); // Bad Request
                    $response['message'] = 'Player Name is required.';
                } else {
                    // The model handles NULL values for optional fields correctly
                    $charName = !empty($_POST['charName']) ? trim($_POST['charName']) : null;
                    $charClass = !empty($_POST['charClass']) ? trim($_POST['charClass']) : null;
                    $charRace = !empty($_POST['charRace']) ? trim($_POST['charRace']) : null;
                    $charLvl = !empty($_POST['charLvl']) ? (int)$_POST['charLvl'] : null;

                    // The addPlayer method in the model handles duplicates gracefully.
                    // It doesn't return a status, so we assume success.
                    $playerModel->addPlayer($playerName, $charName, $charClass, $charRace, $charLvl);
                    $response = ['status' => 'success', 'message' => 'Player added successfully.'];
                }
            } else {
                http_response_code(405); // Method Not Allowed
                $response['message'] = 'POST method required for this action.';
            }
            break;

        default:
            http_response_code(400); // Bad Request
            $response['message'] = 'Unknown or unspecified action.';
            break;
    }

} catch (mysqli_sql_exception $e) {
    error_log("Database error in PlayerController.php: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    $response['message'] = 'A database error occurred. Please check the logs.';
} finally {
    if ($db_con) {
        $db_con->close();
    }
    // Echo the final JSON response
    echo json_encode($response);
}

