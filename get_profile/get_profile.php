<?php
    include 'connection.php';
    
    $u_id = $_REQUEST["u_id"];
    
    $query_l = "SELECT * FROM user WHERE u_id = '$u_id';";
    $result_l = mysqli_query($conn, $query_l);
    $row_l = mysqli_fetch_array($result_l);
    
    if (mysqli_num_rows($result_l) > 0) {

        $success = true;
        $message = "Data found";
        $data = [
            "uid" => $row_l['u_id'],
            "email" => $row_l['u_email'],
            "name" => $row_l['u_name'],
            "contact" => $row_l['u_number'],
            "account_number" => $row_l['ac_number'],
            "bank_person_name" => $row_l['name_as_per_bank'],
            "bank_name" => $row_l['bank_name'],
            "ifsc_code" => $row_l['ifsc_code'],
        ];

        $response = [
            "success" => $success,
            "message" => $message,
            "data" => $data
        ];
        
    } else {
        $response['success'] = false;
        $response['message'] = "Invalid username or password.";
    }
    
    echo json_encode($response);
           
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "get_profile";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
?>