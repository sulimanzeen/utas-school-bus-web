<?php
/*
 * GET PARENTS API
 * Returns list of all parents
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

$sql = "SELECT parent_id, parent_name, parent_tel, parent_email FROM parent ORDER BY parent_name";

$result = $conn->query($sql);
$parents = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $parents[] = [
            'parent_id' => (int)$row['parent_id'],
            'parent_name' => $row['parent_name'],
            'parent_tel' => $row['parent_tel'],
            'parent_email' => $row['parent_email']
        ];
    }
}

$conn->close();

echo json_encode($parents);
?>