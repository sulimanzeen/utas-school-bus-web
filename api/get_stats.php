<?php
/*
 * GET STATS API
 * Returns dashboard statistics
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
$sql_buses = "SELECT COUNT(*) as total FROM bus";
$result_buses = $conn->query($sql_buses);
$total_buses = $result_buses->fetch_assoc()['total'];

// Get total students
$sql_students = "SELECT COUNT(*) as total FROM student";
$result_students = $conn->query($sql_students);
$total_students = $result_students->fetch_assoc()['total'];

// Get active drivers (drivers with trip_status = 1)
$sql_drivers = "SELECT COUNT(*) as total FROM bus WHERE trip_status = 1";
$result_drivers = $conn->query($sql_drivers);
$total_drivers = $result_drivers->fetch_assoc()['total'];

// Get students tracked today
$sql_today = "SELECT COUNT(DISTINCT student_id) as total FROM attendance WHERE DATE(timestamp) = CURDATE()";
$result_today = $conn->query($sql_today);
$students_today = $result_today->fetch_assoc()['total'];

// Get alerts today (count attendance records where students boarded but haven't exited)
$sql_alerts = "SELECT COUNT(*) as total FROM (
    SELECT student_id, MAX(timestamp) as last_time, 
    (SELECT type FROM attendance a2 WHERE a2.student_id = a1.student_id ORDER BY timestamp DESC LIMIT 1) as last_type
    FROM attendance a1
    WHERE DATE(timestamp) = CURDATE()
    GROUP BY student_id
    HAVING last_type = 0
) as potential_alerts";
$result_alerts = $conn->query($sql_alerts);
$alerts_today = $result_alerts->fetch_assoc()['total'];

$conn->close();

echo json_encode([
    'total_buses' => (int)$total_buses,
    'total_students' => (int)$total_students,
    'total_drivers' => (int)$total_drivers,
    'students_today' => (int)$students_today,
    'alerts_today' => (int)$alerts_today
]);
?>