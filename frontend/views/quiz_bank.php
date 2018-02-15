<?php $current_page = 'Quiz Bank' ?>

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

    <?php include_once "../components/header.php"; ?>

    <div class="app">
        <div class="quiz-bank-container container">
            <?php include_once "../components/quiz_creator.php"?>
            <?php include_once "../components/quiz_question_list.php"?>

        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    
</body>
</html>