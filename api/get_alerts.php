<?php
/*
 * GET ALERTS API
 * Returns recent alerts/notifications
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

// Get recent attendance events that might be alerts
$sql = "SELECT 
    a.timestamp,
    a.type,
    s.student_name,
    CONCAT(b.bus_model, ' #', b.bus_id) as bus_name,
    b.bus_id
FROM attendance a
INNER JOIN student s ON a.student_id = s.student_id
INNER JOIN bus b ON a.bus_id = b.bus_id
WHERE DATE(a.timestamp) = CURDATE()
ORDER BY a.timestamp DESC
LIMIT 10";

$result = $conn->query($sql);
$alerts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $type = (int)$row['type'];
        $alert_type = $type === 0 ? 'Boarded' : 'Exited';
        
        // Determine alert level
        $level = $type === 0 ? 'active' : 'inactive';
        $status = $type === 0 ? 'On Bus' : 'Dropped Off';
        
        $alerts[] = [
            'time' => date('h:i A', strtotime($row['timestamp'])),
            'type' => $alert_type . ': ' . $row['student_name'],
            'bus' => $row['bus_name'],
            'status' => $status,
            'level' => $level
        ];
    }
}

// If no alerts today, add a placeholder
if (empty($alerts)) {
    $alerts[] = [
        'time' => date('h:i A'),
        'type' => 'No Activity',
        'bus' => 'N/A',
        'status' => 'All Clear',
        'level' => 'inactive'
    ];
}

$conn->close();

echo json_encode($alerts);
?>