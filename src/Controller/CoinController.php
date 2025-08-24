<?php

// Set headers for JSON response
header('Content-Type: application/json');

// Include necessary files
require_once __DIR__ . '/../dbconf.php';
require_once __DIR__ . '/../Model/Coin.php';

// Enable mysqli exceptions for robust error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$response = ['status' => 'error', 'message' => 'Invalid request.'];
$db_con = null;

try {
    // Establish database connection
    $db_con = new mysqli($host, $user, $pass, $db);
    $db_con->set_charset('utf8mb4');

    // Instantiate the model
    $coinModel = new Coin($db_con);

    // Determine the action from the request
    $action = $_REQUEST['action'] ?? '';

    // Handle the action
    switch ($action) {
        case 'getGold':
            $playerName = $_GET['playerName'] ?? 'Party';
            if ($playerName === 'All') {
                $playerName = 'Party';
            }
            $gold = $coinModel->getGold($playerName);
            $response = ['status' => 'success', 'playerName' => $playerName, 'gold' => $gold];
            break;

        case 'addGold':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $playerName = $_POST['playerName'] ?? 'Party';
                if ($playerName === 'All') {
                    $playerName = 'Party';
                }
                $amount = (float)($_POST['gold'] ?? 0.0);

                if ($coinModel->addGold($playerName, $amount)) {
                    // Fetch the new total to return it
                    $newTotal = $coinModel->getGold($playerName);
                    $response = [
                        'status' => 'success',
                        'message' => 'Gold updated successfully.',
                        'playerName' => $playerName,
                        'gold' => $newTotal
                    ];
                } else {
                    http_response_code(500);
                    $response['message'] = 'Failed to update gold amount.';
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
    error_log("Database error in CoinController.php: " . $e->getMessage());
    http_response_code(500); // Internal Server Error
    $response['message'] = 'A database error occurred. Please check the logs.';
} finally {
    if ($db_con) {
        $db_con->close();
    }
    // Echo the final JSON response
    echo json_encode($response);
}

