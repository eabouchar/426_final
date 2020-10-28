<?php

if(isset($_POST['login_button'])) {

    $username = strip_tags($_POST['login_username']);
    $password = strip_tags($_POST['login_password']);

    $_SESSION['login_username'] = $username;


    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($check_database_query);

    if (isset($row) > 0 && password_verify($password, $row['password'])) {

        $row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];
        
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();

    } else {
        array_push($error_array, "Username or password incorrect");
    }



}

?>