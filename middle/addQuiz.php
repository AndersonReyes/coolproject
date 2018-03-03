<?php
/**
 * Created by PhpStorm.
 * User: kendycolon
 * Date: 3/2/18
 * Time: 9:17 PM
 */

    $request = file_get_contents('php://input');
    $add_quiz = curl_init();
    curl_setopt($add_quiz, CURLOPT_URL, "https://web.njit.edu/~ssc3/coolproject/backend/database.php");
    curl_setopt($add_quiz, CURLOPT_POST, 1);
    curl_setopt($add_quiz, CURLOPT_POSTFIELDS, $request);
    curl_setopt($add_quiz, CURLOPT_FOLLOWLOCATION, 1);

    $DB_Link = curl_exec($add_quiz);
    curl_close($DB_Link);
?>