<?php
session_start();
session_unset();  // remove all session variables
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Claremont Talk</title>
</head>
<body style = "text-align: center; background-color: #ccf6ff" >
	<style>
	body{
	text-align: center;
	margin-top: 30px;
    margin-bottom: 30px;
    margin-right: 150px;
    margin-left: 150px;
    font-family: "arial";
	}
	.button {
    background-color: dodgerblue; /*blue */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}
.button:hover {
	opacity: 0.5;
}
</style>
	<h1>Welcome to Claremont Talk!</h1>
	<img src = "https://msp7l1170302145284.blob.core.windows.net/ms-p7-l1-170302-1453-24-assets/Students_539x303.jpg" alt = "image of students">
	<p>Claremont Talk is an interactive way for students across the 5C's to communicate with one another! Users can post messages to advertise events such as guest speakers, club socials, and concerts. </p>
	<button type="button" class="button" onclick="window.location.href='login.php'">Sign In</button>
	<button type="button" class="button" onclick="window.location.href='createLogin.php'">Create New Account</button>	
</body>
</html>
