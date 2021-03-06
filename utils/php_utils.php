<?php

function post_curl($data, $url) {
    // Curl database

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, $url);
    curl_setopt($post, CURLOPT_POST, 1);
    curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($post, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);

    $result = json_decode(curl_exec($post), true);

    if (curl_error($post)) {
        return Array("error" => curl_error($post));
    }

    curl_close($post);

    return $result;
}