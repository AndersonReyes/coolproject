<?php 

include_once "./../../utils/php_utils.php";


if ($_POST["type"] === "login") {
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    
    // Set the boolean if it has access
    $dbresult = post_db($user, $pass);
    
    echo json_encode(Array("dbresult" => $dbresult["dbaccess"], "njitresult" => $njitresult));
    
} else if ($_POST["type"] === "add_q") {
    $data = $_POST;
    $result = post_curl($data, "https://web.njit.edu/~ssc3/coolproject/beta/database.php");
    header("Location: homepage_instructor.php");
    
} else if ($_POST["type"] === "add_quiz" || $_POST["type"] === "publish q") {
    $data = $_POST;
    $data["publish"] = "FALSE";
    $result = post_curl($data, "https://web.njit.edu/~ssc3/coolproject/beta/database.php");
    header("Location: quiz_bank.php");
} else if ($_POST["type"] === "submit_quiz") {
    $data = $_POST;
    $data["max_quiz_points"] = array_sum($data["points"]);
    $data["testcases"] = "";
<<<<<<< Updated upstream
    $result = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/betagrader.php");
    header("Location: homepage_student.php");
=======

    $post = curl_init();
    curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/middle/betagrader.php");
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

    echo $result;
    // header("Location: homepage_student.php");
>>>>>>> Stashed changes
} else if ($_POST["type"] === "update_quiz") {
    $data = $_POST;
    $data["FULLL_GRADED_EXAM_COMMENTS"] = array();
    for ($i = 1; $i < 5; $i++) {
        array_push($data["FULLL_GRADED_EXAM_COMMENTS"], Array(
            "Question_Final_Grade" => $data["points"][$i-1],
            "Function" => "",
		    "Parameters" => "",
		    "Return" => "",
		    "Output" => $data["comments"][$i-1],
		    "Testcases" => ""
        ));
    }

    $result = post_curl($data, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
    header("Location: view_grades.php");
}
