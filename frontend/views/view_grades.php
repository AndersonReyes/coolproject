<?php 
$current_page = 'View Grades';

// TODO: Use this to query database
$graded_examzes = Array(
    "test_exam_name" => Array(
        "exam_id" => 12345,
        "student_id" => 99999,
        "exam_name" => "test_exam_name",
        "grade" => 100
    ),

    "test_exam_name1" => Array(
        "exam_id" => 12345,
        "student_id" => 99999,
        "exam_name" => "test_exam_name",
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
        <div class="" id="exam-grades">
            <div class="editor-content" id="graded-exam-table">
                <h3>Published exam List</h3>
                <table class="table">
                    <tr>
                        <th>Student id</th>
                        <th>exam name</th>
                        <th>Grade</th>
                        <th>View exam</th>
                        <th>Published</th>
                    </tr>
                    
                    <?php 
                    foreach ($graded_examzes as $key => $value) {
                        echo "<form method='POST' action='view_exam.php'>
                        <input type='hidden' name='student_id' value='{$value['student_id']}'>
                        <input type='hidden' name='exam_name' value='{$value['exam_name']}'>

                        <tr>
                        <td>{$value['student_id']}</td>
                        <td>{$value['exam_name']}</td>
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