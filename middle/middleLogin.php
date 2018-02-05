<?php
/**
 * Created by KendyColon.
 * User: kendycolon
 * Date: 1/26/18
 * Time: 1:40 AM
 */


function post_db($uname, $dbpass) {

    // Curl database
    $dbdata = array("user" => $uname, "pass" => $dbpass);

    $dbpost = curl_init();
    curl_setopt($dbpost, CURLOPT_URL, "https://web.njit.edu/~ar579/coolproject/backend/database.php");
    curl_setopt($dbpost, CURLOPT_POST, 1);
    curl_setopt($dbpost, CURLOPT_POSTFIELDS, $dbdata);
    curl_setopt($dbpost, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($dbpost, CURLOPT_RETURNTRANSFER, 1);

    $result = json_decode(curl_exec($dbpost), true);

    if ($result === FALSE) {
        echo "error: " . curl_error($dbpost);
        echo "curl info: " . curl_getinfo($dbpost);
    }

    curl_close($dbpost);

    return $result;
}

function post_njit($uname, $njitpass) {

    // Curl njit
    $njitdata = array("user" => $uname, "pass" => $njitpass);
    $result = 0;

    $njitpost = curl_init();
    curl_setopt($njitpost, CURLOPT_URL, "https://cp4.njit.edu/cp/home/login");
    curl_setopt($njitpost, CURLOPT_POST, 1);
    curl_setopt($njitpost, CURLOPT_POSTFIELDS, $njitdata);
    curl_setopt($njitpost, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($njitpost);


    if ($result === FALSE) {
        echo "error: " . curl_error($njitpost);
        echo "curl info: " . curl_getinfo($njitpost);
    }

    curl_close($njitpost);

    // Close session
    $njitpost = curl_init();
    curl_setopt($njitpost, CURLOPT_URL, "http://cp4.njit.edu/up/Logout?uP_tparam=frm&frm=");
    curl_exec($njitpost);
    curl_close($njitpost);


    // return strpos($result, "loginok.html") !== false;
    return "false";
}

$user = $_POST["user"];
$pass = $_POST["pass"];

// Set the boolean if it has access
$dbresult = post_db($user, $pass);
$njitresult = post_njit($user, $pass);

echo json_encode(Array("dbresult" => $dbresult["dbaccess"], "njitresult" => $njitresult));

?>
