<?php

function post_curl($data, $url) {
    // Curl database

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, $url);
    curl_setopt($post, CURLOPT_POST, 1);
    curl_setopt($post, CURLOPT_POSTFIELDS, $data);
    curl_setopt($post, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

    $result = json_decode(curl_exec($post), true);

    if ($result === FALSE) {
        echo "error: " . curl_error($post);
        echo "curl info: " . curl_getinfo($post);
    }

    curl_close($post);

    return $result;
}