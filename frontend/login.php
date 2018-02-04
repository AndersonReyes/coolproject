<?php
    $uname = $_POST["user"];
    $dbpass = $_POST["pass"];

    $data = array("user" => $uname, "pass" => $dbpass, "appstate" => "login");
    
    $_POST = array();

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/middle/middleLogin.php");
    curl_setopt($post, CURLOPT_POST, 1);
    curl_setopt($post, CURLOPT_POSTFIELDS, $data);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

    // Receive json file with 
    $result = json_decode(curl_exec($post), true);
    curl_close($post);

    echo json_encode($result);
?>