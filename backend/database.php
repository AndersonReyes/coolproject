<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

include ("account.php");

$db = mysqli_connect($hostname, $username, $password, $project);

if (mysqli_connect_errno())
  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }

mysqli_select_db( $db, "ssc3" );

$type = $_POST["type"];


if ($type == 'login'){
	$u = $_POST["user"];
	$p = $_POST["pass"];
	$pass = sha1($p);
	$s = "select * from Users where user='$u' and pass='$pass'";
	($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	$rows = mysqli_num_rows($q);
	if( $rows > 0 ){
		$userInfo = mysqli_fetch_array($q, MYSQLI_ASSOC);
		$admin = $userInfo["admin"];
		echo json_encode(array('dbaccess' => 'true', 'admin' => $admin));
	}
	else{
		echo json_encode(array('dbaccess' => 'false'));
	}
}

else if ($type == 'publish_quiz'){
	$quiz_name = $_POST["quiz_name"];
	$publish = $_POST["publish"];
	$s = "update $quiz_name set publish = '$publish'";
	($q = mysqli_query($db, $s)) or die(mysqli_error($db));
}

else if ($type == 'add_q' || $type == 'update_q'){ //adding questions to QuestionBank
	$question = $_POST["question"];
	$diff = "";
	$topic = "";
	$testcases = "";
	if (isset($_POST["difficulty"])){
		$diff = $_POST["difficulty"];
	}
	if (isset($_POST["topic"])){
		$topic = $_POST["topic"];
	}
	if (isset($_POST["testcases"])){
		$tcArray = $_POST["testcases"];
		for ($i = 0; $i < sizeof(tcArray); $i++){
			$testcases .= $tcArray[$i] . ";";
		}
	}
	if ($type == 'add_q'){
		$s = "insert into QuestionBank (question, difficulty, topics, testcases) values ('$question', '$diff', '$topic', '$testcases')";
		($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	}
	else if ($type == 'update_q'){
		$old_q = $_POST["old_question_name"];
		$s = "update QuestionBank set question='$question' where question='$old_q'";
		($q = mysqli_query($db, $s)) or die(mysqli_error($db));
		if (isset($topic)){
			$s = "update QuestionBank set topic='$topic' where question='$question'";
			($q = mysqli_query($db, $s)) or die(mysqli_error($db));
		}
		if (isset($diff)){
			$s = "update QuestionBank set difficulty='$diff' where question='$question'";
			($q = mysqli_query($db, $s)) or die(mysqli_error($db));
		}
		if (isset($testcases)){
			$s = "update QuestionBank set testcases='$testcases' where question='$question'";
			($q = mysqli_query($db, $s)) or die(mysqli_error($db));
		}
	}
}

else if ($type == 'get_q'){ //returning questions to front to create exam
							//each element includes question, diff, topic delimited by ;
	$s = "select * from QuestionBank";
	($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	$a = array();
	while($r = mysqli_fetch_array($q, MYSQLI_ASSOC)){
		$str = $r["question"].";".$r["difficulty"].";".$r["topics"].";".$r["testcases"];
		array_push($a, $str);
	}
	echo json_encode($a);
}

else if ($type == 'add_quiz'){ //creates a quiz from chosen questions
	$quiz_name = $_POST["quiz_name"];
	$quiz_name = str_replace(' ', '', $quiz_name);
	$create = "create table $quiz_name( question TEXT, answer TEXT, comments TEXT, points INT(3), maxpoints INT(3), publish VARCHAR(10))";
	($createquery = mysqli_query($db, $create)) or die(mysqli_error($db));
	
	$q_list = $_POST["questions"];
	$pts_list = $_POST["max_points"];
	for ($i = 0; $i < sizeof($q_list); $i++){
		$ques = $q_list[$i];
		$pts = $pts_list[$i];

		$getTC = "select testcases from QuestionBank where question='$ques'";
		($getTCquery = mysqli_query($db, $getTC)) or die(mysqli_error($db));
		$r = mysqli_fetch_array($getTCquery, MYSQLI_ASSOC);
		$tc = $r["testcases"];
		
		$addQ = "insert into $quiz_name (question, maxpoints) values ('$ques', $pts)";
		($addQquery = mysqli_query($db, $addQ)) or die(mysqli_error($db));
	}
	
	
	$addname = "insert into QuizNames (name) values ('$quiz_name')";
	($addnamequery = mysqli_query($db, $addname)) or die(mysqli_error($db));
}

else if ($type == 'get_quiz'){ //gets quiz for student to take
	$quiz_name = $_POST["quiz_name"];
	$quiz_name = str_replace(' ', '', $quiz_name);
	$s = "select * from $quiz_name";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
	$a = array();
	while($r = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		array_push($a, $r);
	}
	echo json_encode($a);
}

else if ($type == 'get_all_quiz'){
	$all_quiz_names = array();
	$all_quizzes = array();
	$get_names = "select name from QuizNames";
	($getnamequery = mysqli_query($db, $get_names)) or die(mysqli_error($db));
	while ($result = mysqli_fetch_array($getnamequery, MYSQLI_ASSOC)){
		array_push($all_quiz_names, $result["name"]);
	}

	for ($i = 0; $i < sizeof($all_quiz_names); $i++){
		$quiz = array();
		$s = "select * from $all_quiz_names[$i]";
		($result2 = mysqli_query($db, $s)) or die(mysqli_error($db));
		while($ques = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
			array_push($quiz, $ques);
		}
		$all_quizzes["$all_quiz_names[$i]"] = $quiz;
	}

	echo json_encode($all_quizzes);
}

else if ($type == 'update_quiz'){ //edits quiz in QuizBank with student's grades
								  //if publish is true, updates with prof's changes
	$data = $_POST["FULLL_GRADED_EXAM_COMMENTS"];
	$quiz_name = $data["quiz_name"];
	$total_grade = $data["exam_final_grade"];

	for ($i = 0; $i < (sizeof($data)-1); $i++){
		$ques = $data[$i]["Question"];
		$ans = $data[$i]["Student_Answer"];
		$pts = $data[$i]["Question_Final_Grade"];
		$cmt = "";
		if (isset($data[$i]["Function"])){
			$cmt = $data[$i]["Function"];
		}
		$cmt .= ";";
		if (isset($data[$i]["Parameters"])){
			$fullcmts = "";
			$cmtarray = $data[$i]["Parameters"];
			for ($j = 0; $j < sizeof($cmtarray); $j++){
				$fullcmts .= $cmtarray[$j] . ";";
			}
			$cmt .= $fullcmts;
		}
		$cmt .= ";";
		if (isset($data[$i]["Return"])){
			$cmt .= $data[$i]["Return"];
		}
		$cmt .= ";";
		if (isset($data[$i]["Output"])){
			$cmt .= $data[$i]["Output"];
		}
		$cmt .= ";";
		if (isset($data[$i]["Keywords"])){
			$cmt .= $data[$i]["Keywords"];
		}
		$cmt .= ";";
		if (isset($data[$i]["Testcases"])){
			$tc = $data[$i]["Testcases"];
			for ($j = 0; $j < sizeof($tc); $j++){
				$cmt .= $tc[$j] . ";";
			}
		}
		$s = "update $quiz_name set comments ='$cmt', points = $pts, answer = '$ans' where question ='$ques' ";
		($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	}
	$add_total_grade = "update QuizNames set grade = $total_grade where name = '$quiz_name'";
	($tgq = mysqli_query($db, $add_total_grade)) or die(mysqli_error($db));
}

else if ($type == 'show_results') { //view results of a graded and published quiz
	$quiz_name = $_POST["quiz_name"];
	$s = "select * from $quiz_name";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
	$arry = array();
	while($r = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if ($r["publish"] == 'TRUE'){
			$q = $r["question"];
			$a = $r["answer"];
			$c = $r["comments"];
			$p = $r["points"];
			$mp = $r["maxpoints"];
			$str = $q.";".$a.";".$c.";".$p.";".$mp.";";
			array_push($arry, $str);
		}
	}

	$get_grade = "select grade from QuizNames where name = '$quiz_name'";
	($r = mysqli_query($db, $get_grade)) or die(mysqli_error($db));
	$grade = mysqli_fetch_array($r, MYSQLI_ASSOC);
	array_push($arry, $grade["grade"]);
	echo json_encode($arry);
}

else if ($type == 'delete_q'){
	$question = $_POST["question"];
	$s = "delete from QuestionBank where question='$question'";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
}
else if ($type == 'delete_quiz'){
	$quiz_name = $_POST["quiz_name"];
	$s = "drop table $quiz_name";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));

	// Remove from QuizNames table
    $s = "delete from QuizNames where name='$quiz_name'";
    ($result = mysqli_query($db, $s)) or die(mysqli_error($db));
}
?>