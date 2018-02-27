<?php 
$current_page = 'View quiz';

// $quiz_graded_questions = post_curl($data, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");

$test_data_questions = Array(
    "test q 1" => Array(
        "question" => "hello world?",
        "answer" => "yes",
        "points" => 7.5,
        "comments" => "This is a comment"
    ),

    "test q 2" => Array(
        "question" => "hello world yes?",
        "answer" => "def hello():
    return hello",
        "points" => 9.5,
        "comments" => "This is another comment"
    )
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/style.css" rel="stylesheet">
    <title>Homepage</title>
</head>
<body>

    <?php include_once "header_student.php"?>

    <div class="app">
        <div class="container-single" id="view-quiz">
            <form style="margin: .5em .5em; margin-right: auto;" method="POST" action="homepage_student.php">
                <input type="submit" value="Go Back">
            </form>

            <?php 

            foreach ($test_data_questions as $question => $info) {
                echo "<div class='view-quiz-question'>
                <h2>{$question}</h2>
                <strong><label>Question:</label></strong>
                <p>{$info['question']}</p>
                <strong><label>Student Answer:</label></strong>
                <pre><code>{$info['answer']}</code></pre>
                <strong><label>Points:</label></strong>
                <label>{$info['points']}</label>
                <strong><label>Comments:</label></strong>
                <p>{$info['comments']}</p>
                </div>";
            }


            ?>


        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>