<?php
// TODO: Query the middle for the quiz info andyput it in the below array
// print_r($_POST);
$quiz_questions = Array(
    "Q1" => Array(
        "quiz_id" => 12345,
        "question_number" => 1,
        "question" => "How are you?",
        "test_code" => "def(): return True",
        "student_answer" => "def boolen_func(): return True;",
        "points" => 10.0,
        "grade" => 5.0,
        "difficulty" => "easy"
    ),
    "Q2" => Array(
        "quiz_id" => 12345,
        "question_number" => 2,
        "question" => "Who are you?",
        "test_code" => "def():return True",
        "student_answer" => "def boolen_func(): return True;",
        "points" => 10.0,
        "grade" => 7.0,
        "difficulty" => "medium"
    ),
    "Q3" => Array(
        "quiz_id" => 12345,
        "question_number" => 3,
        "question" => "Who are you?",
        "test_code" => "def(): return True",
        "student_answer" => "def boolen_func(): return True;",
        "points" => 10.0,
        "grade" => 7.0,
        "difficulty" => "medium"
    )
    );

?>

<h3>Quiz Question Grades</h3>
<!-- TODO: Display the questions and  the grade for that student here -->
<div class='graded-quiz-question-list'>
    <?php     
    foreach ($quiz_questions as $key => $value) {
        echo "<div class='graded-quiz-question'><h4>Q#{$value['question_number']}<br>{$value['question']}</h4>
                <label>Student Answer:</label><br>
                <pre><code class='student-answer'>{$value['student_answer']}</code></pre>

                <div class='horizontal-btn-group'>
                    <label>Grade: <input type='number' style='width: 55px;' value='{$value['grade']}'></label>
                    <label>Points: {$value['points']}</label>
                </div><hr />
            </div>";
    }

    echo "<div class='horizontal-btn-group'>
            <button>Save Changes</button>
            <button>Discard Changes</button>
        </div>"

    ?>
</div>