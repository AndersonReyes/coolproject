<?php

include_once "../utils/php_utils.php";

$data = Array (
    "type" => "add_quiz",
    "quiz_name" => "dummyquiz2",
    "questions" => Array (
        "what is your name"
    ),
    "max_points" => Array(
        10
    )
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

echo $result;

curl_close($post);

echo "quiz created with name 'dummyquiz2'\n";

$check_created = post_curl(Array(
    "type" => "get_quiz",
    "quiz_name" => "dummyquiz2"
), $url);

echo "checking if quiz was created by curl get_quiz";
print_r($check_created);

post_curl(Array(
    "type" => "delete_quiz",
    "quiz_name" => "dummyquiz2"
), $url);
echo "\n";



