<?php 
$current_page = 'View Grades';

// TODO: Use this to query database
$graded_quizzes = Array(
    "test_quiz_name" => Array(
        "quiz_id" => 12345,
        "student_id" => 99999,
        "quiz_name" => "test_quiz_name",
        "grade" => 100
    ),

    "test_quiz_name1" => Array(
        "quiz_id" => 12345,
        "student_id" => 99999,
        "quiz_name" => "test_quiz_name",
        "grade" => 100
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
    <title>View Grades</title>
</head>
<body>

    <?php include_once "./header.php"; ?>

    <div class="app">
        <div class="" id="quiz-grades">
            <div class="editor-content" id="graded-quiz-table">
                <h3>Published Quiz List</h3>
                <table class="table">
                    <tr>
                        <th>Student id</th>
                        <th>Quiz name</th>
                        <th>Grade</th>
                        <th>View Quiz</th>
                        <th>Published</th>
                    </tr>
                    
                    <?php 
                    foreach ($graded_quizzes as $key => $value) {
                        echo "<form method='POST' action='view_quiz.php'>
                        <input type='hidden' name='student_id' value='{$value['student_id']}'>
                        <input type='hidden' name='quiz_name' value='{$value['quiz_name']}'>

                        <tr>
                        <td>{$value['student_id']}</td>
                        <td>{$value['quiz_name']}</td>
                        <td>{$value['grade']}</td>
                        <td><input type='submit' value='view'></td>
                        <td><input type='checkbox'></td>
                        </tr>
                        </form>";
                    }

                    ?>


                </table>
            </div>            
        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    <script type="text/javascript">
    </script>
    
</body>
</html>