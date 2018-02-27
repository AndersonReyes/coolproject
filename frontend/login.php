<?php

$post = curl_init();
curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
curl_setopt($post, CURLOPT_POST, 1);
curl_setopt($post, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

// Receive json file with
$result = json_decode(curl_exec($post), true);

curl_close($post);

if (isset($result["admin"]) && $result["dbaccess"]) {
    
    if ($result["admin"] === "1") {
        header("Location: views/homepage_instructor.php");
    } else if ($result["admin"] === "0"){
        header("Location: views/homepage_student.php");
    } 

} else {
    echo "<br>Curl error: <br>";
    print_r(curl_getinfo($post));
    echo "<br>Error invalid user: <br>";
    print_r($result);
    echo "<br>POST PARAMS: <br>";
    print_r($_POST);

}

$_POST = array();