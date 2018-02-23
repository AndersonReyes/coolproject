<?php
$uname = $_POST["user"];
$dbpass = $_POST["pass"];

$data = array("user" => $uname, "pass" => $dbpass);

$_POST = array();

$post = curl_init();
curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");
curl_setopt($post, CURLOPT_POST, 1);
curl_setopt($post, CURLOPT_POSTFIELDS, $data);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

// Receive json file with
$result = json_decode(curl_exec($post), true);

curl_close($post);

if ($result["admin"]) {
    header("Location: homepage_instructor.php");
} else {
    header("Location: homepage_student.php");
}

