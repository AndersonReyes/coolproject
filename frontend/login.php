<?php session_start()?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <title>CS 490 project by kendy, stephen, and anderson</Form>
    </title>
</head>

<body>
    <div id="form-container">
        <h2>Log in</h2>

        <?php 
            if (!empty($_POST)) {

                $uname = $_POST["uname"];
                $njitpass = $_POST["njitpass"];
                $data = array("uname" => $uname, "pass" => $njitpass, "state" => "login");
    
                $post = curl_init();
                curl_setopt($post, CURLOPT_URL, "https://web.njit.edu/~ar579/middle/middleLogin.php");
                curl_setopt($post, CURLOPT_POST, 1);
                curl_setopt($post, CURLOPT_POSTFIELDS, $data);
                curl_setopt($post, CURLOPT_FOLLOWLOCATION, 1);

                // Receive json file with 
                curl_exec($post);
                curl_close($post);

                $_POST = array();
            }
        ?>

        <form method="POST" id="login-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
            <label for="uname">Username</label>
            <br>
            <input type="text" name="uname" placeholder="Enter Username" required>
            <br>
            <label for="njitpass">NJIT Password</label>
            <br>
            <input type="password" name="njitpass" placeholder="Enter NJIT password" required>
            <br>
            <label for="dbpass">Database Password</label>
            <br>
            <input type="password" name="dbpass" placeholder="Enter Database password" required>
            <br>
            <button type="submit" name="login">Sign in</button>
        </form>
    </div>
</body>

</html>