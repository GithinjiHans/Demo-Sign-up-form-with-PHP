<?php

include 'config.php';

session_start();

error_reporting(0);

if(isset($_SESSION["user_id"]))
{
    header('location: welcome.php');
}



if(isset($_post["signup"])){
    $full_name= mysql_real_escape_string($conn, $_POST["signup_full_name"]);
    $email= mysql_real_escape_string($conn, $_POST["signup_email"]);
    $password= mysql_real_escape_string($conn, md5($_POST["signup_password"]));
    $cpassword= mysql_real_escape_string($conn, md5($_POST["signup_cpassword"]));

    $check_email = mysql_num_rows(mysql_query($conn, "SELECT email FROM users WHERE email='$email'"));

    if($password !== $cpassword){ 
        echo "<script>alert('password did not match.');</script>";
    } elseif($check_email >0){
        echo "<script>alert('Email already exists in our database.');</script>";
    }else {
     $sql = "INSERT INTO users(full_name, email, password)VALUES('$full_name', '$email', '$password')";
     $result = mysql_query($conn, $sql);
     if($result){
         $_POST["signup_full_name"]="";
         $_POST["signup_email"]="";
         $_POST["signup_password"]= "";
         $_POST["signup_cpassword"]="";
       echo "<script>alert('user registration successsful.');</script>";
     }else {
        echo "<script>alert('user registration failed.');</script>";
     }
    }

}

if(isset($_post["signin"])){
    $email= mysql_real_escape_string($conn, $_POST["email"]);
    $password= mysql_real_escape_string($conn, md5($_POST["password"]));
    $check_email = mysql_num_rows(mysql_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password'"));
if(mysql_num_rows($check_email)> 0){
    $row= mysql_fetch_assoc($check_email);
    $_SESSION["user_id"] = $row['id'];
    header('location: welcome.php');
}else{
    echo "<script>alert('Log in details incorrect.Please try again.');</script>";
}
   

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width-device, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Sign in & Sign Up form</title>
</head>

  <body>
        <div class="container">
        <div class="forms-container">
            <div class="sign-in">
                <form action="" method="post" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class ="fas fa-user"><i>
                        <input type="text" placeholder="Email adress" name="email" value="<?php echo $_POST['email'];?> required/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="password" name="password"value="<?php echo $_POST['password'];?>  required/>
                    </div> 
                    <input type="submit" value="Login" name="signin" class="btn solid"/>
                </form>                  

                <form action="" class="sign-up form" method="post">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                       <i class="fas fa-user"></i>
                       <input type="text" placeholder="full name" name="signup_full_name" value="<?php echo $_POST["signup_full_name"]?> required/>
                    </div>
                   <div class="input-field">
                     <i class="fas fa-envelope"></i>
                      <input type="email" placeholder="Email adress"name="signup_email" <?php echo $_POST["signup_email"]?> required/>
                    </div>
                     <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="password" name="signup_password"  <?php echo $_POST["signup_password"]?> required/>
                     </div>
                     <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="confirm password" name="signup_cpassword" <?php echo $_POST["signup_cpassword"]?> required/>
                     </div>
                        <input type="submit" class="btn" value="sign-up" name="sign up"/>
               </form>
    </body>
</html>

