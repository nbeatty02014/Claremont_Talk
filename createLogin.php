<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign Up</title>
<link rel = "stylesheet"
type = "text/css"
href = "createLogin.css" />
  </head>

  <div class="container">
    <h1>Sign Up for ClaremontTalk!</h1>
    <p>Please fill in this form to create an account. you'll then be able to see and post messages</p>
<form action="verifyAccount.php" method = "post">
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>
    

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

    <label for="school" ><b>School</b></label> <br>
    <select class = "button" name = "school">
      <option value="Pomona">Pomona</option>
      <option value="CMC">CMC</option>
      <option value="Pitzer">Pitzer</option>
      <option value="Scripps">Scripps</option>
      <option value="Mudd">Mudd</option>
      <option value="KGI">KGI</option>
      <option value="CGU">CGU</option>
      <option value="CUC">CUC</option>
    </select>


    <p>By creating an account you agree to our <a href="terms.html" target="_blank" style="color:blue">Terms and Conditions</a>.</p>

    <div class="clearfix">
      <button type="submit" class="button">Sign Up</button>
    </div>
  </div>
</form>
</html>
