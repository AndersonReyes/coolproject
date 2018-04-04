<?php
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$graded = "TRUE";
$quiz_name = $_POST["quiz_name"];
$quiz = post_curl(Array("quiz_name" => $_POST["quiz_name"], "type" => "get_quiz"), "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");

if (isset($_POST["publish"])) {
    $data = Array(
        "quiz_name" => $_POST["quiz_name"],
        "publish" => "TRUE",
        "type" => "publish_quiz"
    );
    $out = post_curl($data, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
    header("Location: view_grades.php");

} else if (isset($_POST["view"])) {
    if ($quiz[0]["answer"] === "NULL" || $quiz[0]["answer"] === null) {
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
                for ($i=0; $i < sizeof($quiz); $i++) {
                    $comments = $quiz[$i]["comments"];
                    // Split comments by ; delimiter
                    $comments = explode(";", $comments);
                    // remove empty elements
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

                    echo "<input type='hidden' name='questions[]' value='{$quiz[$i]["question"]}'>
                    <input type='hidden' name='answers[]' value='{$quiz[$i]["answer"]}'>";

                    echo "<div class='view-quiz-question'>
                    <h2>Q$i</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$quiz[$i]["question"]}</p>
                    <strong><label>Student Answer:</label></strong>
                    <pre><code>{$quiz[$i]["answer"]}</code></pre>
                    <strong><label>Points:</label></strong>
                    <input type='number' name='points[]' placeholder='Points' value='{$quiz[$i]["points"]}' max='{$quiz[$i]["maxpoints"]}' min='0' style='width: 55px'><br>
                    <strong><label>Comments:</label></strong>
                    <div contentEditable='true' class='textarea-input'  name='comments[]' placeholder='comments'>{$comments}</div>
                    </div>";
                }

                echo "<input type='submit' value='Submit'>
                </form>";
            } else {
                for ($i=0; $i < sizeof($quiz); $i++) {
                    echo "<div class='view-quiz-question'>
                        <strong><label>Question:</label></strong>
                        <p>{$quiz[$i]["question"]}</p>
                        <strong><label>Max Points:</label></strong>
                        <p>{$quiz[$i]["maxpoints"]}</p>
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
