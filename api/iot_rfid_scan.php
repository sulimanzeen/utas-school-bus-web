<?php
/*
 * IOT RFID SCAN API
 * Called by IoT device (Arduino/ESP32/Raspberry Pi) when RFID is scanned
 * POST JSON: { "rfid": "123456789", "bus_id": 3 }
 * 
 * Authentication: Simple API key (you should add this in production)
 * For production, add: Authorization header with shared secret key
 */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/Config.php';

// Allow CORS for IoT devices (adjust domains as needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['status' => 0, 'error' => 'Method not allowed']));
}

// Get input
$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input) || empty($input['rfid']) || empty($input['bus_id'])) {
    http_response_code(400);
    die(json_encode(['status' => 0, 'error' => 'Invalid payload - rfid and bus_id required']));
}

$rfid = trim($input['rfid']);
$bus_id = (int)$input['bus_id'];

// Optional: API key authentication (uncomment in production)
// $api_key = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
// if ($api_key !== 'YOUR_SECRET_API_KEY') {
//     http_response_code(401);
//     die(json_encode(['status' => 0, 'error' => 'Invalid API key']));
// }

$c = new DBConfig();
$mysqli = new mysqli($c->servername, $c->username, $c->password, $c->database);

if ($mysqli->connect_error) {
    http_response_code(500);
    die(json_encode(['status' => 0, 'error' => 'Database connection failed']));
}

// Get bus info with current student_list
$stmt = $mysqli->prepare("SELECT bus_id, trip_status, student_list, bus_capacity FROM bus WHERE bus_id = ?");
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

// Check if trip is active
if ((int)$bus['trip_status'] !== 1) {
    $mysqli->close();
    http_response_code(400);
    die(json_encode(['status' => 0, 'error' => 'Trip not active']));
}

// Find student by RFID
$stmt = $mysqli->prepare("SELECT student_id, student_name, student_rfid, student_bus_id, parent_id FROM student WHERE student_rfid = ? LIMIT 1");
$stmt->bind_param('s', $rfid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $mysqli->close();
    http_response_code(404);
    die(json_encode(['status' => 0, 'error' => 'Student not found with this RFID']));
}

$student = $result->fetch_assoc();
$stmt->close();

// Verify student is assigned to this bus
if ((int)$student['student_bus_id'] !== $bus_id) {
    $mysqli->close();
    http_response_code(400);
    die(json_encode(['status' => 0, 'error' => 'Student not assigned to this bus']));
}

// Parse current student_list
$student_list = [];
if (!empty($bus['student_list'])) {
    $decoded = json_decode($bus['student_list'], true);
    if (is_array($decoded)) {
        $student_list = $decoded;
    }
}

// Check if student is already on bus
$is_on_bus = in_array($rfid, $student_list);
$action_type = 0; // 0 = boarding, 1 = exiting

if ($is_on_bus) {
    // Student is exiting - remove from list
    $student_list = array_values(array_filter($student_list, function($r) use ($rfid) {
        return $r !== $rfid;
    }));
    $action_type = 1;
} else {
    // Student is boarding - check capacity
    if (count($student_list) >= (int)$bus['bus_capacity']) {
        $mysqli->close();
        http_response_code(400);
        die(json_encode(['status' => 0, 'error' => 'Bus at full capacity']));
    }
    
    // Add to list
    $student_list[] = $rfid;
    $action_type = 0;
}

// Update bus.student_list
$student_list_json = json_encode($student_list);
$stmt = $mysqli->prepare("UPDATE bus SET student_list = ? WHERE bus_id = ?");
$stmt->bind_param('si', $student_list_json, $bus_id);

if (!$stmt->execute()) {
    $stmt->close();
    $mysqli->close();
    http_response_code(500);
    die(json_encode(['status' => 0, 'error' => 'Failed to update bus student list']));
}

$stmt->close();

// Insert attendance record
$stmt = $mysqli->prepare("INSERT INTO attendance (student_id, bus_id, type, timestamp) VALUES (?, ?, ?, NOW())");
$student_id = (int)$student['student_id'];
$stmt->bind_param('iii', $student_id, $bus_id, $action_type);
$stmt->execute();
$attendance_id = $stmt->insert_id;
$stmt->close();

$mysqli->close();

// Return success
echo json_encode([
    'status' => 1,
    'action' => $action_type === 0 ? 'boarded' : 'exited',
    'type' => $action_type,
    'student' => [
        'student_id' => (int)$student['student_id'],
        'student_name' => $student['student_name'],
        'student_rfid' => $student['student_rfid']
    ],
    'students_onboard_count' => count($student_list),
    'bus_capacity' => (int)$bus['bus_capacity'],
    'attendance_id' => $attendance_id,
    'timestamp' => date('Y-m-d H:i:s')
]);
?>