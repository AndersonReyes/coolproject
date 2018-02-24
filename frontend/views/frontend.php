<?php 

include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$data = json_encode($_POST);

// // Receive json file with
$result = post_curl($data, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");

if ($_POST["type"] === "add q") {
    header("Location: homepage_instructor.php");

} else if ($_POST["type"] === "add exam") {
    header("Location: exam_bank.php");
}

