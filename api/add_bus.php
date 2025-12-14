<?php
/*
 * ADD BUS API
 * Adds a new bus to the system
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

$bus_model = $POST_data_JSON['bus_model'] ?? '';
$bus_driver_name = $POST_data_JSON['bus_driver_name'] ?? '';
$bus_capacity = (int)($POST_data_JSON['bus_capacity'] ?? 0);

if (empty($bus_model) || empty($bus_driver_name) || $bus_capacity <= 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'Missing or invalid inputs']));
}

// Escape inputs
$bus_model = $conn->real_escape_string($bus_model);
$bus_driver_name = $conn->real_escape_string($bus_driver_name);

$sql = "INSERT INTO bus (bus_driver_name, bus_model, bus_capacity, trip_status, student_list) 
        VALUES ('$bus_driver_name', '$bus_model', $bus_capacity, 0, '[]')";

if ($conn->query($sql) === TRUE) {
    $bus_id = $conn->insert_id;
    $conn->close();
    echo json_encode(['status' => 1, 'message' => 'Bus added successfully', 'bus_id' => $bus_id]);
} else {
    $error = $conn->error;
    $conn->close();
    echo json_encode(['status' => 0, 'error' => 'Failed to add bus: ' . $error]);
}
?>