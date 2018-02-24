<?php 
$current_page = 'View Grades';

// TODO: Use this to query database
$all_examzes = Array(
    "test_exam_name" => Array(
        "exam_id" => 12345,
        "student_id" => 99999,
        "exam_name" => "test_exam_name",
        "taken" => TRUE,
        "graded" => FALSE,
        "grade" => NULL
    ),

    "test_exam_name1" => Array(
        "exam_id" => 12345,
        "student_id" => "dsfsdfsdf",
        "exam_name" => "test_exam_name2",
        "taken" => TRUE,
        "graded" => TRUE,
        "grade" => 100
    ),

    "test_exam_name3" => Array(
        "exam_id" => 00000,
        "student_id" => 11111,
        "exam_name" => "test_exam_name3",
        "taken" => FALSE,
        "graded" => FALSE,
        "grade" => NULL
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
        <div class="" id="exam-grades">
            <div class="editor-content" id="graded-exam-table">
                <h3>Published exam List</h3>
                <table class="table">
                    <tr>
                        <th>Student id</th>
                        <th>exam name</th>
                        <th>Grade</th>
                        <th></th>
                    </tr>
                    
                    <?php 
                    foreach ($all_examzes as $key => $value) {
                        $end = "";
                        $post_url = "#";

                        // only display view button if there is a grade
                        if ($value['graded']) {
                            $post_url = "view_exam_student.php";
                            $end = "
                            <td><input type='submit' value='VIEW'></td>
                            </tr>
                            </form>";
                        } else if (!$value['graded'] && $value['taken']) {
                            $end = "
                            <td>Still grading</td>
                            </tr>
                            </form>";
                        } else if (!$value['graded'] && !$value['taken']) {
                            $post_url = "take_exam.php";
                            $end = "
                            <td><input type='submit' value='TAKE'></td>
                            </tr>
                            </form>";
                        }

                        $tb_row = "<form method='POST' action='{$post_url}'>
                        <input type='hidden' name='student_id' value='{$value['student_id']}'>
                        <input type='hidden' name='exam_name' value='{$value['exam_name']}'>
                        <tr>
                        <td>{$value['student_id']}</td>
                        <td>{$value['exam_name']}</td>
                        <td>{$value['grade']}</td>". $end;

                        echo $tb_row;
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