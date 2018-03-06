<?php 
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$data = Array("type" => "get_quiz", "quiz_name" => $_POST["quiz_name"]);
$questions = post_curl($data, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
$graded = "TRUE";

$quiz = post_curl(Array("quiz_name" => $_POST["quiz_name"], "type" => "get_quiz"), "https://web.njit.edu/~ar579/coolproject/backend/database.php");

if (isset($_POST["publish"])) {
    $questions = array();
    $points = array();
    $comments = array();
    for ($i = 1; $i < 5; $i++) {
        array_push($questions, $quiz["q".$i]);
        array_push($comments, $quiz["c".$i]);
        array_push($points, $quiz["p".$i]);
    }

    $data = Array(
        "quiz_name" => $_POST["quiz_name"],
        "type" => "update_quiz",
        "questions" => $questions,
        "comments" => $comments,
        "points" => $points,
        "publish" => "TRUE"
    );

    $out = post_curl($data, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
    header("Location: view_grades.php");

} else if (isset($_POST["view"])) {
    if ($quiz["a1"] === "") {
        $graded = "FALSE";
    } else {
        $current_page = "Review Graded Quiz";
    }
}

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

    <?php include_once "./header.php"; ?>

    <div class="app">
        <div class="container-single" id="view-quiz">
            <form style="margin: .5em .5em; margin-right: auto;" method="POST" action="view_grades.php">
                <input type="submit" value="Go Back">
            </form>

            <?php 
            if ($graded === "TRUE") {
                echo "<form method='POST' action='frontend.php'>
                <input type='hidden' name='type' value='update_quiz'>
                <input type='hidden' name='quiz_name' value='{$quiz["quiz_name"]}'>
                <input type='hidden' name='publish' value='{$quiz["publish"]}'";
                for ($i=1; $i < 5; $i++) {

                    echo "<input type='hidden' name='questions[]' value='{$quiz["q".$i]}'>";

                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz["q".$i]}</p>
                    <strong><label>Student Answer:</label></strong>
                    <pre><code>{$quiz["a".$i]}</code></pre>
                    <strong><label>Points:</label></strong>
                    <input type='number' name='points[]' placeholder='Points' value='{$quiz["p".$i]}' max='{$quiz["mp".$i]}' min='0' style='width: 55px'><br>
                    <strong><label>Comments:</label></strong>
                    <textarea class='textarea-input'  name='comments[]' placeholder='comments'>{$quiz["c".$i]}</textarea>
                    </div>";
                }

                echo "<input type='submit' value='Submit'>
                </form>";
            } else {
                for ($i=1; $i < 5; $i++) {
                    echo "<div class='view-quiz-question'>
                        <strong><label>Question:</label></strong>
                        <p>{$quiz["q".$i]}</p>
                        <strong><label>Points:</label></strong>
                        <input type='number' name='question_points' placeholder='Points' value='{$quiz["p".$i]}' style='width: 55px'><br>
                        <strong><label>Test cases:</label></strong>
                        <p></p>
                        </div>";
                }
                
            }
            ?>


        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>