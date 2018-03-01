<?php
/**
 * Created by PhpStorm.
 * User: kendycolon
 * Date: 2/22/18
 * Time: 10:22 AM
 */

/* DEBUGGING CALLS BEGIN*/
/*
$questions=array();
$responses=array();

for($i=0; $i<4; $i++){
    $questions[$i]="write a function named add that with variables number1 and number2 : as parameters, and that that returns [sum] with the sum of the numbers.";
    $responses[$i]="
def add(number1, number2):
    sum = number1+number2;
    return sum;



print add(106,15);
";
}

$place = GRADE_FULL_EXAM($questions, $responses);
echo "FINAL GRADE #: ".$place[4]."\n";
*/

/* DEBUGGING CALLS END*/


/*
 * PLEASE SEND THE PROFESSOR QUESTION AS AN ARRAY WITH INDEX INT AND VALUE = QUESTION
 * SAME FOR THE STUDENT RESPONSE
 */
function GRADE_FULL_EXAM($full_exam, $student_responses){

    //ARRAY THAT HOLDS THE COMMENTS FOR EACH QUESTION AND FINAL GRADE
    $FULLL_GRADED_EXAM_COMMENTS= array();

    //FINAL GRADE COUNTER
    $exam_final_grade=0;

    for($x=0; $x<4; $x++){
        $PROFESSOR_SINGLE_QUESTION = $full_exam[$x];
        $STUDENT_SINGLE_QUESTION_RESPONSE = $student_responses[$x];

        $professor_single_question_holder_file = fopen("https://web.njit.edu/~krc9/coolproject/middle/prof_question_holder.txt", "w") or die("Unable to open file!");
        fwrite($professor_single_question_holder_file, $PROFESSOR_SINGLE_QUESTION);
        fclose($professor_single_question_holder_file);

        $student_single_question_holder_file = fopen("https://web.njit.edu/~krc9/coolproject/middle/runner1.py", "w") or die("Unable to open file!");
        fwrite($student_single_question_holder_file, $STUDENT_SINGLE_QUESTION_RESPONSE);
        fclose($student_single_question_holder_file);

        $FULLL_GRADED_EXAM_COMMENTS[$x] = grade_exam("prof_question_holder.txt", "runner1.py");
        $exam_final_grade += $FULLL_GRADED_EXAM_COMMENTS[$x]["Question_Final_Grade"];
        // echo "CURRENT GRADE:".$exam_final_grade."\n";

    }
    /*
     * FINAL GRADE FOR THE EXAM IS AT THE END OF ARRAY ->> 4
     */
    $FULLL_GRADED_EXAM_COMMENTS[4]=$exam_final_grade;

    // Curl database
    $dbpost = curl_init();
    curl_setopt($dbpost, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
    curl_setopt($dbpost, CURLOPT_POST, 1);
    curl_setopt($dbpost, CURLOPT_POSTFIELDS, $FULLL_GRADED_EXAM_COMMENTS);
    curl_setopt($dbpost, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($dbpost, CURLOPT_RETURNTRANSFER, 1);
    $result = json_decode(curl_exec($dbpost), true);

    if ($result === FALSE) {
        echo "error: " . curl_error($dbpost);
        echo "curl info: " . curl_getinfo($dbpost);
    }
    curl_close($dbpost);





    /**
    // TO GET ALL THE VARIABLES ON THE VARIABLE ARRAY USE implode
    $variables_inArray = implode ($question_params["variables"]);
    echo $variables_inArray; */


}

//grade_exam("prof_question_holder.txt","run.py");


function grade_exam($PROFESSOR_EXAM_QUESTIONS, $STUDENT_QUESTION_RESPONSE){

    $QUESTION_PARAMETERS = get_GradingParameters($PROFESSOR_EXAM_QUESTIONS);

    /* PYTHON FILE CONTAINING  STUDENT'S CODE FOR GRADING AND EXECUTION */
    $file_name = $STUDENT_QUESTION_RESPONSE;
    $filetoGrade = fopen("/~krc9/coolproject/middle/pythonprograms/" . $file_name, "r") or die("Unable to open file!");

    /**
     * RAW STRINGS TO LOOK FOR
     */
    $final_grade = 0;

    $function_name = $QUESTION_PARAMETERS["function_name"];
    $parameters_variables = $QUESTION_PARAMETERS["variables"];
    $finalOuput_ = $QUESTION_PARAMETERS["expected_output"];
    $return_name = $QUESTION_PARAMETERS["return_name"];

    $GRADE_COMMENTS= array();
    //$question_id="01";

    //  echo "Function_name: ".$function_name." Variables: ".$parameters_variables[0]." Output: ".$finalOuput_." Return_name: ".$return_name."\n";



    /**
     * PATTERN SETUP FOR THE REGEX EXPRESSIONS
     */

// REGEX PATTERN FOR THE FUNCTION NAME SEARCH
    $function_pattern = '/def ' . $function_name . '[(]/';

// REGEX PATTERN FOR THE FUNCTION PARAMETERS
    $paramaters_pattern = '/[(]' . $parameters_variables[0] . '[)]:/';

// REGEX PATTERN FOR THE FUNCTION RETURN VARIABLE
    $return_pattern = '/return ' . $return_name . '[;]/';

// REGEX PATTERN FOR THE FINAL OUTPUT
    $finalOutput_pattern = '/' . $finalOuput_ . '/';

    /**
     * END OF PATTERNS SETUP
     */


    //echo "************** STARTING GRADING PROCESS..... ******************" . "\n";

    /**
     * BEGINNING OF THE GRADING PROCESS
     */
    if ($filetoGrade) {
        while (($current_line = fgets($filetoGrade)) !== false) {

            //CHECK FOR FUNCTION NAME
            if (preg_match($function_pattern, $current_line)) {
                $final_grade += 10;
                $GRADE_COMMENTS["Correct_Function"]="Function name is correct +10";
                //echo "Function matched: " . $current_line . "\n";

            }
            //CHECK FOR PARAMETERS NAMES
            if (preg_match($paramaters_pattern, $current_line)) {
                $final_grade += 10;
                $GRADE_COMMENTS["Correct_Parameters"]="Parameters variables correct +10";
                //echo "Parameters Matched: " . $current_line . "\n";
            }
            //CHECK FOR RETURN
            if (preg_match($return_pattern, $current_line)) {
                $final_grade += 5;
                $GRADE_COMMENTS["Correct_Return"]="Returned correct variable +5";
               // echo "Return Matched: " . $current_line . "\n";
            }
        }
        //CLOSE THE FILE AFTER READING ALL LINES
        fclose($filetoGrade);
    }

    /**
     *  CREATE AND EXECUTE STUDENT'S CODE ON THE SERVER TO SEE IF IT WORKS AND WHATS THE OUPUT
     */
    $command = escapeshellcmd('python /~krc9/coolproject/middle/pythonprograms/' . $file_name);
    $output = shell_exec($command);

    if (preg_match($finalOutput_pattern, $output)) {
        $final_grade += 50;
        $GRADE_COMMENTS["Correct_Output"]="Output was correct +50";
        //echo "FINAL OUTPUT MATCHED: " . $output;
    }

    $GRADE_COMMENTS["Question_Final_Grade"]=$final_grade;
    return $GRADE_COMMENTS;
    //echo "\n" . "Final Grade: " . $final_grade;



}//END OF EXAM GRADER FUNCTION

/**
 * Created by PhpStorm.
 * User: kendycolon
 * Date: 2/27/18
 * Time: 1:59 PM
 */


//$current_line ="write a function named add that with variables x, y and z : as parameters, and that prints [theouputOGisHere]";
/*
 *  @ATTENTION
 *  #----------> PROFESSOR'S QUESTION MOST FALLOW THESE STANDARDS FOR PROPER GRADING <-------------#
 *  1. THE FUNCTION NAME SHOULD BE GIVEN AFTER THE WORD NAMED ex: a function named anything
 *  2. IF THE QUESTION REQUIRES MORE THAN ONE VARIABLES PLEASE MAKE USE OF CORRECT GRAMMAR
 *      ex: with variable x that does something or ex2: with variables x, y and z that do something..
 *  3. AFTER ALL VARIABLES OR SINGLE VARIABLE IS REQUESTED PLEASE USE :
 *  4. FOR THE EXPECTED OUTPUT OF FUNCTION X PLEASE USE PROVIDE THE OUTPUT WITHIN [ OUTPUT HERE ]
 *  5. IF THE FUNCTION DOESN'T PRINT BUT RETURNS SOMETHING PLEASE WRITE RETURN VARIABLE NAME WITHIN [ VARIABLENAME ]
 */


function get_GradingParameters($question_file_name){
    /*
     * CURRENT BUGS
     *  1. There's a bug is parameters are given as param1 and param2: program wont get any variable
     *  BUT if they are given as param1 and param2 : it works.
     *  WOULD FIX IT SOON
     */

    $QUESTION_PARAMS_ARRAY = array("function_name"=> "","variables"=>"","expected_output"=>"","return_name"=>"");
    $variables_array = array();
    $variables_array_items_count=0;


    //  $current_line = "";

    $function_name_pattern = '/function named ' . '.*' . ' [t]/';
    $variables_names_pattern = '/variable'.'s? ' . '.*' . ' [:]/';
    $expected_output_pattern= '/that prints '.'.*'.'./';
    $return_pattern= '/that returns '.'.*'.'./';

    /* OPEN THE INCOMING FILE TO START LOOK UP PROCESS */
    $file_name = $question_file_name;
    $question_file = fopen("/~krc9/coolproject/middle/pythonprograms/" . $file_name, "r") or die("Unable to open file!");

    if ($question_file) {
        while (($current_line = fgets($question_file)) !== false) {

            /*  THIS LOOKS FOR THE GIVEN FUNCTION NAME */
            if (preg_match($function_name_pattern, $current_line)) {
                $current_line_splitter = explode(" ", $current_line);

                for ($x = 0; $x < count($current_line_splitter); $x++) {
                    if ($current_line_splitter[$x] == "named") {
                        $function_name_finder = $current_line_splitter[$x + 1];
                        //echo "Function Name Found: ".$function_name_finder . "\n";
                        $QUESTION_PARAMS_ARRAY["function_name"]=$function_name_finder;

                    }
                }
            }//END OF FUNCTION NAME FINDER

            /*   THIS LOOKS FOR THE GIVEN VARIABLES NAMES */
            if (preg_match($variables_names_pattern, $current_line)) {
                $current_line_splitter = explode(" ", $current_line);
                // $current_line_splitter[0]."\n";
                //$current_line_splitter = explode(",", $current_line_splitter);

                for ($x = 0; $x < count($current_line_splitter); $x++) {

                    //echo "ESPLIT VALUE: ".$current_line_splitter[$x]."\n";
                    if ($current_line_splitter[$x]=="variable") {
                        // echo "Single Variable..."."\n";
                        $variables_array[0]= $current_line_splitter[$x+1];
                        //echo "Found Single variable: ".$variables_array[0]. "\n";
                        $QUESTION_PARAMS_ARRAY["variables"]=$variables_array;
                    }
                    if ($current_line_splitter[$x] == "variables") {
                        for($i=0; $i<(count($current_line_splitter)-($x)); $i++){
                            if($current_line_splitter[$x+$i+1] !="and"){
                                if($current_line_splitter[$x+$i+1] ==":"){
                                    break;
                                }else {
                                    /**
                                     * BEFORE ADDING THE VARIABLE TO THE ARRAY REPLACE ANYTHING THAT IS
                                     * NOT AN ALPHANUMERIC CHARACTER
                                     */
                                    $variables_array[$variables_array_items_count]=preg_replace("/[^A-Za-z0-9 ]/","",$current_line_splitter[$x + $i + 1])." ";
                                    /* echo "Index: ".($variables_array_items_count)." Values: "
                                         .$variables_array[$variables_array_items_count] . "\n";*/
                                    $variables_array_items_count++;

                                    $QUESTION_PARAMS_ARRAY["variables"]=$variables_array;
                                }
                            }
                        }
                    }
                }
            }//END OF VARIABLE FINDER

            /** THIS ITS ON THE LOOK FOR THE OUTPUT GIVEN BY THE PROFESSOR */
            if (preg_match($expected_output_pattern, $current_line)) {
                /**
                 * expected output holds the output given by the professor
                 * THE OUTPUTS MOST BE GIVEN WITHING SQUARE BRACKETS BY THE PROFESSOR [ EXPECTED OUTPUT HERE ]
                 * start finds the index of first [ AND end_cut finds the closing ]
                 * limits calculates the length of the output string
                 */
                $start=strpos($current_line, "[");
                $end_cut=strpos($current_line, "]");
                $limits = $end_cut-$start;

                //echo "start:".$start." End:".$end_cut." Limits:".$limits."\n";

                $expected_output = substr ( $current_line ,  $start+1 , $limits-1 );
                //trim DELETES SPACE AT THE BEGINNING AND END OF STRINGS
                $expected_output= trim($expected_output);
                //echo "Found Expected output:" . $expected_output ."\n";
                $QUESTION_PARAMS_ARRAY["expected_output"]=$expected_output;
            }//END OF OUTPUT FINDER

            /** THIS ITS ON THE LOOK FOR THE RETURN NAME IF ANY  */
            if (preg_match($return_pattern, $current_line)) {

                $start=strpos($current_line, "[");
                $end_cut=strpos($current_line, "]");
                $limits = $end_cut-$start;

                //echo "start:".$start." End:".$end_cut." Limits:".$limits."\n";

                $expected_return_name = substr ( $current_line ,  $start+1 , $limits-1 );
                //trim DELETES SPACE AT THE BEGINNING AND END OF STRINGS
                $expected_return_name= trim($expected_return_name);
                //echo "Found Expected return name:" . $expected_output ."\n";
                $QUESTION_PARAMS_ARRAY["return_name"]=$expected_return_name;
            }//END OF OUTPUT FINDER

        }
    }
    fclose($question_file);
    return $QUESTION_PARAMS_ARRAY;
}//END OF FUNCTION






?>
