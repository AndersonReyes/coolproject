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
	if (isset($_POST["difficulty"])){
		$diff = $_POST["difficulty"];
	}
	if (isset($_POST["topic"])){
		$topic = $_POST["topic"];
	}
	if ($type == 'add_q'){
		$s = "insert into QuestionBank (question, difficulty, topics) values ('$question', '$diff', '$topic')";
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
	}
}

else if ($type == 'get_q'){ //returning questions to front to create exam
							//each element includes question, diff, topic delimited by ;
	$s = "select * from QuestionBank";
	($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	$a = array();
	while($r = mysqli_fetch_array($q, MYSQLI_ASSOC)){
		$str = $r["question"].";".$r["difficulty"].";".$r["topics"].";";
		array_push($a, $str);
	}
	echo json_encode($a);
}

else if ($type == 'add_quiz'){ //creates a quiz from chosen questions
	$quiz_name = $_POST["quiz_name"];
	$quiz_name = str_replace(' ', '', $quiz_name);
	$create = "create table $quiz_name( question TEXT PRIMARY KEY, answer TEXT, comments TEXT, testcases TEXT, points INT(3), maxpoints INT(3), publish VARCHAR(10))";
	($createquery = mysqli_query($db, $create)) or die(mysqli_error($db));
	
	$q_list = $_POST["questions"];
	$pts_list = $_POST["max_points"];
	for ($i = 0; $i < sizeof($q_list); $i++){
		$ques = $q_list[$i];
		$pts = $q_list[$i];
		
		$addQ = "insert into $quiz_name (question, maxpoints) values ('$ques', $pts)";
		($addQquery = mysqli_query($db, $addq)) or die(mysqli_error($db));
	}
	
	$addname = "insert into QuizNames (name) values ('$quiz_name')";
	($addnamequery = mysqli_query($db, $addnamequery)) or die(mysqli_error($db));
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
	($getnamequery = mysqli_query($db, $getnamequery)) or die(mysqli_error($db));
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
	$quiz_name = $data[5];
	
	for ($i = 1; $i < sizeof($data); $i++){
		$ques = //      <--- find out how to and add to sql statement
		$ans = $data[$i-1]["Student_Answer"];
		$pts = $data[$i-1]["Question_Final_Grade"];	
		$cmt = "";
		if (isset($data[$i-1]["Function"])){
			$cmt = $data[$i-1]["Function"];
		}
		$cmt .= ";";
		if (isset($data[$i-1]["Parameters"])){
			$cmt .= $data[$i-1]["Parameters"];
		}
		$cmt .= ";";
		if (isset($data[$i-1]["Return"])){
			$cmt .= $data[$i-1]["Return"];
		}
		$cmt .= ";";
		if (isset($data[$i-1]["Output"])){
			$cmt .= $data[$i-1]["Output"];
		}
		$cmt .= ";";
		$test_cases = "";
		if (isset($data[$i-1]["Testcases"])){
			$tc = $data[$i-1]["Testcases"];
			for ($j = 0; $j < sizeof($tc); $j++){
				$test_cases .= $tc[$j] . ";";
			}
		}
		$s = "update $quiz_name set comments ='$cmt', points = $pts, answer = '$ans', testcases = '$test_cases' where question = ";
		($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	}
}

else if ($type == 'show_results') { //view results of a graded and published quiz
	$quiz_name = $_POST["quiz_name"];
	$s = "select * from $quiz_name";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
	$a = array();
	while($r = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if ($r["publish"] == 'TRUE'){
			$q = $r["question"];
			$a = $r["answer"];
			$c = $r["comments"];
			$t = $r["testcases"];
			$p = $r["points"];
			$mp = $r["maxpoints"];
			$str = $q.";".$a.";".$c.";".$t.";".$p.";".$mp.";";
			array_push($a, $str);			
		}
	}
	echo json_encode($a);
}

else if ($type == 'delete_q'){
	$question = $_POST["question"];
	$s = "delete * from QuestionBank where question='$question'";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
}
else if ($type == 'delete_quiz'){
	$quiz_name = $_POST["quiz_name"];
	$s = "drop table $quiz_name";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
}
?>
