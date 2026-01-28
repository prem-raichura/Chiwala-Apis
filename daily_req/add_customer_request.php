<?php
    include 'connection.php';
    
    $data = json_decode($_REQUEST['req_data'], true);
    $reqtime = $_REQUEST['req_order_time'];
    $uid = $_REQUEST['u_id'];
    $cid = $_REQUEST['customer_id'];
    // $uniqueid = $cid."_".time()."_".rand(1,999);
    
    $dradd = $conn->prepare("INSERT INTO `dailyrequest` (`u_id`, `c_id`, `req_time`, `dr_order`) VALUES (? , ?, ?, ?)");
    $dradd->bind_param("iiss" , $uid, $cid, $reqtime, $_REQUEST['req_data']);
    
    $add = $dradd->execute();
        
    if($add){
        $response = [
            "success" => "true",
            "message" => "Request Added Successfully.",
            "data" => ""
        ];
    }else{
        $response = [
            "success" => "false",
            "message" => "Daily Request Not Added Successfully Error: " . $sql . "<br>" . $conn->error ,
            "data" => ""
        ];
    }
    
    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "add_customer_request";
    $data2 = $data;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);
    
?>