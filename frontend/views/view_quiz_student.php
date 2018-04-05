<?php
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$arr = Array(
    "type" => "get_quiz",
    "quiz_name"  => $_POST["quiz_name"]
);
$quiz = post_curl($arr, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
$n_questions = sizeof($quiz);
$quiz_name = $_POST["quiz_name"];

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


                for ($i = 0; $i < $n_questions; $i++) {
                    $comments = $quiz[$i]["comments"];
                    // Split comments by ; delimiter
                    $comments = explode(";", $comments);
                    // remove empty elements
                    $comments = array_values(array_filter(array_map('trim', $comments)));
                    // combine again into string with new line for each element
                    $comments = implode("\n", $comments);
		            $cmts = explode("\n", $comments);

                    for ($j = 0; $j < sizeof($cmts); $j++) {
                        if (strpos($cmts[$j], "incorrect") !== false || strpos($cmts[$j], "-" !== false)) {
                            $cmts[$j] = "<div style='color: red;'>" . $cmts[$j] . "</div>";
                        } else {
                            $cmts[$j] = "<div style='color: green;'>" . $cmts[$j] . "</div>";
                        }
                    }

                    $comments = array_values($cmts);
                    $comments = implode("\n", $comments);

                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz[$i]["question"]}</p>
                    <strong><label>Student Answer:</label></strong>
                    <pre><code>{$quiz[$i]["answer"]}</code></pre>
                    <strong><label>Points:</label></strong>
                    <label>{$quiz[$i]["points"]}/{$quiz[$i]["maxpoints"]}</label>
                    <strong><label>Comments:</label></strong>
                    <div contentEditable='true' class='textarea-input' style='color: #000 !important;' disabled>{$comments}</div>
                    </div>";
                }
            } else if (isset($_POST["take_quiz"])) {
                echo "<form method='POST' action='./frontend.php'>
                <input type='hidden' name='type' value='submit_quiz'>
                <input type='hidden' name='quiz_name' value='{$quiz_name}'>
                <input type='hidden' name='publish' value='FALSE'>";

                for ($i = 0; $i < $n_questions; $i++) {
                    echo "
                    <input type='hidden' name='questions[]' value='{$quiz[$i]["question"]}'>
                    <input type='hidden' name='comments[]' value=''>
                    <input type='hidden' name='points[]' value='{$quiz[$i]["maxpoints"]}'>
                    <input type='hidden' name='testcases[]' value='{$quiz[$i]["testcases"]}'/>

                    <div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz[$i]["question"]}</p>
                    <strong><label>Answer:</label></strong>
                    <textarea class='textarea-input' name='answers[]'></textarea>
                    <strong><br><label>Points:</label></strong>
                    <p>{$quiz[$i]["maxpoints"]}</p>
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
