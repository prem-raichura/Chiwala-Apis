<?php
function maintain_log($data1, $data2, $data3) {

    include 'connection.php';

    // Escape user inputs to prevent SQL injection
    $data1 = mysqli_real_escape_string($conn, $data1);
    $data2 = mysqli_real_escape_string($conn, $data2);
    $data3 = mysqli_real_escape_string($conn, $data3);
    date_default_timezone_set('Asia/Kolkata');
    $date = date('d/m/Y h:i:s a', time());

    // SQL query to insert data into the database table
    $sql = "INSERT INTO log (l_api_name, l_data_from_app,l_responce_sent,l_date_time) VALUES ('$data1', '$data2', '$data3','$date')";

    if (mysqli_query($conn, $sql)) {
        // echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>