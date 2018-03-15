<?php

include_once "./../../utils/php_utils.php";

// Post the backend for the list of created questions
$arr = Array(
    "type" => "get_q"
);

// Receive json file with
$question_bank = post_curl($arr, "https://web.njit.edu/~krc9/coolproject/middle/middle_to_db.php");
?>

<div class="question-bank-container container">
    <div class="editor-content" id="question-editor">
        <h1>Question Editor</h1>

        <form id="add-q-form" method="POST" action="./frontend.php">
            <input type="hidden" name="type" value="add_q" />
            <textarea class="textarea-input" name="question" placeholder="Enter Question here" id="question-description"></textarea><br>
            <textarea class="textarea-input" name="testcases" placeholder="Testcases"></textarea>

            <div class="horizontal-btn-group">
                <!-- TODO: Create a difficulty dropdown here with medium, easy, hard -->
                <div id="difficulty-rank">
                    <select name="difficulty">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <input type="text" name="topic" placeholder="Topics">
            </div>


            <div class="horizontal-btn-group">
                <input type="submit" name="submit" value="Create"/>
                <button type="button" onclick="document.getElementById('add-q-form').reset()">Reset</button>
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
        <!-- <ul class="question-list" id="creator-question-list">
            <?php 
            // foreach ($question_bank as $q) {
            //     $q_cols = explode(";", $q);
            //     echo "<li><a>{$q_cols[0]}</a></li>";
            // }
            ?>
        </ul> -->

        <table class="table" id="creator-question-list" >
            <thead>
                <th>Question name</th>
                <th>Difficulty</th>
                <th>Topics</th>
            </thead>

            <?php 
            foreach ($question_bank as $q) {
                $q_cols = explode(";", $q);
                echo "<tr>
                <td>{$q_cols[0]}</td>
                <td>{$q_cols[1]}</td>
                <td name='topics'>{$q_cols[2]}</td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div>