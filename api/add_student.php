<?php
/*
 * ADD STUDENT API
 * Adds a new student to the system
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

$student_name = $POST_data_JSON['student_name'] ?? '';
$student_rfid = $POST_data_JSON['student_rfid'] ?? '';
$parent_id = (int)($POST_data_JSON['parent_id'] ?? 0);
$student_bus_id = (int)($POST_data_JSON['student_bus_id'] ?? 0);

if (empty($student_name) || empty($student_rfid) || $parent_id <= 0 || $student_bus_id <= 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'Missing or invalid inputs']));
}

// Check if RFID already exists
$check_sql = "SELECT student_id FROM student WHERE student_rfid = '" . $conn->real_escape_string($student_rfid) . "'";
$check_result = $conn->query($check_sql);
if ($check_result->num_rows > 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'RFID card number already exists']));
}

// Escape inputs
$student_name = $conn->real_escape_string($student_name);
$student_rfid = $conn->real_escape_string($student_rfid);

$sql = "INSERT INTO student (parent_id, student_bus_id, student_name, student_rfid) 
        VALUES ($parent_id, $student_bus_id, '$student_name', '$student_rfid')";

if ($conn->query($sql) === TRUE) {
    $student_id = $conn->insert_id;
    $conn->close();
    echo json_encode(['status' => 1, 'message' => 'Student added successfully', 'student_id' => $student_id]);
} else {
    $error = $conn->error;
    $conn->close();
    echo json_encode(['status' => 0, 'error' => 'Failed to add student: ' . $error]);
}
?>