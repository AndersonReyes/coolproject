<?php 
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$arr = Array(
    "type" => "get_quiz",
    "quiz_name"  => $_POST["quiz_name"]
);
$quiz = post_curl($arr, "https://web.njit.edu/~ar579/coolproject/backend/database.php");


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
                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz["q".$i]}</p>
                    <strong><label>Student Answer:</label></strong>
                    <pre><code>{$quiz["a".$i]}</code></pre>
                    <strong><label>Points:</label></strong>
                    <label>{$quiz['p'.$i]}</label>
                    <strong><label>Comments:</label></strong>
                    <p>{$$quiz['c'.$i]}</p>
                    </div>";
                }
            } else if (isset($_POST["take_quiz"])) {
                echo "<form method='POST' action='#'>";
                for ($i = 1; $i < 5; $i++) {
                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz["q".$i]}</p>
                    <strong><label>Answer:</label></strong>
                    <textarea class='textarea-input' name='a$i'></textarea>
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