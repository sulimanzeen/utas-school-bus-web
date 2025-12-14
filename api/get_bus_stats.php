<?php
/*
 * GET BUS STATS API
 * Returns statistics for bus management page
 */
ini_set('log_errors', 0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');
require_once "Config.php";

$DBConfig = new DbConfig();
$conn = mysqli_connect($DBConfig->servername, $DBConfig->username, $DBConfig->password, $DBConfig->database);

if (!$conn) {
    die(json_encode(['status' => 0, 'error' => 'Connection failed']));
}

// Get total buses
$sql_total = "SELECT COUNT(*) as total FROM bus";
$result_total = $conn->query($sql_total);
$total = $result_total->fetch_assoc()['total'];

// Get active buses (trip_status = 1)
$sql_active = "SELECT COUNT(*) as total FROM bus WHERE trip_status = 1";
$result_active = $conn->query($sql_active);
$active = $result_active->fetch_assoc()['total'];

// Get idle buses (trip_status = 0)
$sql_idle = "SELECT COUNT(*) as total FROM bus WHERE trip_status = 0";
$result_idle = $conn->query($sql_idle);
$idle = $result_idle->fetch_assoc()['total'];

// Get total students
$sql_students = "SELECT COUNT(*) as total FROM student";
$result_students = $conn->query($sql_students);
$total_students = $result_students->fetch_assoc()['total'];

$conn->close();

echo json_encode([
    'total' => (int)$total,
    'active' => (int)$active,
    'idle' => (int)$idle,
    'total_students' => (int)$total_students
]);
?>