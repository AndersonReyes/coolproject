<?php 
$current_page = 'exam Bank';
include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$data = json_encode(Array(
    "type" => "get_all_examzes"
));

// Receive json file with
// $examzes = post_curl($data, "https://web.njit.edu/~ar579/coolproject/middle/middleLogin.php");

$test_data_questions = Array(
    "test q 1" => Array(
        "question" => "hello world?",
    ),

    "test q 2" => Array(
        "question" => "hello world yes?",
    )
);

$test_data_exam = Array(
    "test exam 1" => Array(
        "exam_name" => "test exam",
        "max_points" => 100,
        "published" => TRUE
    ),
    
    "test exam 2" => Array(
        "exam_name" => "test exam 2",
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
    <title>exam Bank</title>
</head>
<body>

    <?php include_once "./header.php"; ?>

    <div class="app">
        <div class="exam-bank-container container">
            
            <div class="editor-content" id="question-editor">
                <h1>exam Editor</h1>
                <form method="POST" action="frontend.php">
                    <input type="hidden" name="type" value="add exam">
                    <input class="text-input" name="exam_name" type="text" placeholder="exam name" id="exam-creator-name"><br>

                    <label>exam Questions</label>
                    <ul class="question-list" id="exam-questions-to-use">
                    </ul>

                    <div class="horizontal-btn-group">
                        <input type="submit" value="Create"></input>
                        <button type="button" onclick="reset_question_list('exam-questions-to-use', 'exam-question-list')">Reset</button>
                    </div>

                    <h3>Created examzes</h3>
                    <table class="table">
                        <tr>
                            <th>exam name</th>
                            <th>published</th>
                        </tr>

                        <?php
                        foreach ($test_data_exam as $exam => $info) {
                            $checked = "";
                            if($info['published']) {
                                echo $checked = "checked";
                            }

                            echo "<tr'>
                            <td>{$info['exam_name']}</td>
                            <td><form method='POST' action='#'><input type='submit' name='publish' value='publish'></form></td>
                            </tr>";
                        }
                        ?>
                    </table>
                </form>
            </div>


            <div class="editor-content" id="question-list-container">
                <h1>Question List</h1>
                
                <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'question-list')"><br>
                <ul class="question-list" id="exam-question-list" onclick="update_exam_questions('exam-question-list', 'exam-questions-to-use')">

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