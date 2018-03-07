<?php

$post = curl_init();
curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/frontend/view/frontend.php");
curl_setopt($post, CURLOPT_POST, 1);
curl_setopt($post, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);

// Receive json file with
$result = json_decode(curl_exec($post), TRUE);
$info = curl_getinfo($post);
$err = curl_error($post);

curl_close($post);

if (isset($result["admin"]) && $result["dbaccess"]) {
    
    if ($result["admin"] === "1") {
        header("Location: views/homepage_instructor.php");
    } else if ($result["admin"] === "0"){
        header("Location: views/homepage_student.php");
    } 
    
} else {
    header("Location: ../index.html");    
}

$_POST = array();