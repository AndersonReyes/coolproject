<?php
$data = Array (
    "type" => "add_quiz",
    "quiz_name" => "testoperation",
    "questions" => Array (
        "write a function named operation that takes variables op, var1 and var2 : as parameters, that returns [result] which is the result of the given arithmetic operations. You must use conditional statements to earn full credit.i",
        "testQ"
    ),
    "max_points" => Array(
        10, 10
    ),
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


$data = Array (
    "type" => "get_quiz",
    "quiz_name" => "testoperation"
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

$opquiz = json_decode(curl_exec($post), true);

if (curl_error($post)) {
    return Array("error" => curl_error($post));
}

curl_close($post);

$opquiz[0]["answer"] = "

def Math(op, var1, var2):
    if (op=='+'):
        result= var1+var2;
    elif (op=='-'):
        result= var1-var2;
    elif (op=='*'):
        result= var1*var2;
    else:
        result= var1/var2;

    return result;
    ";


$grader_data = Array(
    "quiz_name" => "testoperation",
    "exam_final_grade" => 10,
    0 => Array(
        "Question" => $opquiz[0]["question"],
        "Student_Answer" => $opquiz[0]["answer"],
        "Question_Final_Grade" => 10
    )
);

$_POST = Array(
    "type" => "update_quiz",
    "FULLL_GRADED_EXAM_COMMENTS" => $grader_data
);

$backendpost = curl_init();
curl_setopt($backendpost, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
curl_setopt($backendpost, CURLOPT_POSTFIELDS, http_build_query($_POST));
curl_setopt($backendpost, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($backendpost, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($backendpost, CURLOPT_FOLLOWLOCATION, 1);
$dbresult = curl_exec($backendpost);
curl_close($backendpost);



// print_r($opquiz);
echo "\n";




$data = Array (
    "type" => "get_quiz",
    "quiz_name" => "testoperation"
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

$graded_quiz = curl_exec($post);
curl_close($post);


echo "\nDatabase result:\n" . $dbresult;
echo "\n\nGraded quiz:\n";
print_r($graded_quiz);

$data = Array (
    "type" => "delete_quiz",
    "quiz_name" => "testoperation"
);

$url = "https://web.njit.edu/~ssc3/coolproject/beta/database.php";
$post = curl_init();
curl_setopt($post, CURLOPT_URL, $url);
curl_setopt($post, CURLOPT_POST, 1);
curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($post, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);

curl_exec($post);
curl_close($post);
