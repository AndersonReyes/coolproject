<?php
    $uname = $_POST["uname"];
    $njitpass = $_POST["njitpass"];
    $data = array("uname" => $uname, "pass" => $njitpass, "appstate" => "login");
    
    $_POST = array();

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/middle/middleLogin.php");
    curl_setopt($post, CURLOPT_POST, 1);
    curl_setopt($post, CURLOPT_POSTFIELDS, $data);
    curl_setopt($post, CURLOPT_FOLLOWLOCATION, 1);

    // Receive json file with 
    curl_exec($post);
    curl_close($post);
?>