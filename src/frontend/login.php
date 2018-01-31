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
                $form_data = json_encode($_POST);
    
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "localhost:8000/middle/middleLogin.php");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($connection, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

                // Receive json file with 
                $result = curl_exec($curl);

                if ($result === FALSE) {
                    echo "error: " . curl_error($curl);
                }

                curl_close($curl);

                // Set session variables for welcome page
                $_SESSION["njitaccess"] = $result["njitaccess"];
                $_SESSION["dbaccess"] = $result["dbaccess"];

                header("Location: welcome.php");
            } else {
            }
        ?>

        <form method="POST" id="login-form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
            <label for="uname">Username</label>
            <br>
            <input type="text" name="uname" placeholder="Enter Username">
            <br>
            <label for="passw">Password</label>
            <br>
            <input type="password" name="njitpass" placeholder="Enter NJIT password">
            <br>
            <button type="submit" name="login">Sign in</button>
        </form>
    </div>
</body>

</html>