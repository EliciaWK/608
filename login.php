<!DOCTYPE HTML>
<!-- Admin log in is; Username: admin@email.com, Password: admin -->
<html>
    <h2><a href='index.php'>[Return to the main page]</a></h2>
<form method="POST" action="login.php"> 
<h1>Customer Login</h1> 
    <label for="username">User name: </label> 
    <input type="email" id="username" size="30" name="username" required>  
  <p> 
    <label for="password">Password: </label> 
    <input type="password" id="password" size="15" name="password" min="10" max="30" required>  
</p> 
<input type = "submit" name="submit" value="Login"> 
</form>

<?php
session_start();
include 'checksession.php';

include "config.php";
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);


// if the login form has been filled in 
    if (isset($_POST['username'])) 
    { 
        $email = $_POST['username']; 
        $password = $_POST['password']; 
 
//prepare a query, send it to the server 
        $stmt = mysqli_stmt_init($db_connection); 
        mysqli_stmt_prepare($stmt, "SELECT customerID, password FROM customer WHERE email=?"); 
        mysqli_stmt_bind_param($stmt, "s", $email); 
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_bind_result($stmt, $customerID, $hashpassword); 
        mysqli_stmt_fetch($stmt); 
//password is checked 
        if(!$customerID) 
        { 
            echo '<p class="error">Unable to find member with email!'.$email.'</p>'; 
        } 
        else 
        { 
            if (password_verify($password, $hashpassword))
            { 
                login($customerID, $email);
                echo '<p>Congratulations, you are logged in!</p>'; 
            } 
            else 
            { 
                echo '<p>Username/password combination is wrong!</p>'; 
            } 
        } 
    }
    ?>


</html>