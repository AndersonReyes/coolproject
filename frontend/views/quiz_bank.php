<?php $current_page = 'Quiz Bank'

include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$data = json_encode(Array(
    "request_type" => "read_quizzes"
));

// Receive json file with
$quizzes = post_curl($data, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");

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
                <h3>Quiz name</h3>
                <input class="text-input" type="text" placeholder="quiz name" id="quiz-creator-name"><br>

                <h3>Quiz Questions</h3>
                <ul class="question-list" id="quiz-questions-to-use">
                </ul>

                <div class="horizontal-btn-group">
                    <button>Create</button>
                    <button onclick="reset_question_list('quiz-questions-to-use', 'quiz-question-list')">Reset</button>
                </div>

                <h3>Created Quizzes</h3>
                <table class="table">
                    <tr>
                        <th>Quiz id</th>
                        <th>Quiz name</th>
                        <th>Max Points</th>
                        <th>Difficulty</th>
                    </tr>

                    <?php
                    foreach ($quizzes as $quiz => $info) {
                        echo "<tr onclick='display_graded_quiz(this, \"graded-quiz-questions-view\")'>
                          <td>{$info['quiz_id']}</td>
                          <td>{$info['max_points']}</td>
                          <td>{$info['difficulty']}</td>
                          <td><input type='checkbox'></td>
                        </tr>";
                    }
                    ?>

                    <tr>
                        <td>00001</td>
                        <td>Test Quiz1</td>
                        <td>100</td>
                        <td><input type="checkbox"></td>
                        
                    </tr>
                </table>
            </div>


            <div class="editor-content" id="question-list-container">
                <h1>Question List</h1>
                
                <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'question-list')"><br>
                <ul class="question-list" id="quiz-question-list" onclick="update_quiz_questions('quiz-question-list', 'quiz-questions-to-use')">
                    <li><label for="Question 1"><input type="checkbox" name="Question 1" value="Test Question 1">Test Question 1</label></li>
                    <li><label for="Question 2"><input type="checkbox" name="Question 2" value="Test Question 2">Test Question 2</label></li>
                </ul>
            </div>

        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>