<?php
/*
 * DELETE STUDENT API
 * Deletes a student from the system
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
$student_id = (int)($POST_data_JSON['student_id'] ?? 0);

if ($student_id <= 0) {
    $conn->close();
    die(json_encode(['status' => 0, 'error' => 'Invalid student ID']));
}

// Delete attendance records first (foreign key constraint)
$delete_attendance_sql = "DELETE FROM attendance WHERE student_id = $student_id";
$conn->query($delete_attendance_sql);

// Delete the student
$sql = "DELETE FROM student WHERE student_id = $student_id";

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        $conn->close();
        echo json_encode(['status' => 1, 'message' => 'Student deleted successfully']);
    } else {
        $conn->close();
        echo json_encode(['status' => 0, 'error' => 'Student not found']);
    }
} else {
    $error = $conn->error;
    $conn->close();
    echo json_encode(['status' => 0, 'error' => 'Failed to delete student: ' . $error]);
}
?>