<?php
// api/driver_checkin.php
// Accepts POST JSON: { "student_id": 123 }
// Inserts attendance row for the driver->bus->student for today.
// Returns JSON { status: 1 } on success or { status: 0, error: "..."}.

header('Content-Type: application/json; charset=utf-8');
session_start();

require_once __DIR__ . '/Config.php';

// require driver session
if (empty($_SESSION['LoggedIN']) || empty($_SESSION['UserTYPE']) || $_SESSION['UserTYPE'] !== 'driver') {
    http_response_code(401);
    echo json_encode(['status' => 0, 'error' => 'unauthorized']);
    exit;
}

// read input
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['student_id']) || !is_numeric($input['student_id'])) {
    http_response_code(400);
    echo json_encode(['status' => 0, 'error' => 'missing student_id']);
    exit;
}
$student_id = (int)$input['student_id'];

try {
    $c = new DBConfig();
    $mysqli = new mysqli($c->servername, $c->username, $c->password, $c->database);
    if ($mysqli->connect_error) {
        throw new Exception('DB connection failed');
    }

    // find driver row (to ensure bus_id)
    $username = $_SESSION['LoggedIN'];
    $stmt = $mysqli->prepare("SELECT ID, bus_id FROM users WHERE username = ? AND usertype = 'driver' LIMIT 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $u = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$u) {
        http_response_code(401);
        echo json_encode(['status' => 0, 'error' => 'driver record not found']);
        $mysqli->close();
        exit;
    }
    $bus_id = (int)$u['bus_id'];
    if ($bus_id <= 0) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'no bus assigned to driver']);
        $mysqli->close();
        exit;
    }

    // ensure student belongs to this bus
    $stmt = $mysqli->prepare("SELECT student_id FROM student WHERE student_id = ? AND student_bus_id = ? LIMIT 1");
    $stmt->bind_param('ii', $student_id, $bus_id);
    $stmt->execute();
    $sr = $stmt->get_result();
    $stmt->close();
    if ($sr->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'student not assigned to this bus']);
        $mysqli->close();
        exit;
    }

    // prevent duplicate check-in the same day
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM attendance WHERE student_id = ? AND DATE(`timestamp`) = CURDATE()");
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $cnt = $stmt->get_result()->fetch_assoc()['cnt'] ?? 0;
    $stmt->close();
    if ($cnt > 0) {
        echo json_encode(['status' => 0, 'error' => 'student already checked in today']);
        $mysqli->close();
        exit;
    }

    // insert attendance (type 0 = normal check-in)
    $stmt = $mysqli->prepare("INSERT INTO attendance (student_id, bus_id, `type`) VALUES (?, ?, 0)");
    $stmt->bind_param('ii', $student_id, $bus_id);
    if (!$stmt->execute()) {
        throw new Exception('insert failed: ' . $stmt->error);
    }
    $stmt->close();

    echo json_encode(['status' => 1, 'message' => 'checked in']);
    $mysqli->close();
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 0, 'error' => 'server error', 'detail' => $e->getMessage()]);
    exit;
}
