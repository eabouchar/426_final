<?php
// Sessions: https://www.tutorialspoint.com/php/php_sessions.htm

session_start();
$con = mysqli_connect("localhost", "root", "", "final_project");

if(mysqli_connect_errno()) {
    echo "Failed to connect " + mysqli_connect_errno();
}


// Variables to prevent errors
$username = "";
$email = "";
$email2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = [];
$password_msg = "";


// https://www.ostraining.com/blog/coding/retrieve-html-form-data-with-php/
if(isset($_POST['register_button'])) {
    
    $username = strip_tags($_POST['reg_username']);
    $username = str_replace(' ', '', $username);
    $_SESSION['reg_username'] = $username;

    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(' ', '', $email);
    $_SESSION['reg_email'] = $email;

    $email2 = strip_tags($_POST['reg_emailc']);
    $email2 = str_replace(' ', '', $email2);
    $_SESSION['reg_emailc'] = $email2;

    $password = strip_tags($_POST['reg_password']);
    $_SESSION['reg_password'] = $password;

    $password2 = strip_tags($_POST['reg_passwordc']);
    $_SESSION['reg_passwordc'] = $password2;

    $date = date("Y-m-d"); // current date

    // username validity check
      // https://www.php.net/manual/en/function.filter-var.php
     // https://www.w3schools.com/PHP/php_ref_mysqli.asp && https://www.w3schools.com/Php/func_mysqli_num_rows.asp
    
     if(strlen($username) > 25 || strlen($username) == 0) {
        array_push($error_array, "Your username must be between 1 and 25 characters long<br>");
    } else {

        $sql_username_check = mysqli_query($con, "SELECT email FROM users where username='$username'");

        $num_rows = mysqli_num_rows($sql_username_check);

        if($num_rows > 0) {
            array_push($error_array, "That username is unavailable<br>");
        }
    }
        

    // email validity check
    if($email == $email2) {
       // https://www.php.net/manual/en/function.filter-var.php
       // https://www.w3schools.com/PHP/php_ref_mysqli.asp && https://www.w3schools.com/Php/func_mysqli_num_rows.asp
       if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            $sql_email_check = mysqli_query($con, "SELECT email FROM users where email='$email'");

            $num_rows = mysqli_num_rows($sql_email_check);

            if($num_rows > 0) {
                array_push($error_array, "That email is already in use<br>");
            }

        } else {
            array_push($error_array, "Please enter a valid email address<br>");
        }

    } else {
        array_push($error_array, "Emails don't match<br>");
    }

    // password validity check: https://www.imtiazepu.com/password-validation/
    if($password != $password2) {
        array_push($error_array, "Passwords don't match<br>");
    } 

    if (strlen($password) >= 8 || strlen($password) <= 20) {
        if (preg_match("#.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*#", $password)) {
            $password_msg = "Strong password<br>";
        } else if (preg_match("#.*(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*#", $password)) {
            $password_msg = "Not bad... Try adding a symbol to make the password stronger<br>";
        } else {
            array_push($error_array, "Password must contain at least one capital letter and one number<br>");
        }

    } else {
        array_push($error_array, "Password must be between 8 and 20 characters long<br>");
    }

    if(empty($error_array) && $username && $email && $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $rand = rand(1, 2); // come back and have the user choose favourite genre from dropdown - assign pp from there
        switch ($rand) {
            case 1:
                $profile_pic = "resources\images\p_ps\defaults\book_pp.jpeg";
                break;
            case 2;
                $profile_pic = "resources\images\p_ps\defaults\book_pp2.jpeg";
                break;
        }

        $query = mysqli_query($con, "INSERT INTO users VALUES(NULL, '$username', '$email', '$password', '$date', '$profile_pic', '0', ',')");

        $success_msg = "<span style='color: #ffc0cb'>You're all set! Go ahead and log in!</span><br>";
    
        // clear session variables
        session_unset();
    
    }




} // bracket closes if register button clicked statement



?>

<html>
<head>
    <title>Welcome to bookweb</title>
</head>
<body>
<!-- 
inline php: https://www.ntchosting.com/encyclopedia/scripting-and-programming/php/php-in/ -->
   
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

        <?php 
            if(isset($success_msg)) {
                echo $success_msg;
            }
            ?>
    </form>
</body>
</html>