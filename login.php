<?php 

session_start(); 



require 'dbconn.php';
$connection = connect_to_db( "ClaremontTalk" );
//require 'queries.php';
?>

<!DOCTYPE html>


<?php


$emailErr = $passwordErr = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = ($_POST["email"]);
    }



    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } 
    else {
        $password = ($_POST["password"]);
    }



    if($emailErr == "" && $passwordErr == ""){

        

        $query = "SELECT userID FROM User where email=? AND password=?";
        $selectUser = $connection -> prepare($query);
        echo $connection->error;
        $hashedPassword = crypt($password,"hashbrown");
        $selectUser -> bind_param("ss", $email, $hashedPassword);

        mysqli_stmt_execute($selectUser);
        $selectUser -> bind_result($userID);

        

        if($selectUser -> fetch()){

            $_SESSION['userID'] = $userID;
            $_SESSION['email'] = $email;

            mysqli_stmt_close($selectUser);
            
           

            header("Location: viewMessages.php");
        }

        else{
            echo "<p class='error'>Email and/or password is incorrect</p>";
        }


    }
}

?>

<head>

    <title> Login Page </title>
</head>

<link rel = "stylesheet"
   type = "text/css"
   href = "createLogin.css" />

<body>
    

    <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="border:1px solid cyan">
    <div class="container">
    <h1>Welcome to ClaremontTalk!</h1> <span id="header"></span>
    <p></p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" value="<?php echo $email;?>" required>
   

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <div class="clearfix">
      <button type="submit" class="signupbtn">Log In</button>
    </div>
    </div>
    </form>

    <!--

    <form method = "post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <h1> Welcome to ClaremontTalk! </h1>
        <p> Username: <input type="text" name="username" value="<?php //echo $username;?>"/> </p>
        <p> Password: <input type="password" name="password" /> </p>
        <p><input type="submit" value="Log In" /></p>
    -->
        



    </form>



</body>

</html>
