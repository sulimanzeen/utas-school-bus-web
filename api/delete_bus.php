<?php
/*
 * DELETE BUS API
 * Deletes a bus from the system
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

if ($bus_id <= 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'Invalid bus ID']));
}

// Check if there are students assigned to this bus
$check_sql = "SELECT COUNT(*) as student_count FROM student WHERE student_bus_id = $bus_id";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();

if ($row['student_count'] > 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'Cannot delete bus. There are ' . $row['student_count'] . ' students assigned to this bus. Please reassign them first.']));
}

// Delete the bus
$sql = "DELETE FROM bus WHERE bus_id = $bus_id";

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        $conn->close();
        echo json_encode(['status' => 1, 'message' => 'Bus deleted successfully']);
    } else {
        $conn->close();
        echo json_encode(['status' => 0, 'error' => 'Bus not found']);
    }
} else {
    $error = $conn->error;
    $conn->close();
    echo json_encode(['status' => 0, 'error' => 'Failed to delete bus: ' . $error]);
}
?>