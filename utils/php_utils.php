<?php

function post_curl($data, $url) {
    // Curl database

    $post = curl_init();
    curl_setopt($dbpost, CURLOPT_URL, $url);
    curl_setopt($dbpost, CURLOPT_POST, 1);
    curl_setopt($dbpost, CURLOPT_POSTFIELDS, $dbdata);
    curl_setopt($dbpost, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($dbpost, CURLOPT_RETURNTRANSFER, 1);

    $result = json_decode(curl_exec($post), true);

    if ($result === FALSE) {
        echo "error: " . curl_error($post);
        echo "curl info: " . curl_getinfo($post);
    }

    curl_close($post);

    return $result;
}