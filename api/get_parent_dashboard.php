<?php
/*
 * GET PARENT DASHBOARD API
 * Returns parent information, their children, and attendance data
 * Now includes real-time bus status from student_list
 */
ini_set('log_errors', 0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');
require_once "Config.php";

session_start();

// Get parent_id from session
$username = $_SESSION['LoggedIN'];

$DBConfig = new DbConfig();
$conn = mysqli_connect($DBConfig->servername, $DBConfig->username, $DBConfig->password, $DBConfig->database);

if (!$conn) {
    die(json_encode(['status' => 0, 'error' => 'Connection failed']));
}

// Get parent information

$stmt = $conn->prepare("SELECT ID, username, parent_id FROM users WHERE username = ? AND usertype = 'parent' LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $mysqli->close();
    http_response_code(404);
    die(json_encode(['status' => 0, 'error' => 'parent not found']));
}

$parent = $result->fetch_assoc();

$parent_id = (int)$parent['parent_id'];

// Get all students for this parent with bus information
$sql_students = "SELECT 
    s.student_id,
    s.student_name,
    s.student_rfid,
    s.student_bus_id,
    CONCAT(b.bus_model, ' #', b.bus_id) as bus_name,
    b.bus_driver_name,
    b.trip_status,
    b.student_list,
    b.google_map,
    (SELECT COUNT(*) FROM attendance a WHERE a.student_id = s.student_id AND MONTH(a.timestamp) = MONTH(CURDATE()) AND YEAR(a.timestamp) = YEAR(CURDATE())) as attendance_this_month
FROM student s
LEFT JOIN bus b ON s.student_bus_id = b.bus_id
WHERE s.parent_id = $parent_id
ORDER BY s.student_name";

$result_students = $conn->query($sql_students);
$students = [];

if ($result_students->num_rows > 0) {
    while($row = $result_students->fetch_assoc()) {
        $student_id = $row['student_id'];
        $student_rfid = $row['student_rfid'];
        
        // Check if student is currently on the bus by looking at student_list JSON
        $is_on_bus = false;
        $student_list_json = $row['student_list'];
        
        if ($student_list_json) {
            $student_list = json_decode($student_list_json, true);
            if (is_array($student_list)) {
                // Check if student's RFID is in the list
                $is_on_bus = in_array($student_rfid, $student_list);
            }
        }
        
        // Get last attendance record (for historical tracking)
        $sql_last_attendance = "SELECT type, timestamp 
                                FROM attendance 
                                WHERE student_id = $student_id 
                                ORDER BY timestamp DESC 
                                LIMIT 1";
        $result_last = $conn->query($sql_last_attendance);
        $last_attendance = null;
        
        if ($result_last->num_rows > 0) {
            $last_attendance = $result_last->fetch_assoc();
        }
        
        $students[] = [
            'student_id' => (int)$row['student_id'],
            'student_name' => $row['student_name'],
            'student_rfid' => $row['student_rfid'],
            'student_bus_id' => $row['student_bus_id'] ? (int)$row['student_bus_id'] : null,
            'bus_name' => $row['bus_name'],
            'bus_driver_name' => $row['bus_driver_name'],
            'trip_status' => (int)$row['trip_status'],
            'google_map' => $row['google_map'],
            'is_on_bus' => $is_on_bus, // Real-time status from bus.student_list
            'attendance_this_month' => (int)$row['attendance_this_month'],
            'last_attendance' => $last_attendance
        ];
    }
}

// Get recent attendance records (last 30 days)
$sql_attendance = "SELECT 
    a.attendence_id,
    a.student_id,
    a.type,
    a.timestamp,
    s.student_name
FROM attendance a
INNER JOIN student s ON a.student_id = s.student_id
WHERE s.parent_id = $parent_id 
AND a.timestamp >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
ORDER BY a.timestamp DESC
LIMIT 50";

$result_attendance = $conn->query($sql_attendance);
$recent_attendance = [];

if ($result_attendance->num_rows > 0) {
    while($row = $result_attendance->fetch_assoc()) {
        $recent_attendance[] = [
            'attendence_id' => (int)$row['attendence_id'],
            'student_id' => (int)$row['student_id'],
            'student_name' => $row['student_name'],
            'type' => (int)$row['type'],
            'timestamp' => $row['timestamp']
        ];
    }
}


$sql_parent = "SELECT * FROM `parent` WHERE parent_id = $parent_id";
$parentdata = $conn->query($sql_parent);

if($parentdata->num_rows > 0){
    $row = $parentdata->fetch_assoc();
        $parentdatalist[] = [
            'parent_id' => $row['parent_id'],
            'parent_name' => $row['parent_name'],
            'parent_tel' => $row['parent_tel'],
            'parent_email' => $row['parent_email']
        ];

        echo json_encode([
    'status' => 1,
    'parent_id' => $row['parent_id'],
    'parent_name' => $row['parent_name'],
    'parent_tel' => $row['parent_tel'],
    'parent_email' => $row['parent_email'],
    'students' => $students,
    'recent_attendance' => $recent_attendance
]);

    
} else {
    die(json_encode(['status' => 0, 'error' => 'Parent data not found']));
}

$conn->close();



?>