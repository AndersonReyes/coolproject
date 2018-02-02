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

$u = $_POST["user"];
$p = $_POST["pass"];
$p2 = sha1($p);
$s = "select * from Users where user='$u' and pass='$p2'";
($q = mysqli_query($db, $s)) or die(mysqli_error($db));
$rows = mysqli_num_rows($q);
if( $rows > 0 ){ 
	echo json_encode(array('dbaccess' => 'true'));
}
else{ 
	echo json_encode(array('dbaccess' => 'false'));
}

?>
