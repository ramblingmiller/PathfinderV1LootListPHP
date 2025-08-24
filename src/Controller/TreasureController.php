<?php

// Set headers for JSON response
header('Content-Type: application/json');

// Include necessary files. Assumes dbconf.php is in the src/ directory.
require_once __DIR__ . '/../dbconf.php';
require_once __DIR__ . '/../Model/Treasure.php';

// Enable mysqli exceptions for robust error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$response = ['status' => 'error', 'message' => 'Invalid request.'];
$db_con = null;

try {
    // Establish database connection
    $db_con = new mysqli($host, $user, $pass, $db);
    $db_con->set_charset('utf8mb4');

    // Instantiate the model
    $treasureModel = new Treasure($db_con);

    // Determine the action from the request
    $action = $_REQUEST['action'] ?? '';

    // Handle the action
    switch ($action) {
        case 'getTreasure':
            $playerName = $_GET['playerName'] ?? 'Party';
            $treasure = $treasureModel->getByPlayerName($playerName);
            $response = ['status' => 'success', 'treasure' => $treasure];
            break;

        case 'addTreasure':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $qty = (int)($_POST['qty'] ?? 1);
                $itemName = $_POST['itemName'] ?? '';
                $value = (float)($_POST['value'] ?? 0.0);
                $playerName = $_POST['playerName'] ?? 'Party';

                if (!empty($itemName)) {
                    if ($treasureModel->add($qty, $itemName, $value, $playerName)) {
                        $response = ['status' => 'success', 'message' => 'Treasure added successfully.'];
                    } else {
                        $response['message'] = 'Failed to add treasure item.';
                    }
                } else {
                    $response['message'] = 'Item name is required.';
                }
            }
            break;

        case 'updateTreasureStatus':
             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = (int)($_POST['id'] ?? 0);
                $sold = isset($_POST['sold']) ? (bool)$_POST['sold'] : false;
                $broken = isset($_POST['broken']) ? (bool)$_POST['broken'] : false;

                if ($id > 0) {
                     if ($treasureModel->updateStatus($id, $sold, $broken)) {
                        $response = ['status' => 'success', 'message' => 'Treasure status updated.'];
                    } else {
                        $response['message'] = 'Failed to update treasure status.';
                    }
                } else {
                    $response['message'] = 'A valid treasure ID is required.';
                }
             }
            break;

        default:
            $response['message'] = 'Unknown or unspecified action.';
            break;
    }

} catch (mysqli_sql_exception $e) {
    error_log("Database error in TreasureController.php: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    $response['message'] = 'A database error occurred. Please check the logs.';
} finally {
    if ($db_con) {
        $db_con->close();
    }
    // Echo the final JSON response
    echo json_encode($response);
}

