<?php 
$current_page = 'View quiz';
include_once "./../../utils/php_utils.php";

$data = Array("type" => "get_quiz", "quiz_name" => $_POST["quiz_name"]);
$questions = post_curl($data, "https://web.njit.edu/~ar579/coolproject/backend/database.php");

if (isset($_POST["publish"])) {
    $arr = Array("type" => "publish_quiz", "quiz_name" => $_POST["quiz_name"]);
    // post_curl($arr, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
    header("Location: view_grades.php");
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
                // foreach ($test_data_questions as $question => $info) {
                //     echo "<div class='view-quiz-question'>
                //     <h2>{$question}</h2>
                //     <strong><label>Question:</label></strong>
                //     <p>{$info['question']}</p>
                //     <strong><label>Student Answer:</label></strong>
                //     <pre><code>{$info['answer']}</code></pre>
                //     <strong><label>Points:</label></strong>
                //     <input type='number' name='question_points' placeholder='Points' value='{$info['points']}' style='width: 55px'><br>
                //     <strong><label>Comments:</label></strong>
                //     <textarea class='textarea-input'  name='comments' placeholder='comments'></textarea>
                //     </div>";
                // }
            } else {
                for ($i=0; $i < 4; $i++) {
                    $question = explode(";", $questions[$i])[0];
                    $points = explode(";", $questions[$i])[1];

                    echo "<div class='view-quiz-question'>
                        <strong><label>Question:</label></strong>
                        <p>{$question}</p>
                        <strong><label>Points:</label></strong>
                        <input type='number' name='question_points' placeholder='Points' value='{$points}' style='width: 55px'><br>
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