<?php $current_page = 'View Grades' ?>

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

    <?php include_once "../components/header.php"; ?>

    <div class="app">
        <div class="quiz-bank-container container">
            <div class="editor-content" id="graded-quiz-table">
                <h3>Published Quiz List</h3>
                <table class="table" onclick="display_graded_quiz('')">
                    <tr>
                        <th>Student id</th>
                        <th>Quiz name</th>
                        <th>Grade</th>
                    </tr>

                    <tr>
                        <td>00001</td>
                        <td>Test Quiz</td>
                        <td>100</td>
                    </tr>
                </table>
            </div>


            <div class="editor-content" id="graded-quiz-questions-view">
                <h3>Quiz Question Grades</h3>
                <!-- TODO: Display the questions and  the grade for that student here -->
            </div>
        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>