<?php
/**
 * Created by PhpStorm.
 * User: kendycolon
 * Date: 3/2/18
 * Time: 9:26 PM
*/
    $request = file_get_contents('php://input');
    $sendDB = curl_init();
    curl_setopt($sendDB, CURLOPT_URL, "https://web.njit.edu/~ssc3/coolproject/backend/database.php");
    curl_setopt($sendDB, CURLOPT_POST, 1);
    curl_setopt($sendDB, CURLOPT_POSTFIELDS, $request);
    curl_setopt($sendDB, CURLOPT_FOLLOWLOCATION, 1);

    $db_link = curl_exec($sendDB);
    curl_close($db_link);
?>