<?php
/*
 * LOGIN API
 * INPUT : USERNAME AND PASSWORD
 *
 * This is only sample api for handling login with basic username and password It was only made for school project.
 * BruteForce is possible.
 */
ini_set('log_errors', 0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');


require_once "Config.php";


$DBConfig = new DbConfig();
$Username = $DBConfig->username;
$Password = $DBConfig->password;
$Host = $DBConfig->servername;
$DBName = $DBConfig->database;

$POST_data_JSON = json_decode(file_get_contents('php://input'), true);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $conn = mysqli_connect($Host, $Username, $Password, $DBName);


    if (!$conn) {
        die(json_encode(['status' => 2, "error" => "Connection failed: "]));
    }

    $GivenUsername = $POST_data_JSON['username'];
    $GivenPassword = $POST_data_JSON['password'];

    if ($POST_data_JSON['username'] && $POST_data_JSON['password']) {


        // SQL query to fetch all users
        $sql = "SELECT * FROM `users` WHERE `username` = '${GivenUsername}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();


            $FetchID = $row["ID"];
            $FetchUsername = $row["username"];
            $FetchPassword = $row["password"];
            $FetchUserType = $row["usertype"];
            $FetchParentID = $row["parent_id"];
            $FetchAdminID = $row["admin_id"];
            $FetchBusID = $row["bus_id"];



            if($GivenPassword != $FetchPassword) {

                exit(json_encode(['status' => 2, "error" => "Password Is incorrect!"]));
            }

            /*
            if($FetchUserType == 0) {
                $GivenUserLinkedID = $FetchParentID;
            } elseif($FetchUserType == 1) {
                $GivenUserLinkedID = $FetchBusID;
            } elseif($FetchUserType == 2) {
                $GivenUserLinkedID = $FetchAdminID;
            }

            */

            echo json_encode(['status' => 1, "data" => [$FetchUsername, $FetchUserType]]);
            session_start();
            $_SESSION['LoggedIN'] = $FetchUsername;
            $_SESSION['UserTYPE'] = $FetchUserType;


        } else {
             echo json_encode(['status' => 2, "error" => "Username ($GivenUsername) is not registered in the system. Please Check with your administrator!"]);
        }

        $conn->close();


    } else {

        echo json_encode(['status' => 2, "error" => "Missing Inputs. username and password!"]);

    }
} else {

    echo json_encode(['status' => 2, "error" => "Bad Request!"]);

}
?>