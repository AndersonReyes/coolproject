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
            <textarea class="textarea-input" name="testcases" placeholder="Testcases" id="testcases-input"></textarea>

            <div class="horizontal-btn-group">
                <!-- TODO: Create a difficulty dropdown here with medium, easy, hard -->
                <div id="difficulty-rank">
                    <select name="difficulty" id="difficulty-select">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <input type="text" name="topic" placeholder="Topics" id="topics-input">
            </div>


            <div class="horizontal-btn-group">
                <input id="submit_btn" type="submit" name="submit" value="Create"/>
                <button type="button" onclick="document.getElementById('add-q-form').reset(); document.getElementById('submit_btn').value = 'Create'">Reset</button>
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

        <table class="table" id="creator-question-list" >

            <thead>
                <th>Question name</th>
                <th>Difficulty</th>
                <th>Topics</th>
                <th>Test cases</th>
                <th>Delete</th>
            </thead>

            <?php
            foreach ($question_bank as $q) {
                $q_cols = explode(";", $q);
                $testcases = implode(";", array_slice($q_cols, 3));
                echo "<tr>
                <input type='hidden' name='old_question_name' value='{$q_cols[0]}'/>
                <input type='hidden' name='old_difficulty' value='{$q_cols[1]}'/>
                <input type='hidden' name='old_topics' value='{$q_cols[2]}'/>
                i<input type='hidden' name='old_testcases' value='{$testcases}'/>
                <td>{$q_cols[0]}</td>
                <td>{$q_cols[1]}</td>
                <td name='topics'>{$q_cols[2]}</td>
                <td name='testcases'>{$testcases}</td>
                <td><form class='no-css' method='POST' action='./frontend.php'>
                <input type='hidden' name='type' value='delete_q'/>
                <input type='hidden' name='question' value='{$q_cols[0]}'/>
                <input type='submit' value='Delete'/>
                </form></td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div>
