<?php 
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$arr = Array(
    "type" => "get_quiz",
    "quiz_name"  => $_POST["quiz_name"]
);
$quiz = post_curl($arr, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
$n_questions = 4;


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
            if (isset($_POST["view_graded"])) {
                
                
                for ($i = 1; $i < 5; $i++) {
                    $comments = $quiz["c$i"];
                    // Split comments by ; delimiter
                    $comments = explode(";", $comments);
                    // remove empty elements
                    $comments = array_filter($comments);
                    // combine again into string with new line for each element
                    $comments = implode("<br>", $comments);

                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz["q".$i]}</p>
                    <strong><label>Student Answer:</label></strong>
                    <pre><code>{$quiz["a".$i]}</code></pre>
                    <strong><label>Points:</label></strong>
                    <label>{$quiz['p'.$i]}/{$quiz["mp".$i]}</label>
                    <strong><label>Comments:</label></strong>
                    <textarea class='textarea-input' style='color: #000 !important;' disabled>{$comments}</textarea>
                    </div>";
                }
            } else if (isset($_POST["take_quiz"])) {
                echo "<form method='POST' action='./frontend.php'>
                <input type='hidden' name='type' value='submit_quiz'>
                <input type='hidden' name='quiz_name' value='{$quiz["quiz_name"]}'>
                <input type='hidden' name='publish' value='FALSE'>";

                for ($i = 1; $i < $n_questions+1; $i++) {
                    echo "
                    <input type='hidden' name='questions[]' value='{$quiz["q".$i]}'>
                    <input type='hidden' name='comments[]' value=''>
                    <input type='hidden' name='points[]' value='{$quiz["mp".$i]}'>

                    <div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz["q".$i]}</p>
                    <strong><label>Answer:</label></strong>
                    <textarea class='textarea-input' name='answers[]'></textarea>
                    <strong><br><label>Points:</label></strong>
                    <p>{$quiz['mp'.$i]}</p>
                    </div>";
                }
                
                echo "<input type='submit' value='Submit'>
                </form>";
            }


            ?>


        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>
