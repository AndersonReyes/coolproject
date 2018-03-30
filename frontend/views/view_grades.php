<?php
$current_page = 'View Grades';
include_once "./../../utils/php_utils.php";

// TODO: Use this to query database
$data = Array("type" => "get_all_quiz");
$quizzes = post_curl($data, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
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
        <div class="editor-content" id="graded-quiz-table">
            <h3>Quiz List</h3>
            <table class="table">
                <tr>
                    <th>quiz name</th>
                    <th>View quiz</th>
                    <th>Publish</th>
                    <th>Delete</th>

                </tr>

                <?php
                foreach ($quizzes as $quiz_name => $quiz_info) {
                    $published = $quiz_info["publish"];
                    $disable = "";
                    if ($published === "TRUE") {
                        $disable = "disabled";
                    }



                    echo "<form method='POST' action='view_quiz.php'>
                    <input type='hidden' name='quiz_name' value='{$quiz_name}'>

                    <tr>
                    <td>{$quiz_name}</td>
                    <td><input type='submit' name='view' value='view'></td>
                    <td><input type='submit' name='publish' value='publish' {$disable}></td></form>

                    <td>
                    <form class='no-css' method='POST' action='./frontend.php'>
                    <input type='hidden' name='quiz_name' value='{$quiz_name}'/>
                    <input type='hidden' name='type' value='delete_quiz'/>
                    <input type='submit' value='Delete'/>
                    </form>
                    </td>
                    </tr>
                    ";
                }

                ?>


            </table>
        </div>
    </div>


    <script type="text/javascript" src="../js/utils.js"></script>
    <script type="text/javascript">
    </script>

</body>
</html>
