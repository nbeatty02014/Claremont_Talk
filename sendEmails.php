<html>
<head>
    <link rel = "stylesheet" type = "text/css" href = "CTalkStyle.css" />
</head>
<style>
  body{
    margin-top: 30px;
    margin-bottom: 30px;
    margin-right: 50px;
    margin-left: 50px;
    font-family: "arial";
    background-color:  #ccf6ff;
  }
  h1{
    text-align: center;
    color: black;
    background-size: 100%;
    background-color:  #ccf6ff;
    color: dodgerblue;
    text-shadow: 1px 1px 0px #9fb3b5; /* FF3.5+, Opera 9+, Saf1+, Chrome, IE10 */
  }
  h2{
    text-align: left;
    
    background-size: 100%;
    background-color:  #ccf6ff;
    color: green;
    text-shadow: 1px 1px 0px #9fb3b5;
  }
  th{ 
    border: 1px solid;
    background-color: #3cc453;
  }

  tr:nth-child(even) {
    background-color: #9fb3b5;
  }
  table{ 
    margin-left: auto;
    margin-right: auto;
    height:95%;width:100%; 
  }

  td:hover {background-color: white;}

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
  .title {
    width:150px;
  }
  .name{
    width:150px;
  }
  .type{
    width:150px;
  }
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
<body>

    <h1>ClaremontTalk</h1>
    <!--<span></span><input type='submit' value='Send Email'>-->


</body>


<?php
session_start();
require("dbconn.php");

    echo  "<ul class='nav'> 
      <li class='navigation'><a href='viewMessages.php'>View Messages</a></li>
      <li class='navigation'><a href='message.php'>Create Message</a></li>";
      if($admin = 1){ //if person is an admin
        echo "<li class='navigation'><a href='approveMessages.php'>Approve Messages</a></li>";
      }
      echo "<li class='navigation'><a href='index.php'>Logout</a></li>
      </ul> <br>";

    echo "<h2>THIS EMAIL WAS SENT-</h2>";
    echo "<br>";
    echo "<br>";
    echo "New Events: ";
    $to = "claremont@talk.com";



    $subject = "New in ClaremontTalk: ";

    $txt = "<html><body><p>New Events: </p>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: claremont@talk.com";



    //echo $txt;

    $connection = connect_to_db("ClaremontTalk");
    $query = "SELECT * FROM Messages WHERE approved = 1 AND emailed = 0";
    $result = perform_query($connection, $query);

    while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
                
                    $title = $row['title'];
                    
                   
                    echo "<li>$title</li>";
                    $txt .= "<li>$title</li>";
                    
                }
                echo"<br/>";
                echo"<br/>";
                echo"Messages: ";
                echo"<br/>";
                echo"<br/>";

                $txt .= "<br/>
                <br/>
                Messages: 
                <br/>
                <br/>";

    $query = "SELECT * FROM Messages WHERE approved = 1 AND emailed = 0";
    $result = perform_query($connection, $query);
    while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
                
                    $title = $row['title'];
                    $name  = $row['name'];
                    $type = $row['type'];
                    $message = $row['messageContents'];
                    
                    echo "<li>$title</li>";
                    
                    echo "Type: $type";
                    echo "<br/>";
                    echo "From: $name";
                    echo "<br/>";
                    echo "Message: $message";
                    echo"<p></p>";

                    $txt .= "<li>$title</li>
                            Type: $type
                            <br/>
                            From: $name
                            <br/>
                            Message: $message
                            <p></p>";
                    
                    
                }

    $query = "UPDATE Messages SET emailed = 1 WHERE approved = 1 AND emailed = 0";
    $result = perform_query($connection, $query);

    $txt .= "</body></html>";

    $query = "SELECT email FROM User";
    $result = perform_query($connection, $query);
    while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
        $email = $row['email'];
        $to = "$email";
        mail($to,$subject,$txt,$headers);
    }

    disconnect_from_db($connection, $result);

    


?>
<br?>
<button type = 'button' class='button' onclick='window.location.href="viewMessages.php"'>Exit</button>

</html>


