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

//make an add_graded_quiz block for after student takes a quiz and its graded by middle
//make a get_graded_quiz block for when professor wants to view scores before releasing grades to make changes
//make update_quiz block for after professor makes changes if any

else if ($type == 'add_q'){ //adding questions to QuestionBank
	$question = $_POST["question"];
	$diff = $_POST["difficulty"];
	$topic = $_POST["topic"];
	/*
	$s = "select * from ExamBank"
	($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	$qID = mysqli_num_rows($q) + 1;
	*/
	
	$s = "insert into QuestionBank (question, difficulty, topics) values ('$question', '$diff', '$topic')";
	($q = mysqli_query($db, $s)) or die(mysqli_error($db));
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
        $q_list = $_POST["questions"];
        $pts_list = $_POST["max_points"];
        $s = "insert into QuizBank (quiz_name) values ('$quiz_name')";
        ($q = mysqli_query($db, $s)) or die(mysqli_error($db));
        for ($i = 1; $i < sizeof($q_list)+1; $i++){
                $ques = $q_list[$i-1];
                $pts = $pts_list[$i-1];

                $s = "update QuizBank set q$i = '$ques', mp$i = '$pts' where quiz_name = '$quiz_name'";
                ($q = mysqli_query($db, $s)) or die(mysqli_error($db));
        }

}

else if ($type == 'get_quiz'){ //gets quiz for student to take
	$quiz_name = $_POST["quiz_name"];
	$s = "select * from QuizBank where quiz_name='$quiz_name'";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
	$a = array();
	$r = mysqli_fetch_array($result, MYSQLI_ASSOC);
	// for ( $i = 1; $i < 5; $i++){		
	// 	$q = $r["q".$i];
	// 	$mp = $r["mp".$i];
	// 	array_push($a, $q.";".$mp.";");
	// }
	echo json_encode($r);
}

else if ($type == 'get_all_quiz'){
	$s = "select * from QuizBank";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
	$bankarray = array();
	while ($r = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		// $quizarray = array();
		// for ( $i = 1; $i < 5; $i++){		
		// 	$q = $r["q".$i];
		// 	$mp = $r["mp".$i];
		// 	array_push($quizarray, $q.";".$mp.";");
        // }
        // array_push($quizarray, "published;".$r["publish"]);
        // array_push($quizarray, "quiz_name;".$r["quiz_name"]);
		array_push($bankarray, $r);
	}
	echo json_encode($bankarray);
}

else if ($type == 'update_quiz'){ //edits quiz in QuizBank with student's grades
				  //if publish is true, updates with prof's changes
	$quiz_name = $_POST["quiz_name"];
	$publish = $_POST["publish"];
	$q_list = $_POST["questions"];
	$pts_list = $_POST["FULLL_GRADED_EXAM_COMMENTS"];
	$comments = $_POST["FULLL_GRADED_EXAM_COMMENTS"];
	// $s = "update QuizBank set publish = '$publish' where quiz_name = '$quiz_name'";
	// ($q = mysqli_query($db, $s)) or die(mysqli_error($db));
	
	for ($i = 1; $i < sizeof($q_list)+1; $i++){
		$pts = $pts_list[$i-1]["Question_Final_Grade"];
		if ($publish == 'TRUE'){
			$fcmt = $comments[$i-1]["Function"];
			$pcmt = $comments[$i-1]["Parameters"];
			$rcmt = $comments[$i-1]["Return"];
			$ocmt = $comments[$i-1]["Output"];
			$cmt = $fcmt . ";" . $pcmt . ";" . $rcmt . ";" . $ocmt ";";
			$s = "update QuizBank set c$i ='$cmt', p$i = $pts, publish = 'TRUE' where quiz_name = '$quiz_name'";
			($q = mysqli_query($db, $s)) or die(mysqli_error($db));
		}
		else if ($publish == 'FALSE') {
			$s = "update QuizBank set p$i = $pts, publish = 'FALSE' where quiz_name = '$quiz_name'";
			($q = mysqli_query($db, $s)) or die(mysqli_error($db));
		}
	}
}

else if ($type == 'show_results') { //view results of a graded and published quiz
	$quiz_name = $_POST["quiz_name"];
	$s = "select * from QuizBank where quiz_name = $quiz_name";
	($result = mysqli_query($db, $s)) or die(mysqli_error($db));
	$a = array();
	$r = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($r["publish"] == 'TRUE'){
		for ( $i = 1; $i < 5; $i++) {
			$q = $r["q".$i];
			$a = $r["a".$i];
			$c = $r["c".$i];
			$p = $r["p".$i];
			$mp = $r["mp".$i];
			$str = $q.";".$a.";".$c.";".$p.";".$mp.";";
			array_push($a, $str);
		}
	}
	echo json_encode($a);
}
?>
