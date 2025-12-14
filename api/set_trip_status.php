<?php
/*
 * SET TRIP STATUS API
 * POST JSON: { "status": 1 }    // 1 = started, 0 = stopped
 * When trip ends (status=0), automatically clears bus.student_list
 */
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/Config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['status' => 0, 'error' => 'Method not allowed']));
}

if (empty($_SESSION['LoggedIN']) || empty($_SESSION['UserTYPE']) || $_SESSION['UserTYPE'] !== 'driver') {
    http_response_code(401);
    die(json_encode(['status' => 0, 'error' => 'Unauthorized']));
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input) || !isset($input['status'])) {
    http_response_code(400);
    die(json_encode(['status' => 0, 'error' => 'Invalid payload - status required']));
}

$trip_status = (int)$input['status'];

if ($trip_status !== 0 && $trip_status !== 1) {
    http_response_code(400);
    die(json_encode(['status' => 0, 'error' => 'Invalid status - must be 0 or 1']));
}

try {
    $c = new DBConfig();
    $mysqli = new mysqli($c->servername, $c->username, $c->password, $c->database);
    
    if ($mysqli->connect_error) {
        throw new Exception('Database connection failed');
    }

    // Get driver's bus
    $username = $_SESSION['LoggedIN'];
    $stmt = $mysqli->prepare("SELECT ID, bus_id FROM users WHERE username = ? AND usertype = 'driver' LIMIT 1");
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $mysqli->error);
    }
    
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        $mysqli->close();
        http_response_code(401);
        die(json_encode(['status' => 0, 'error' => 'Driver not found']));
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
    $bus_id = (int)$user['bus_id'];
    
    if ($bus_id <= 0) {
        $mysqli->close();
        http_response_code(400);
        die(json_encode(['status' => 0, 'error' => 'No bus assigned']));
    }

    // Check if trip_status column exists
    $stmt = $mysqli->prepare("SHOW COLUMNS FROM `bus` LIKE 'trip_status'");
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $mysqli->error);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $column_exists = ($result && $result->num_rows > 0);
    $stmt->close();
    
    if (!$column_exists) {
        $mysqli->close();
        http_response_code(400);
        die(json_encode(['status' => 0, 'error' => 'Column trip_status missing from bus table']));
    }

    // If ending trip (status = 0), clear student_list and create exit records
    if ($trip_status === 0) {
        // Get current students on bus
        $stmt = $mysqli->prepare("SELECT student_list FROM bus WHERE bus_id = ?");
        $stmt->bind_param('i', $bus_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bus = $result->fetch_assoc();
        $stmt->close();
        
        // Parse student_list to create exit records
        $student_list = [];
        if (!empty($bus['student_list'])) {
            $decoded = json_decode($bus['student_list'], true);
            if (is_array($decoded)) {
                $student_list = $decoded;
            }
        }
        
        // Create exit attendance records for all students still on bus
        if (!empty($student_list)) {
            foreach ($student_list as $rfid) {
                // Get student_id from rfid
                $stmt = $mysqli->prepare("SELECT student_id FROM student WHERE student_rfid = ? LIMIT 1");
                $stmt->bind_param('s', $rfid);
                $stmt->execute();
                $sresult = $stmt->get_result();
                
                if ($sresult->num_rows > 0) {
                    $student = $sresult->fetch_assoc();
                    $student_id = (int)$student['student_id'];
                    
                    // Insert exit record (type = 1)
                    $exit_type = 1;
                    $stmt2 = $mysqli->prepare("INSERT INTO attendance (student_id, bus_id, type, timestamp) VALUES (?, ?, ?, NOW())");
                    $stmt2->bind_param('iii', $student_id, $bus_id, $exit_type);
                    $stmt2->execute();
                    $stmt2->close();
                }
                
                $stmt->close();
            }
        }
        
        // Update trip status and clear student_list
        $empty_list = '[]';
        $stmt = $mysqli->prepare("UPDATE bus SET trip_status = ?, student_list = ? WHERE bus_id = ?");
        
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        
        $stmt->bind_param('isi', $trip_status, $empty_list, $bus_id);
    } else {
        // Starting trip - just update status
        $stmt = $mysqli->prepare("UPDATE bus SET trip_status = ? WHERE bus_id = ?");
        
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        
        $stmt->bind_param('ii', $trip_status, $bus_id);
    }
    
    if (!$stmt->execute()) {
        throw new Exception('Update failed: ' . $stmt->error);
    }
    
    $stmt->close();
    $mysqli->close();
    
    echo json_encode([
        'status' => 1,
        'trip_status' => $trip_status,
        'bus_id' => $bus_id,
        'message' => $trip_status === 0 ? 'Trip ended, all students marked as exited' : 'Trip started'
    ]);
    
} catch (Exception $e) {
    if (isset($mysqli) && ($mysqli instanceof mysqli)) {
        @$mysqli->close();
    }
    
    http_response_code(500);
    die(json_encode([
        'status' => 0,
        'error' => 'Server error',
        'detail' => $e->getMessage()
    ]));
}
?>