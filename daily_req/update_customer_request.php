<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

    include 'connection.php';
    
    $data = json_decode($_REQUEST['req_data'], true);
    $reqtime = $_REQUEST['req_order_time'];
    $uid = $_REQUEST['u_id'];
    $cid = $_REQUEST['customer_id'];
    $drid = $_REQUEST['req_id'];
    $orders = $_REQUEST['req_data'];
    
    if (!empty($data)){
        
        $stmt = $conn->prepare("UPDATE `dailyrequest` SET `dr_order` = ? WHERE `dr_id` = ?");
        $stmt->bind_param("si" , $orders, $drid);
        $res = $stmt->execute();
        
        if($res){
            $response = [
                "success" => "true",
                "message" => "Request Updated Successfully.",
                "data" => $orders
            ];
        
        }else{
            $response = [
                "success" => "false",
                "message" => $orders."Daily Request Not Added Successfully Error: " . $sql . "<br>" . $conn->error ,
                "data" => ""
            ];
        }
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