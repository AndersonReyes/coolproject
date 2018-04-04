<?php
$current_page = 'Edit Quiz';
include_once "./../../utils/php_utils.php";

$quiz_name = $_POST["quiz_name"];
$arr = Array(
    "type" => "get_quiz",
    "quiz_name" => $quiz_name
);

$get_questions = Array(
    "type" => "get_q"
);

// Receive json file with
$question_bank = post_curl($get_questions, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");

$quiz_questions = post_curl($arr, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");

$checked_questions = Array();
foreach ($quiz_questions as $question) {
    array_push($checked_questions, $question["question"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/style.css" rel="stylesheet">
    <title>quiz Bank</title>
</head>
<body>

    <?php include_once "./header.php"; ?>

    <div class="app">
        <div class="quiz-bank-container container">

            <div class="editor-content" id="quiz-editor">
                <h1>quiz Editor</h1>
                <form method="POST" action="#">
                    <input type="hidden" name="type" value="update_quiz">
                    <input type="hidden" name="publish" value="FALSE">
                    <input class="text-input" name="quiz_name" value="<?php echo $quiz_name; ?>" type="text" placeholder="quiz name" id="quiz-creator-name"><br>

                    <label>quiz Questions</label>
                    <ul class="question-list" id="quiz-questions-to-use">
                        <?php
                        foreach($quiz_questions as $question) {
                            echo "<li>" . $question["question"] . "
                            <input type='hidden' name='questions[]' value='{$question["question"]}'/>
                            <input type='number' style='width: 50px; margin-left: 1em;' name='max_points[]' value='{$question["maxpoints"]}'/>
                            </li>";
                        }


                        ?>
                    </ul>

                    <div class="horizontal-btn-group">
                        <input type="submit" value="Update"></input>
                        <button type="button" onclick="reset_question_list('quiz-questions-to-use', 'quiz-question-list')">Reset</button>
                    </div>

                </form>
            </div>


            <div class="editor-content" id="question-list-container">
                <h1>Question List</h1>

                <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_questions()"><br>
		 <div id="difficulty-rank">
			<select id="difficulty_search" onchange="search_questions()">
   				<option value="all">all</option>
				<option value="easy">Easy</option>
			     	<option value="medium">Medium</option>
				<option value="hard">Hard</option>
			</select>
		</div><br>


                <table class="table" id="creator-question-list" onclick="add_quiz_questions()">
                    <thead>
                        <th>Use question</th>
                        <th>Question name</th>
                        <th>Difficulty</th>
                        <th>Topics</th>
                    </thead>

                    <?php
                    foreach ($question_bank as $q) {
                        $q_cols = explode(";", $q);
                        $question_name = $q_cols[0];
                        $question_diff = $q_cols[1];
                        $topics = $q_cols[2];

                        $checked = "";
                        if (in_array($question_name, $checked_questions)) {
                            $checked = "checked";
                        }

                        echo "<tr>
                        <td><input style='transform: scale(1.5);' type='checkbox' name='{$question_name}' value='{$question_name}' {$checked}></td>
                        <td name='{$question_name}'>{$question_name}</td>
                        <td>{$question_diff}</td>
                        <td name='topics'>{$topics}</td>
                        </tr>";
                    }

                    ?>
                </table>
            </div>

        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>

</body>
</html>
