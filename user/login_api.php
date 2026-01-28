<?php
    include 'connection.php';
    
    // Get the POST data
    $uemail = $_REQUEST["u_email"];
    $password = $_REQUEST["u_pass"];

    $query_l = "SELECT * FROM user WHERE u_email = '$uemail' && u_pass = '$password';";
    $result_l = mysqli_query($conn, $query_l);
    $row_l = mysqli_fetch_array($result_l);

    // $name = "u_id";
    // $value = $row_l['u_id'];
    // $expiration = time() + (10 * 365 * 24 * 60 * 60); // Expires in 10 years
    // $path = "/";
    // $domain = ""; 
    // $secure = false; 
    // $httponly = true;

    // setcookie($name, $value, $expiration, $path, $domain, $secure, $httponly);
    
    if (mysqli_num_rows($result_l) > 0) {

        $success = true;
        $message = "Login Successful";
        $data = [
            "uid" => $row_l['u_id'],
            "email" => $row_l['u_email'],
            "name" => $row_l['u_name'],
            "contact" => $row_l['u_number']
        ];

        // Prepare the response array
        $response = [
            "success" => $success,
            "message" => $message,
            "data" => $data
        ];
        
    } else {
        // User login failed
        $response['success'] = false;
        $response['message'] = "Invalid username or password.";
    }

    // Convert the response to JSON format
    echo json_encode($response);
    
    mysqli_close($conn);
    
    include 'maintainlog.php';
        
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $data1 = "login_api";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>