<?php
/*
 * GET ALL BUS LOCATIONS API
 * Returns all buses with Google Maps links
 */
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/Config.php';

if (empty($_SESSION['LoggedIN']) || empty($_SESSION['UserTYPE'])) {
    http_response_code(401);
    echo json_encode(['status' => 0, 'error' => 'Unauthorized']);
    exit;
}

$c = new DBConfig();
$mysqli = new mysqli($c->servername, $c->username, $c->password, $c->database);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 0, 'error' => 'Database connection failed']);
    exit;
}

/* Get all buses */
$sql = "
SELECT 
    b.bus_id,
    b.bus_driver_name,
    b.bus_model,
    b.bus_capacity,
    b.trip_status,
    b.google_map,
    (
        SELECT COUNT(*) 
        FROM student s 
        WHERE s.student_bus_id = b.bus_id
    ) AS total_students
FROM bus b
ORDER BY b.bus_id
";

$result = $mysqli->query($sql);

$buses = [];

while ($row = $result->fetch_assoc()) {
    $buses[] = [
        'bus_id' => (int)$row['bus_id'],
        'bus_model' => $row['bus_model'],
        'bus_driver_name' => $row['bus_driver_name'],
        'bus_capacity' => (int)$row['bus_capacity'],
        'trip_status' => (int)$row['trip_status'],
        'google_map_url' => $row['google_map'],
        'total_students' => (int)$row['total_students']
    ];
}

$mysqli->close();

echo json_encode([
    'status' => 1,
    'buses' => $buses,
    'count' => count($buses)
]);
