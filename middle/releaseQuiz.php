<?php
/**
 * Created by PhpStorm.
 * User: kendycolon
 * Date: 3/2/18
 * Time: 9:24 PM
 */

    $request = file_get_contents('php://input');

    $release = curl_init();
    curl_setopt($release, CURLOPT_URL, "https://web.njit.edu/~ssc3/coolproject/backend/database.php");
    curl_setopt($release, CURLOPT_POST, 1);
    curl_setopt($release, CURLOPT_POSTFIELDS, $request);
    curl_setopt($release, CURLOPT_FOLLOWLOCATION, 1);

    $db_link = curl_exec($release);
    curl_close($db_link);

?>