<?php 
$current_page = 'Quiz Bank';
include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$data = json_encode(Array(
    "type" => "get_all_quizzes"
));

// Receive json file with
// $quizzes = post_curl($data, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");

$test_data_questions = Array(
    "test q 1" => Array(
        "question" => "hello world?",
    ),

    "test q 2" => Array(
        "question" => "hello world yes?",
    )
);

$test_data_quiz = Array(
    "test quiz 1" => Array(
        "quiz_name" => "test quiz",
        "max_points" => 100,
        "published" => TRUE
    ),
    
    "test quiz 2" => Array(
        "quiz_name" => "test quiz 2",
        "max_points" => 10,
        "published" => FALSE
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
    <title>Quiz Bank</title>
</head>
<body>

    <?php include_once "./header.php"; ?>

    <div class="app">
        <div class="quiz-bank-container container">
            
            <div class="editor-content" id="question-editor">
                <h1>Quiz Editor</h1>
                <form method="POST" action="./frontend.php">
                    <input type="hidden" name="type" value="create_quiz">
                    <input class="text-input" name="quiz_name" type="text" placeholder="quiz name" id="quiz-creator-name"><br>

                    <label>Quiz Questions</label>
                    <ul class="question-list" id="quiz-questions-to-use">
                    </ul>

                    <div class="horizontal-btn-group">
                        <input type="submit" value="Create"></input>
                        <button onclick="reset_question_list('quiz-questions-to-use', 'quiz-question-list')">Reset</button>
                    </div>

                    <h3>Created Quizzes</h3>
                    <table class="table">
                        <tr>
                            <th>Quiz name</th>
                            <th>published</th>
                        </tr>

                        <?php
                        foreach ($test_data_quiz as $quiz => $info) {
                            $checked = "";
                            if($info['published']) {
                                echo $checked = "checked";
                            }

                            echo "<tr'>
                            <td>{$info['quiz_name']}</td>
                            <td><input type='checkbox' {$checked}></td>
                            </tr>";
                        }
                        ?>
                    </table>
                </form>
            </div>


            <div class="editor-content" id="question-list-container">
                <h1>Question List</h1>
                
                <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'question-list')"><br>
                <ul class="question-list" id="quiz-question-list" onclick="update_quiz_questions('quiz-question-list', 'quiz-questions-to-use')">

                    <?php
                    foreach ($test_data_questions as $question => $info) {
                            echo "<li>
                            <label for='{$question}'>
                            <input type='checkbox' name='{$question}' value='{$info['question']}'>{$info['question']}</label>
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