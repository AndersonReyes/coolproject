<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="css/welcome.css" rel="stylesheet">
    <title>CS 490 project by kendy, stephen, and anderson</Form>
    </title>
</head>

<body>

    <div class="container">
        <div class="navbar"></div>

        <h1>Welcome</h1>
        <br>
        <?php
        $userinfo = $_SESSION["userdata"];

        if ($userinfo["njitaccess"] == 1) {
            echo "<p>Welcome to njit services</p><br>";
        } else {
            echo "<p>No njit services</p><br>";
        }

        if ($userinfo["dbaccess"] == 1) {
            echo "<p>Welcome to database services</p><br>";
        } else {
            echo "<p>No database services</p><br>";
        }
        
        ?>
    </div>
    
</body>
