<?php
include 'database.php';


if (isset($_POST['name'])) {

    $messageRecieved = $_POST['name'];
    echo "message is ". $messageRecieved;

    $name = mysqli_escape_string($conn, $messageRecieved);


    $query = "INSERT into sailors(sname) VALUES ('$name')";

    mysqli_query($conn, $query);
    echo "name ". $name . " added";



  }
?>