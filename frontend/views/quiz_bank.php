<?php 
$current_page = 'quiz Bank';
include_once "./../../utils/php_utils.php";

$arr = Array(
    "type" => "get_q"
);

// Receive json file with
$question_bank = post_curl($arr, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");

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
                <form method="POST" action="frontend.php">
                    <input type="hidden" name="type" value="add_quiz">
                    <input type="hidden" name="publish" value="FALSE">
                    <input class="text-input" name="quiz_name" type="text" placeholder="quiz name" id="quiz-creator-name"><br>

                    <label>quiz Questions</label>
                    <ul class="question-list" id="quiz-questions-to-use">
                    </ul>

                    <div class="horizontal-btn-group">
                        <input type="submit" value="Create"></input>
                        <button type="button" onclick="reset_question_list('quiz-questions-to-use', 'quiz-question-list')">Reset</button>
                    </div>

                </form>
            </div>


            <div class="editor-content" id="question-list-container">
                <h1>Question List</h1>
                
                <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'quiz-question-list')"><br>
                <ul class="question-list" id="quiz-question-list" onclick="update_quiz_questions('quiz-question-list', 'quiz-questions-to-use')">

                    <?php
                    foreach ($question_bank as $q) {
                        $q_cols = explode(";", $q);
                        echo "<li>
                        <label for='{$q_cols[0]}'>
                        <input type='checkbox' name='{$q_cols[0]}' value='{$q_cols[0]}'>{$q_cols[0]}</label>
                        </li>";
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>