<?php
/*
 * GET BUSES API
 * Returns list of all buses with their current load
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
    b.bus_id,
    CONCAT(b.bus_model, ' #', b.bus_id) as bus_name,
    b.bus_driver_name,
    b.bus_capacity,
    b.trip_status,
    b.student_list,
    (SELECT COUNT(*) FROM student WHERE student_bus_id = b.bus_id) as current_load
FROM bus b
ORDER BY b.bus_id";

$result = $conn->query($sql);
$buses = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Calculate load ratio
        $current_load = (int)$row['current_load'];
        $capacity = (int)$row['bus_capacity'];
        $load_ratio = $capacity > 0 ? $current_load / $capacity : 0;
        
        // Determine status based on trip_status field
        $trip_status = (int)$row['trip_status'];
        $statusClass = 'inactive';
        $statusText = 'Idle';
        
        if ($trip_status === 1) {
            // Trip is started
            if ($load_ratio >= 0.95) {
                $statusClass = 'warning';
                $statusText = 'Trip Started (Near Full)';
            } else {
                $statusClass = 'active';
                $statusText = 'Trip Started';
            }
        } else {
            // Trip not started (trip_status = 0)
            $statusClass = 'inactive';
            $statusText = 'Idle';
        }
        
        $buses[] = [
            'bus_id' => (int)$row['bus_id'],
            'bus_name' => $row['bus_name'],
            'bus_driver_name' => $row['bus_driver_name'],
            'bus_capacity' => $capacity,
            'trip_status' => $trip_status,
            'current_load' => $current_load,
            'load_ratio' => round($load_ratio, 2),
            'status_class' => $statusClass,
            'status_text' => $statusText
        ];
    }
}

$conn->close();

echo json_encode($buses);
?>