<?php

$_POST = array();

$post = curl_init();
curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");
curl_setopt($post, CURLOPT_POST, 1);
curl_setopt($post, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

// Receive json file with
$result = json_decode(curl_exec($post), true);

curl_close($post);

if ($result["role"] === "prof") {
    header("Location: homepage_instructor.php");
} else if ($result["role"] === "student"){
    header("Location: homepage_student.php");
} else {
    echo "Error invalid user role";
}

