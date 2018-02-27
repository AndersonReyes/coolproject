<?php 

include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$data = $_POST;

// // Receive json file with
$result = post_curl($data, "https://web.njit.edu/~ar579/coolproject/backend/database.php");


if ($_POST["type"] === "add_q") {
    header("Location: homepage_instructor.php");

} else if ($_POST["type"] === "add_quiz" || $_POST["type"] === "publish q") {
    header("Location: quiz_bank.php");
}

