<?php
$con = mysqli_connect("localhost", "root", "", "final_project");

if(mysqli_connect_errno()) {
    echo "Failed to connect " + mysqli_connect_errno();
}

$query = mysqli_query($con, "INSERT INTO test VALUES(NULL, 'hello world')");


?>



<html>
<head>
    <title></title>
</head>
<body>
    hello
</body>
</html>