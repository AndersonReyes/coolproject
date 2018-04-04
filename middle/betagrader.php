<?php
/**
 * Created by PhpStorm.
 * User: kendycolon
 * Date: 2/22/18
 * Time: 10:22 AM
 */

/*
 * INCOMING DATA FROM ANDERSON
 * quiz_name, comments, points, answers, max_quiz_points
 * ARRAY OF VALUES TO HOLD THE VALUES
 */

$quiz_name = $_POST['quiz_name'];
$question_worth = $_POST['points'];
$questions = $_POST['questions'];
$student_answer= $_POST['answers'];
$quiz_max_points= $_POST['max_quiz_points'];
$testcases  = $_POST['testcases'];

//GRADE THE FUadsdL QUIZ
$_POST['FULLL_GRADED_EXAM_COMMENTS'] = GRADE_FULL_EXAM($quiz_name, $questions, $student_answer,$question_worth, $quiz_max_points, $testcases);
$_POST["type"] = "update_quiz";
//echo "Final grade: ".$_POST['FULLL_GRADED_EXAM_COMMENTS'][4];
$_POST["GRADE"] = GRADE_FULL_EXAM($quiz_name, $questions, $student_answer,$question_worth, $quiz_max_points, $testcases);
//POST THE ARRAY $_POST THAT CONTAINS ALL THE GRADE DATA TO THE BACKEND
echo "<br><br>";
$backendpost = curl_init();
curl_setopt($backendpost, CURLOPT_URL, "https://web.njit.edu/~ssc3/coolproject/beta/database.php");
curl_setopt($backendpost, CURLOPT_POSTFIELDS, http_build_query($_POST));
curl_setopt($backendpost, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($backendpost, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($backendpost, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($backendpost);
curl_close($backendpost);
echo $result;


/*
 * PLEASE SEND THE PROFESSOR QUESTION AS AN ARRAY WITH INDEX INT AND VALUE = QUESTION
 * SAME FOR THE STUDENT RESPONSE
 */
function GRADE_FULL_EXAM($quiz_name ,$full_exam, $student_responses, $question_worth, $quiz_max_points, $testcases){
    //ARRAY THAT HOLDS THE COMMENTS FOR EACH QUESTION AND FINAL GRADE
    $FULLL_GRADED_EXAM_COMMENTS= array();
    //FINAL GRADE COUNTER
    $exam_final_grade=0;
    for($x=0; $x<sizeof($full_exam); $x++){

        //  echo "MAIN GRADING LOOP >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>"."\n";
        $PROFESSOR_SINGLE_QUESTION = $full_exam[$x];
        $STUDENT_SINGLE_QUESTION_RESPONSE = $student_responses[$x];
        // $prof_question = tempnam("/tmp", "prof_question_holder.txt");
        $professor_single_question_holder_file = fopen("Question".$x.".txt", 'w') or die("Unable to open rPF_HOLDER file !");
        fwrite($professor_single_question_holder_file, $PROFESSOR_SINGLE_QUESTION);
        fclose($professor_single_question_holder_file);

        //$student_answerFile= temfile("/tmp", "student_code_holder".$x.".py");
        //echo $student_answerFile."\n";
        $student_code=$STUDENT_SINGLE_QUESTION_RESPONSE;
        $student_single_question_holder_file = fopen("studentcode".$x.".py", "w") or die("Unable to open S-file!");
        fwrite($student_single_question_holder_file, $STUDENT_SINGLE_QUESTION_RESPONSE);
        fclose($student_single_question_holder_file);

        $FULLL_GRADED_EXAM_COMMENTS[$x] = grade_question("Question".$x.".txt", "studentcode".$x.".py",
            $question_worth[$x], $testcases);
        $FULLL_GRADED_EXAM_COMMENTS[$x]["Student_Answer"] =$student_responses[$x];
        $FULLL_GRADED_EXAM_COMMENTS[$x]["Question"] = $PROFESSOR_SINGLE_QUESTION;
        $exam_final_grade += $FULLL_GRADED_EXAM_COMMENTS[$x]["Question_Final_Grade"];
        // echo "******************************************** Final Grade: ".$exam_final_grade."\n";
    }
    /*
     * FINAL GRADE FOR THE EXAM IS AT THE END OF ARRAY ->> 4
     */
    $FULLL_GRADED_EXAM_COMMENTS["quiz_name"] =$quiz_name;
    $FULLL_GRADED_EXAM_COMMENTS["exam_final_grade"]= round($quiz_max_points * ($exam_final_grade/100) ,2);

    //echo "done grading: ".$exam_final_grade."\n";
    return $FULLL_GRADED_EXAM_COMMENTS;
}

//TO GET ALL THE VARIABLES ON THE VARIABLE ARRAY USE implode
//$variables_inArray = implode ($question_params["variables"]);
//echo $variables_inArray;
function grade_question($PROFESSOR_EXAM_QUESTIONS, $STUDENT_QUESTION_RESPONSE, $QUESTION_WORTH, $testcases){
    $QUESTION_PARAMETERS = get_GradingParameters($PROFESSOR_EXAM_QUESTIONS);



    // PYTHON FILE CONTAINING  STUDENT'S CODE FOR GRADING AND EXECUTION
    $filetoGrade = fopen($STUDENT_QUESTION_RESPONSE, "r") or die("Unable to open fgrade-file!");
    // RAW STRINGS TO LOOK FOR
    $count_correct_vars=0;
    $final_grade = 0;
    $question_worth=$QUESTION_WORTH;
    $params_comm=0;
    $params_comm2=0;
    $function_name = $QUESTION_PARAMETERS["function_name"];
    $parameters_variables = $QUESTION_PARAMETERS["variables"];
    $parameters_count=sizeof($parameters_variables);
    $finalOuput_ = $QUESTION_PARAMETERS["expected_output"];
    $return_name = $QUESTION_PARAMETERS["return_name"];
    $GRADE_COMMENTS= array();
    $variables_collector= array();
    $variables_collector_count=0;
    $param_array_counter=0;

    $divider = 4*$parameters_count;
    $break_evenly = $question_worth/$divider;

    $func=false;
    $params=false;
    $return=false;
    $result=false;

    $testCases= $testcases;


    // REGEX PATTERN FOR THE FUNCTION NAME SEARCH
    $function_pattern = '/def ' . $function_name . '[(]/';

    // REGEX PATTERN FOR THE FUNCTION RETURN VARIABLE
    $return_pattern = '/return ' . $return_name . '[;]/';
    // REGEX PATTERN FOR THE FINAL OUTPUT
    $finalOutput_pattern = '/' . $finalOuput_ . '/';
    // END OF PATTERNS SETUP


    //echo "************** STARTING GRADING PROCESS..... ******************" . "\n";
    // BEGINNING OF THE GRADING PROCESS
    if ($filetoGrade) {
        while (($current_line = fgets($filetoGrade)) !== false) {

            //CHECK FOR FUNCTION NAME
            if (preg_match($function_pattern, $current_line)) {
                //echo "ADDING POINTS TO FINAL GRADE funname: ".($question_worth/4)."\n";
                $final_grade += $question_worth/4;
                $GRADE_COMMENTS["Function"]="Function name is correct +".round($question_worth/4, 2);
                $func=true;
                // echo ($question_worth/4)." Function matched: " . $current_line . "\n";
            }
            //CHECK FOR RETURN
            if (preg_match($return_pattern, $current_line)) {
                // echo "ADDING POINTS TO FINAL GRADE return: ".(($question_worth/4))."\n";
                $final_grade += ($question_worth/4);
                $GRADE_COMMENTS["Return"]="Returned correct variable +".round($question_worth/4, 2);
                $return= true;
                //echo (($question_worth/4)*2)." Return Matched: " . $current_line . "\n";
            }

            //$param_array_counter=0;
            for( $i=0; $i<sizeof($parameters_variables); $i++) {
                // REGEX PATTERN FOR THE FUNCTION PARAMETERS
                $paramaters_pattern = '/def'.'.*'.'[\(]*'.$parameters_variables[$i].'[\)]*/';
                //CHECK FOR PARAMETERS NAMES
                $found =false;
                if (preg_match($paramaters_pattern, $current_line)) {
                    if($GRADE_COMMENTS["Parameters"]==""){

                        $params_comm+=($question_worth/(4*$parameters_count));
                        //echo "ADDING POINTS TO FINAL GRADE params_comm: ".$params_comm."\n";
                        $final_grade +=$params_comm;
                        $count_correct_vars+=1;
                        $GRADE_COMMENTS["Parameters"][$param_array_counter] = "Parameter ->> ".$parameters_variables[$i]."  Correct +".round($params_comm,2);
                        $variables_collector[$variables_collector_count]= $parameters_variables[$i];
                        $variables_collector_count++;
                        $param_array_counter++;
                        //echo "Param marched:  VAR: ".$parameters_variables[$i]." +".$params_comm."\n";
                    }else{
                        $params_comm2 =($question_worth/(4*$parameters_count));
                        $GRADE_COMMENTS["Parameters"][$param_array_counter] = "Parameter ->> ".$parameters_variables[$i]."  Correct +".round($params_comm2, 2);
                        $variables_collector[$variables_collector_count]= $parameters_variables[$i];
                        $variables_collector_count++;
                        $param_array_counter++;
                        // echo "ADDING POINTS TO FINAL GRADE params2: ".$params_comm2."\n";
                        $final_grade +=$params_comm2;
                        $count_correct_vars+=1;
                        //echo "Params2 marched:  VAR: ".$parameters_variables[$i]." +".$params_comm2."\n";
                    }


                    $params = true;

                }
            }
            //echo "\n"."nxt"."\n";
        }

        // echo "Size of params vars: ".sizeof($parameters_variables)." Size of comments: ".$count_correct_vars."\n";

        if( (sizeof($parameters_variables)) > $count_correct_vars ){
            /**
            $points_off= sizeof($parameters_variables)-$count_correct_vars;
            $GRADE_COMMENTS["Parameters"] =$points_off." Variables were not found as parameters: -".round (($question_worth/(4*$parameters_count))*$points_off,2);
            echo "Some Variables were not found as parameters: -".($question_worth/(4*$parameters_count))*$points_off."\n";
             */

            $position=0;
            //  for($x=0; $x<sizeof($variables_collector); $x++) {

            foreach ($parameters_variables as $item){

                if(in_array($item, $variables_collector) ==false){
                    $points_off = sizeof($parameters_variables) - $count_correct_vars;
                    $GRADE_COMMENTS["Parameters"][$param_array_counter+$position] ="Parameter ->> ".$item." was not found -" . round(($question_worth / (4 * $parameters_count)) * $points_off, 2);
                    $position++;
                    //  echo "Some Variables were not found as parameters: -" . ($question_worth / (4 * $parameters_count)) * $points_off . "\n";
                }

            }
//  }


        }

        //CLOSE THE FILE AFTER READING ALL LINES
        fclose($filetoGrade);

        if(strlen($return_name)>1 ){
            if($func==false){ $GRADE_COMMENTS["Function"]="Function name was incorrect -".round($question_worth/4,2);}
          //  if(!$params){$GRADE_COMMENTS["Parameters"]="Params var were incorrect";}
            if($return==false){
                $GRADE_COMMENTS["Return"] = "Return var was incorrect -".round( ($question_worth/4)*2, 2);
            }
        }

    }

    $testCases_flag=false;
    /*$GRADE_COMMENTS["Testcases"] = array();

    for ($i = 0; $i < sizeof($testcases); $i++) {
        array_push($GRADE_COMMENTS["Testcases"], "");
    }*/

    $caseCount=0;
    foreach ($testCases as $case) {
        $testcase_student_output =runTestCases($STUDENT_QUESTION_RESPONSE, $function_name, $case);
        $casew =((($question_worth/4))/sizeof($testCases));
        if($testcase_student_output[0]){
            // echo "ADD POINTS FOR TESTCASES outputarray: "."\n";
            $final_grade += ((($question_worth/4))/sizeof($testCases));
            
            //$GRADE_COMMENTS["Testcases"][$case] = $case." was correct +" .((($question_worth/4)*2)/sizeof($testCases));
            $GRADE_COMMENTS["Testcases"][$caseCount] = 'TestCase ->> '.$case." was correct +" .round($casew,2)." Program Result: ".$testcase_student_output[1];
            $testCases_flag=true;
        }else{
            $GRADE_COMMENTS["Testcases"][$caseCount] = 'TestCase ->> '.$case." was incorrect -" .round($casew, 2)." Program Result: ".$testcase_student_output[1];
            // echo "TAKE POINTS OF FOR INCCORECT TESTCASE"."\n";
        }
        $caseCount++;

    }


    if( (($finalOuput_ !="") && (sizeof($testCases))<2) && ($testCases_flag ==false) ) {
        /*CREATE AND EXECUTE STUDENT'S CODE ON THE SERVER TO SEE IF IT WORKS AND WHATS THE OUPUT */
        $command = escapeshellcmd('python ' . $STUDENT_QUESTION_RESPONSE);
        $output = shell_exec($command);
        if (preg_match($finalOutput_pattern, $output)) {
            $final_grade += ($question_worth/4)*2;
            $GRADE_COMMENTS["Output"] = "Output was correct +" .round(($question_worth/4)*2,2);
            //  echo "FINAL OUTPUT MATCHED: " . ($question_worth / 4) . "\n";
            $result=true;
        }
        if(!$result){
            // if(!$func){ $GRADE_COMMENTS["Function"]="Function name was incorrect";}
            //if(!$params){$GRADE_COMMENTS["Parameters"]="Params var were incorrect";}
            //if(!$return){$GRADE_COMMENTS["Return"] = "Return var was incorrect";}
            $GRADE_COMMENTS["Output"]="Output was incorrect -".round(($question_worth/4)*2, 2);
            //echo $GRADE_COMMENTS["Output"]."\n";
        }
        if($func==false){ $GRADE_COMMENTS["Function"]="Function name was incorrect -".round(($question_worth/4)*2, 2);}
    }


    $GRADE_COMMENTS["Question_Final_Grade"]=$final_grade;
    //echo "\n" . "Final Grade before return: " . $final_grade;
    return $GRADE_COMMENTS;




}//END OF EXAM GRADER FUNCTION

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
    $question_file = fopen( $file_name, "r") or die("Unable to open qf- file!");

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
                        // echo "Found Single variable: ".$current_line_splitter[$x+1]. "\n";
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
                                    $variables_array[$variables_array_items_count]=preg_replace("/[^A-Za-z0-9]/","",$current_line_splitter[$x + $i + 1]);
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





function runTestCases($student_code, $function_name, $testCase){

    $filename= substr ($student_code ,  0 , 12 );
    //echo "NAME OF FILE: ".$filename."\n";

    $start=strpos($testCase, "=");
    $end=strpos($testCase, "=");

    $testcaseinput= substr ( $testCase ,  0 , $start );
    $testcase_result= substr ( $testCase ,  $end+1, strlen($testCase) );

    $code = " python -c 'from " . $filename . ' import ' . $function_name . '; print (' . $function_name . '(' . $testcaseinput . '))\'';
    //echo "CODE TO EXECUTE: ".$code."\n";
    //  echo "###command: ".$code."\n";

    $testcase_output=exec($code);

    //echo "TestCase expected: ".$testcase_result." Program Output: ".$testcase_output."\n";
    if($testcase_output == $testcase_result) {
        //echo "TestCase expected: ".$testcase_result." Program Output: ".$testcase_output."\n";
        //    return true;
        return array(0 => true, 1 => $testcase_output);
    }else{
        //return false;
        return array(0 => false, 1 => $testcase_output);
    }

}



?>