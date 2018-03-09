<?php 
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$data = Array("type" => "get_quiz", "quiz_name" => $_POST["quiz_name"]);
$questions = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
$graded = "TRUE";

$quiz = post_curl(Array("quiz_name" => $_POST["quiz_name"], "type" => "get_quiz"), "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");

if (isset($_POST["publish"])) {
    $data = Array(
        "quiz_name" => $_POST["quiz_name"],
        "publish" => "TRUE",
        "type" => "publish_quiz"
    );
    $out = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    echo $out;
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
            <h1><?php echo $quiz["quiz_name"] ?></h1>
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

                    $comments = $quiz["c$i"];
                    // Split comments by ; delimiter
                    $comments = explode(";", $comments);
                    // remove empty elements
                    $comments = array_filter($comments);
                    // combine again into string with new line for each element
                    $comments = implode("\n", $comments);

                    echo "<input type='hidden' name='questions[]' value='{$quiz["q".$i]}'>
                    <input type='hidden' name='answers[]' value='{$quiz["a".$i]}'>";

                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz["q".$i]}</p>
                    <strong><label>Student Answer:</label></strong>
                    <pre><code>{$quiz["a".$i]}</code></pre>
                    <strong><label>Points:</label></strong>
                    <input type='number' name='points[]' placeholder='Points' value='{$quiz["p".$i]}' max='{$quiz["mp".$i]}' min='0' style='width: 55px'><br>
                    <strong><label>Comments:</label></strong>
                    <textarea class='textarea-input'  name='comments[]' placeholder='comments'>{$comments}</textarea>
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
                        <p>{$quiz["mp".$i]}</p>
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