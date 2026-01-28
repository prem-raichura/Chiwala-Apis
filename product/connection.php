<?php
    $servername = "localhost";
    $username = "id19705969_chiwala";
    $password = "Chiwala@1234";
    $dbname = "id19705969_chiwala";
    
    // Create a connection
    $conn =  new mysqli($servername, $username, $password, $dbname);
    
    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
     }else{
        // $response['conn'] = true;
    }
?>