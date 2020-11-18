<?php

require 'api.php';

// Variables to prevent errors
$username = "";
$password = "";
$password2 = "";
$date = "";
$error_array = [];
$password_msg = "";

# create instance of API connected to users table in the mysqli backend 
$api = new Api('users');


// https://www.ostraining.com/blog/coding/retrieve-html-form-data-with-php/
if(isset($_POST['register_button'])) {
    
    $username = strip_tags($_POST['reg_username']);
    $username = str_replace(' ', '', $username);
    $_SESSION['reg_username'] = $username;

    $password = strip_tags($_POST['reg_password']);
    $_SESSION['reg_password'] = $password;

    $password2 = strip_tags($_POST['reg_passwordc']);
    $_SESSION['reg_passwordc'] = $password2;

    $date = date("Y-m-d"); // current date

    // username validity check
      // https://www.php.net/manual/en/function.filter-var.php
     // https://www.w3schools.com/PHP/php_ref_mysqli.asp && https://www.w3schools.com/Php/func_mysqli_num_rows.asp
    
     if(strlen($username) > 25 || strlen($username) == 0) {
        array_push($error_array, "username length");
    } else {


        $params = ["col" => "username",
                    "username" => $username,
                    "getCol" => "username"];
        $userInfo = $api->getWhere($params);


        if($userInfo) {

            $error_array['username taken'] = "That username is unavailable<br>";
        }
    }
        

    
    // password validity check: https://www.imtiazepu.com/password-validation/
    if($password != $password2) {
        array_push($error_array, "Passwords don't match<br>");
    } 

    if (strlen($password) >= 8 || strlen($password) <= 20) {
     if (preg_match("#.*(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*#", $password)) {
        } else {
            array_push($error_array, "Password must contain at least one capital letter and one number<br>");
        }
    } else {
        array_push($error_array, "Password must be between 8 and 20 characters long<br>");
    }

    # is user has entered all details correctly, assign them a random profile pic and add them to the users table
    if(empty($error_array) && $username && $password) {
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

        
        $params = ["username" => $username,
                    "password" => $password,
                    "date" => $date,
                    "pp" => $profile_pic];

            
        
        $posted = $api->postUser($params);

        if($posted) {

        $register_msg = "<span style='color: #ffc0cb'>You're all set! Go ahead and log in!</span><br>";

        } else {
            $register_msg = "<span style='color: #ffc0cb'>Registration failed</span><br>";
        }
    
        // clear session variables
        session_unset();
    
    }




} // bracket closes if register button clicked statement



?>