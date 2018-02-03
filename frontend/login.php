<?php
    $uname = $_POST["user"];
    $njitpass = $_POST["njitpass"];
    $dbpass = $_POST["dbpass"];

    $data = array("user" => $uname, "dbpass" => $dbpass, "njitpass" => $njitpass, "appstate" => "login");
    
    $_POST = array();

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/middle/middleLogin.php");
    curl_setopt($post, CURLOPT_POST, 1);
    curl_setopt($post, CURLOPT_POSTFIELDS, $data);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

    // Receive json file with 
    $result = json_decode(curl_exec($post), true);
    curl_close($post);

    $dbprintout = "";
    $njitprintout = "";

    if ($result["njitresult"] === "true") {
        $njitprintout = "<p>Welcome to njit services</p><br>";
    } else {
        $njitprintout = "<p>No njit services</p><br>";
    }

    if ($result["dbresult"] === "true") {
        $dbprintout = "<p>Welcome to database services</p><br>";
    } else {
        $dbprintout = "<p>No database services</p><br>";
    }

    echo json_encode(Array("dbresult" => $dbprintout));
?>