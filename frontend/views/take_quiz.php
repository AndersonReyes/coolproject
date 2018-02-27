<?php 
$current_page = 'Take quiz';

// TODO: Use this to query database
$quiz = Array(
    "Q1" => Array(
        "question" => "hello world?",
        "points" => 10
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

    <?php include_once "header_student.php"?>

    <div class="app">
        <div class="container-single" id="view-quiz">
            
            <form method="POST" action="frontend.php">
                <?php 
                foreach ($quiz as $question => $info) {
                    echo "<div class='view-quiz-question'>
                    <h2>{$question}</h2>
                    <strong><label>Question:</label></strong>
                    <p>{$info['question']}</p>
                    <strong><label>Student Answer:</label></strong>
                    <textarea name='{$question}' class='textarea-input'></textarea>
                    </div>";
                }
                
                
                ?>
                <input style="margin: .5em .5em; margin: auto;" type="submit" value="Submit">
            </form>
        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    <script type="text/javascript">
    </script>
    
</body>
</html>