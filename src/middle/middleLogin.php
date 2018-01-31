<?php
/**
 * Created by KendyColon.
 * User: kendycolon
 * Date: 1/26/18
 * Time: 1:40 AM
 */


//CAPTURE THE DATA SENT FROM THE FRONT-END
$capture = file_get_contents("php://input");
$connection = curl_init();

curl_setopt($connection, CURLOPT_URL, "http://afsaccess1.njit.edu/~USERNAME/DIRECTORY/middleLogin.php");
curl_setopt($connection, CURLOPT_POST, 1);
curl_setopt($connection, CURLOPT_POSTFIELDS, $capture);
curl_setopt($connection, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

//SEND REQUEST TO THE FILE IN THE NJIT ACCOUNT
$designation = curl_exec($connection);
//FINISH CONNECTION
curl_close($connection);

?>
