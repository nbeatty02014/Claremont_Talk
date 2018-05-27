
<?php 
// Define database connection details via constants 
 require'dbconn.php';
session_start(); 
$conn = connect_to_db("ClaremontTalk");
$email = $conn-> real_escape_string($_POST['email']);
$psw = $conn-> real_escape_string($_POST['psw-repeat']);
$pswRepeat = $conn-> real_escape_string($_POST['psw']);
$school = $conn-> real_escape_string($_POST['school']);
$emailErr = $passwordErr = "";
$admin = 0;
// check if name only contains letters and whitespace
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo $email;
      $emailErr = "Invalid email format"; 
    }

     if ((!preg_match("^(?=.*\d).{4,30}+^",$psw) || $psw != $pswRepeat) ){
      echo $psw;
      echo $pswRepeat;
      $passwordErr = "invalid password"; 
    }
 
if(strlen($emailErr)>0||strlen($passwordErr)>0) {
  
  header("Location: createLogin.php");
}

else {
$email = $conn-> real_escape_string($email);
$psw = $conn-> real_escape_string($psw);

  $sql = "SELECT count(*) as 'c' FROM User WHERE email = '$email'";
  $result = $conn->query($sql)->fetch_object()->c;
  if(($result==0)){

  $insertUser = $conn -> prepare("INSERT INTO User (email, password, school, admin) VALUES(?,?,?,?)");
   $hashedPsw = crypt($psw,"hashbrown");
  $insertUser -> bind_param("sssi",$email,$hashedPsw,$school,$admin);
  $insertUser->execute();
  $emailErr = $passwordErr = "";
  echo "VALID USER";
  header("Location: login.php");
}
else {echo "You already have an account, please login";}
}
?>

</body>
</html>
