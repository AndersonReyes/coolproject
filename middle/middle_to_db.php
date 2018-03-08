
<?php

include_once "./../utils/php_utils.php";


// This will simply pass the post to the database and return the results
$result = post_curl($_POST, "https://web.njit.edu/~ssc3/coolproject/beta/database.php");
 echo json_encode($result);