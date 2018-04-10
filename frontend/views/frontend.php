<?php

include_once "./../../utils/php_utils.php";

if ($_POST["type"] === "login") {

    // Set the boolean if it has access
    $dbresult = post_curl($_POST, "https://web.njit.edu/~krc9/coolproject/middle/middleLogin.php");

    echo json_encode($dbresult);

} else if ($_POST["type"] === "add_q" || $_POST["type"] === "update_q") {
    $data = $_POST;
    $data["testcases"] = array_filter(explode(';', $data["testcases"]));
    $result = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    header("Location: homepage_instructor.php");

} else if ($_POST["type"] === "delete_q") {
    $data = $_POST;
    $result = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    header("Location: homepage_instructor.php");

} else if ($_POST["type"] === "add_quiz") {
    $data = $_POST;
    $data["publish"] = "FALSE";
    $result = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    header("Location: quiz_bank.php");
} else if ($_POST["type"] === "submit_quiz") {
    $data = $_POST;
    $data["max_quiz_points"] = array_sum($data["points"]);

    for ($i = 0; $i < sizeof($data["testcases"]); $i++) {
        $data["testcases"][$i] = array_filter(explode(";", $data["testcases"][$i]));
    }

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~krc9/coolproject/middle/betagrader.php");
    curl_setopt($post, CURLOPT_POST, 1);
    curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($post, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);

    $result = curl_exec($post);
    $info = curl_error($post);

    if (curl_error($post)) {
        return Array("error" => curl_error($post));
    }

    curl_close($post);

    // echo $result;
    header("Location: homepage_student.php");
} else if ($_POST["type"] === "update_quiz_prof") {
    $data = $_POST;
    print_r($data["questions"]);
    $new_data = array();
    for ($i = 0; $i < sizeof($data["points"]); $i++) {
        array_push($new_data, Array(
            "Points" => $data["points"][$i],
            "Question" => $data["questions"][$i],
		    "Comments" => $data["comments"][$i],
        ));
    }

    $data["Prof_changes"] = $new_data;
    $result = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    echo $result;
    header("Location: view_grades.php");
} else if ($_POST["type"] === "delete_quiz") {
    $data = $_POST;
    $result = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    header("Location: view_grades.php");
} else if ($_POST["type"] === "update_quiz_edit") {
    $quiz_name = $_POST["quiz_name"];
    print_r($_POST);
    $delete_quiz = post_curl(Array("quiz_name" => $quiz_name, "type" => "delete_quiz"), "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");

    $_POST["type"] = "add_quiz";
    $result = post_curl($_POST, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    header("Location: view_grades.php");

}

