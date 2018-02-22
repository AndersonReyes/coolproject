<?php 

include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$data = json_encode($_POST);

// Receive json file with
$result = post_curl($data, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");
echo json_encode($result);