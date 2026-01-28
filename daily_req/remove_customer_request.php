<?php

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    include 'connection.php';
    
    // $data = json_decode($_REQUEST['req_data'], true);
    // $reqtime = $_REQUEST['req_order_time'];
    $uid = $_REQUEST['u_id'];
    $cid = $_REQUEST['customer_id'];
    $drid = $_REQUEST['req_id'];
    
    $query = "DELETE FROM dailyrequest WHERE `u_id` = $uid AND `c_id` = $cid AND `dr_id` = $drid;";
    $result = mysqli_query($conn, $query);
    
    if($result){
        $response = [
                "success" => "true",
                "message" => "Request Deleted Successfully",
                "data" => ""
            ];
    }else{
        $response = [
                "success" => "false",
                "message" => "Request Not Deleted Error: " . $sql . "<br>" . $conn->error,
                "data" => ""
            ];
    }
    
    
    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "remove_customer_request";
    $data2 = $data;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);
?>