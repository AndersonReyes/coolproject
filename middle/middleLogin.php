<?php
/**
 * Created by KendyColon.
 * User: kendycolon
 * Date: 1/26/18
 * Time: 1:40 AM
 */


// //CAPTURE THE DATA SENT FROM THE FRONT-END
// $capture = file_get_contents("php://input");
// //$connection = curl_init();

// //curl_setopt($connection, CURLOPT_URL, "http://afsaccess1.njit.edu/~USERNAME/DIRECTORY/middleLogin.php");
// //curl_setopt($connection, CURLOPT_POST, 1);
// //curl_setopt($connection, CURLOPT_POSTFIELDS, $capture);
// //curl_setopt($connection, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
// //curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

// //SEND REQUEST TO THE FILE IN THE NJIT ACCOUNT
// //$designation = curl_exec($connection);
// //FINISH CONNECTION
// //curl_close($connection);


function post_db($uname, $dbpass) {

    // Curl database
    $dbdata = array("user" => $uname, "pass" => $dbpass);
    
    $dbpost = curl_init();
    curl_setopt($dbpost, CURLOPT_URL, "https://web.njit.edu/~ar579/backend/database.php");
    curl_setopt($dbpost, CURLOPT_POST, 1);
    curl_setopt($dbpost, CURLOPT_POSTFIELDS, $dbdata);
    curl_setopt($dbpost, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($dbpost, CURLOPT_RETURNTRANSFER, 1);
    
    $result = curl_exec($dbpost);
    
    if ($result === FALSE) {
        echo "error: " . curl_error($dbpost);
        echo "curl info: " . curl_getinfo($dbpost);
    }
    
    curl_close($dbpost);

    return $result;    
}

// get what part of the app we at now, login, logout, welcome page etc
$appstate = $_POST["appstate"];

// Start session to pass variables to other pages (no need for curl)
session_start();

switch ($appstate) {
    case "login":
        $uname = $_POST["uname"];
        $njitpass = $_POST["njitpass"];
        $dbpass = $_POST["dbpass"];

        // Set the boolean if it has database access
        $_SESSION["userdata"] = post_db($uname, $dbpass);

        header("Location: ../frontend/welcome.php");
        break;
}

?>
