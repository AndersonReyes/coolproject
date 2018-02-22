<?php

include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$arr = Array(
    "request_type" => "read_questions"
);

// Receive json file with
// $question_bank = post_curl(json_encode($arr), "https://web.njit.edu/~ar579/coolproject/frontend/views/frontend.php");

$question_bank = Array(
    "test q 1" => Array(
        "question" => "hello world?"
    )
);

?>

<div class="question-bank-container container">
    <div class="editor-content" id="question-editor">
        <h1>Question Editor</h1>

        <form method="POST" action="./frontend.php">
            <input type="hidden" name="curl_type" value="create_question" />
            <input type="text" name="question_alias" placeholder="question name alias"><br>
            <textarea class="textarea-input" name="question" placeholder="Enter Question here" id="question-description"></textarea><br>

            <textarea class="textarea-input" name="question_correctness" placeholder="Enter code to test correctness of question here" id="question-testcorrectness-area"></textarea><br>

            <div class="horizontal-btn-group">
                <!-- TODO: Create a difficulty dropdown here with medium, easy, hard -->
                <div id="difficulty-rank">
                    <select name="difficulty">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <input type="number" name="question_points" placeholder="Points" style="width: 55px">
                <input type="text" name="question_topics" placeholder="Topics">
            </div>


            <div class="horizontal-btn-group">
                <input type="submit" name="submit" value="Create"/>
                <button>Reset</button>
            </div>
        </form>

    </div>

    <div class="editor-content" id="question-list-container">
        <h1>Question List</h1>
        
        <input type="text" class="text-input" id="question-list-seach-box" placeholder="Search Question" onkeyup="search_query(this.value.toLowerCase(), 'creator-question-list')"><br>
        <ul class="question-list" id="creator-question-list">
            <li><a>Test Question: Create a function that multiplies two numbers</a></li>
            <?php 
            foreach ($question_bank as $q => $info) {
                echo "<li><a>{$info['question']}</a></li>";
            }
            ?>
        </ul>
    </div>
</div>