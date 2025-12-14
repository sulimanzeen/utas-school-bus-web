<?php
/*
 * GET DRIVER DASHBOARD API
 * Returns driver's bus info, students, and current trip status
 */
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/Config.php';

// Check if driver is logged in
if (empty($_SESSION['LoggedIN']) || empty($_SESSION['UserTYPE']) || $_SESSION['UserTYPE'] !== 'driver') {
    http_response_code(401);
    die(json_encode(['status' => 0, 'error' => 'Unauthorized']));
}

$username = $_SESSION['LoggedIN'];

$c = new DBConfig();
$mysqli = new mysqli($c->servername, $c->username, $c->password, $c->database);

if ($mysqli->connect_error) {
    http_response_code(500);
    die(json_encode(['status' => 0, 'error' => 'Database connection failed']));
}

// Get driver user info
$stmt = $mysqli->prepare("SELECT ID, username, bus_id FROM users WHERE username = ? AND usertype = 'driver' LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $mysqli->close();
    http_response_code(404);
    die(json_encode(['status' => 0, 'error' => 'Driver not found']));
}

$user = $result->fetch_assoc();
$stmt->close();

$driver_id = (int)$user['ID'];
$bus_id = isset($user['bus_id']) ? (int)$user['bus_id'] : 0;

if ($bus_id <= 0) {
    $mysqli->close();
    die(json_encode([
        'status' => 1,
        'driver_id' => $driver_id,
        'username' => $user['username'],
        'bus_id' => null,
        'bus' => null,
        'students' => [],
        'students_onboard' => [],
        'trip_status' => 0
    ]));
}

// Get bus information
$stmt = $mysqli->prepare("SELECT bus_id, bus_driver_name, bus_model, bus_capacity, trip_status, student_list FROM bus WHERE bus_id = ?");
$stmt->bind_param('i', $bus_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $mysqli->close();
    http_response_code(404);
    die(json_encode(['status' => 0, 'error' => 'Bus not found']));
}

$bus = $result->fetch_assoc();
$stmt->close();

// Parse student_list JSON to get students currently on bus
$students_onboard_rfids = [];
if (!empty($bus['student_list'])) {
    $student_list = json_decode($bus['student_list'], true);
    if (is_array($student_list)) {
        $students_onboard_rfids = $student_list;
    }
}

// Get all students assigned to this bus
$stmt = $mysqli->prepare("SELECT student_id, student_name, student_rfid, parent_id FROM student WHERE student_bus_id = ? ORDER BY student_name");
$stmt->bind_param('i', $bus_id);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
$students_onboard = [];

while ($row = $result->fetch_assoc()) {
    $is_onboard = in_array($row['student_rfid'], $students_onboard_rfids);
    
    $student = [
        'student_id' => (int)$row['student_id'],
        'student_name' => $row['student_name'],
        'student_rfid' => $row['student_rfid'],
        'parent_id' => (int)$row['parent_id'],
        'is_onboard' => $is_onboard
    ];
    
    $students[] = $student;
    
    if ($is_onboard) {
        $students_onboard[] = $student;
    }
}

$stmt->close();

// Get today's attendance count (for statistics)
$stmt = $mysqli->prepare("SELECT COUNT(DISTINCT student_id) as checkins_today FROM attendance WHERE bus_id = ? AND DATE(`timestamp`) = CURDATE()");
$stmt->bind_param('i', $bus_id);
$stmt->execute();
$result = $stmt->get_result();
$attendance_stats = $result->fetch_assoc();
$stmt->close();

$mysqli->close();

// Return all data
echo json_encode([
    'status' => 1,
    'driver_id' => $driver_id,
    'username' => $user['username'],
    'bus_id' => (int)$bus['bus_id'],
    'bus' => [
        'bus_id' => (int)$bus['bus_id'],
        'bus_driver_name' => $bus['bus_driver_name'],
        'bus_model' => $bus['bus_model'],
        'bus_capacity' => (int)$bus['bus_capacity'],
        'trip_status' => (int)$bus['trip_status']
    ],
    'students' => $students,
    'students_onboard' => $students_onboard,
    'students_onboard_count' => count($students_onboard),
    'trip_status' => (int)$bus['trip_status'],
    'checkins_today' => (int)$attendance_stats['checkins_today']
]);
?>