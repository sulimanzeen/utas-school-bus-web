<?php
/*
 * UPDATE BUS API
 * Updates an existing bus
 */
ini_set('log_errors', 0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');
require_once "Config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['status' => 0, 'error' => 'Bad Request']));
}

$DBConfig = new DbConfig();
$conn = mysqli_connect($DBConfig->servername, $DBConfig->username, $DBConfig->password, $DBConfig->database);

if (!$conn) {
    die(json_encode(['status' => 0, 'error' => 'Connection failed']));
}

$POST_data_JSON = json_decode(file_get_contents('php://input'), true);

$bus_id = (int)($POST_data_JSON['bus_id'] ?? 0);
$bus_model = $POST_data_JSON['bus_model'] ?? '';
$bus_driver_name = $POST_data_JSON['bus_driver_name'] ?? '';
$bus_capacity = (int)($POST_data_JSON['bus_capacity'] ?? 0);

if ($bus_id <= 0 || empty($bus_model) || empty($bus_driver_name) || $bus_capacity <= 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'Missing or invalid inputs']));
}

// Escape inputs
$bus_model = $conn->real_escape_string($bus_model);
$bus_driver_name = $conn->real_escape_string($bus_driver_name);

$sql = "UPDATE bus 
        SET bus_model = '$bus_model', 
            bus_driver_name = '$bus_driver_name', 
            bus_capacity = $bus_capacity 
        WHERE bus_id = $bus_id";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    echo json_encode(['status' => 1, 'message' => 'Bus updated successfully']);
} else {
    $error = $conn->error;
    $conn->close();
    echo json_encode(['status' => 0, 'error' => 'Failed to update bus: ' . $error]);
}
?>