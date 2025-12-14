<?php
/*
 * GET STUDENT STATS API
 * Returns statistics for student management page
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

// Get total students
$sql_total = "SELECT COUNT(*) as total FROM student";
$result_total = $conn->query($sql_total);
$total = $result_total->fetch_assoc()['total'];

// Get assigned students (students with a bus)
$sql_assigned = "SELECT COUNT(*) as total FROM student WHERE student_bus_id IS NOT NULL AND student_bus_id > 0";
$result_assigned = $conn->query($sql_assigned);
$assigned = $result_assigned->fetch_assoc()['total'];

// Get unassigned students
$sql_unassigned = "SELECT COUNT(*) as total FROM student WHERE student_bus_id IS NULL OR student_bus_id = 0";
$result_unassigned = $conn->query($sql_unassigned);
$unassigned = $result_unassigned->fetch_assoc()['total'];

// Get total buses
$sql_buses = "SELECT COUNT(*) as total FROM bus";
$result_buses = $conn->query($sql_buses);
$total_buses = $result_buses->fetch_assoc()['total'];

$conn->close();

echo json_encode([
    'total' => (int)$total,
    'assigned' => (int)$assigned,
    'unassigned' => (int)$unassigned,
    'total_buses' => (int)$total_buses
]);
?>