<?php
require 'dbconn.php';	
session_start();
?>
<!DOCTYPE html>
<head>
	<title>Create Message</title>
	<link rel="stylesheet" href="CTalkStyle.css">
	<style>
	.nav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

.navigation {
    float: left;
}
.navigation a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.navigation a:hover {
    background-color: dodgerblue;
}
  h1{
  text-align: center;
color: black;
background-size: 100%;
background-color:  #d7dfe0;
color: dodgerblue;
     text-shadow: 1px 1px 0px #9fb3b5; /* FF3.5+, Opera 9+, Saf1+, Chrome, IE10 */
}
.title {
    width:150px;
}
.name{
    width:150px;
}
.type{
    width:150px;
}
/*.messageContents{
   
}*/
.approve{
    width:75px;
}    
.messageID{
    width:75px;
}   
.delete{
    width:75px;
} 
</style>
</head>
<body class = "msg" style = "background-color: #ccf6ff">
	<h1 style = "background-color: #ccf6ff">ClaremontTalk</h1> 
	    <ul class="nav"> 
  <li class="navigation"><a href='viewMessages.php'>View Message Board</a></li>
  <li class='navigation'><a href='message.php'>Create Message</a></li>
   <li class='navigation'><a href='index.php'>Logout</a></li>
</ul>
	<h2>Enter Your Message</h2>
	<p>Please fill out the following fields to submit your message.</p>
	<img src = "http://www.kgi.edu/Images/About_KGI/400x300_Claremont-Colleges.jpg" style= "float:right">

	<form method= "post" action='messageConfirmation.php' >
		<strong>Title:</strong><br>
		<input type = "text" name = "title" required><br><br>
		<strong>Subject:</strong><br>
		<select name = "subject">
			<option value="tech">Technology</option>
			<option value="science">Science</option>
			<option value="speaker">Speaker Series</option>
			<option value="food">Food</option>
			<option value = "gov">Government</option>
			<option value = "art">Art</option>
			<option value = "entertainment">Entertainment</option>
			<option value = "other">Other</option>
		</select><br><br>
		<strong>Event Host's Name:</strong><br>
		<input type = "text" name = "name" required><br><br>
		<strong>Location:</strong><br>
		<input type = "text" name = "location" required><br><br>
		<strong>Message:</strong><br>
		<textarea rows = "7" cols="50" name = "message" required></textarea><br>
		<input type = "submit" class="button" value = "Submit Message">
	</form>
</body>
</html>
