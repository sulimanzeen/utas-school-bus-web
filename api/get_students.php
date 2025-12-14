<?php
/*
 * GET STUDENTS API
 * Returns list of all students with their details
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

$sql = "SELECT 
    s.student_id,
    s.student_name,
    s.student_rfid,
    s.parent_id,
    s.student_bus_id,
    p.parent_name,
    p.parent_tel,
    p.parent_email,
    CONCAT(b.bus_model, ' #', b.bus_id) as bus_name
FROM student s
LEFT JOIN parent p ON s.parent_id = p.parent_id
LEFT JOIN bus b ON s.student_bus_id = b.bus_id
ORDER BY s.student_name";

$result = $conn->query($sql);
$students = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = [
            'student_id' => (int)$row['student_id'],
            'student_name' => $row['student_name'],
            'student_rfid' => $row['student_rfid'],
            'parent_id' => (int)$row['parent_id'],
            'parent_name' => $row['parent_name'],
            'parent_tel' => $row['parent_tel'],
            'parent_email' => $row['parent_email'],
            'student_bus_id' => $row['student_bus_id'] ? (int)$row['student_bus_id'] : null,
            'bus_name' => $row['bus_name']
        ];
    }
}

$conn->close();

echo json_encode($students);
?>