<?php

include_once "../utils/php_utils.php";

$data = Array (
    "type" => "get_q",
);

$url = "https://web.njit.edu/~ar579/coolproject/backend/database.php";
$post = curl_init();
curl_setopt($post, CURLOPT_URL, $url);
curl_setopt($post, CURLOPT_POST, 1);
curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($post, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($post);

if (curl_error($post)) {
    return Array("error" => curl_error($post));
}

curl_close($post);

print_r($result);
echo "\n";



