<?php
require 'config.php';
require './register_handler.php';
require './login_handler.php';

?>

<html>
<head>
    <title>Bookshelf</title>
    <link rel="stylesheet" type="text/css" href="style_sheets/register_style.css" />
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="scripts/register.js"></script>
    <meta name=viewport content="width=device-width, initial-scale=1, user-scalable=yes">
</head>
<body>

    <div class="background">  

        <div class="login_form">

            <div class ="login_header">
                <h1>Bookshelf</h1>
                login or sign up
            </div>

            <div class="login_div">

                <form action="register.php" method="post">
                    <input type="text" name="login_username" placeholder="Username" value="<?php 
                            if(isset($_SESSION['login_username'])) {
                                echo $_SESSION['login_username'];
                            }
                            ?>" required/>
                    <br>
                    <input type="password" name="login_password" placeholder="Password">
                    <br>

                    <input type="submit" name='login_button' value='Login'/>
                    <?php if(in_array("Username or password incorrect", $error_array)) echo "Username or password incorrect"; ?>
                    <br>
                    <a href="#" id="register" class="register">Register here</a>

                </form>

            </div>

            <!-- 
            inline php: https://www.ntchosting.com/encyclopedia/scripting-and-programming/php/php-in/ -->
            
            <div class='register_div'>                

                <form action="register.php" method='post'>
                    <input type="text" name="reg_username" placeholder="Username" value="<?php 
                        if(isset($_SESSION['reg_username'])) {
                            echo $_SESSION['reg_username'];
                        }
                        ?>" required/>
                    <br>
                    <?php if(in_array("Your username must be between 1 and 25 characters long<br>", $error_array)) echo "Your username must be between 1 and 25 characters long<br>";
                        else if(in_array("That username is unavailable<br>", $error_array)) echo "That username is unavailable<br>";?>
                    
                    <input type="email" name="reg_email" placeholder="Email" value="<?php 
                        if(isset($_SESSION['reg_email'])) {
                            echo $_SESSION['reg_email'];
                        }
                        ?>" required>
                    <br>

                    <input type="email" name="reg_emailc" placeholder="Confirm Email" value="<?php 
                        if(isset($_SESSION['reg_emailc'])) {
                            echo $_SESSION['reg_emailc'];
                        }
                        ?>"required>
                    <br>
                    <?php if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>";
                        else if(in_array("Please enter a valid email address<br>", $error_array)) echo "Please enter a valid email address<br>";
                        else if(in_array("That email is already in use<br>", $error_array)) echo "That email is already in use<br>";?>

                    <input type="password" name="reg_password" placeholder="Password" required>
                    <br>
                    <input type="password" name="reg_passwordc" placeholder="Confirm Password" required>
                    <br>
                    <?php if(in_array("Passwords don't match<br>", $error_array)) echo "Passwords don't match<br>";
                        else if(in_array("Password must be between 8 and 20 characters long<br>", $error_array)) echo "Password must be between 8 and 20 characters long<br>";
                        else if(in_array("Password must contain at least one capital letter and one number<br>", $error_array)) echo "Password must contain at least one capital letter and one number<br>";
                        else if($password_msg != "") echo $password_msg;?>

                    <input type="submit" name='register_button' value='Register'/>
                    <br>
                    <a href="#" id="login" class="login">Login here</a>
                    <?php 
                        if(isset($success_msg)) {
                            echo $success_msg;
                        }
                        ?>
                </form>

            </div>

            </div>
    </div>
</body>
</html>