<?php
    include 'connection.php';
    
    $uid = $_REQUEST['u_id'];
    $drid = $_REQUEST['order_id'];
    $cid = $_REQUEST['c_id'];
    $ordertime = $_REQUEST['order_time'];
    $orderdata = $_REQUEST['order_data'];
    $totalamount = $_REQUEST['order_total_amount'];
    
    $saletotal = "SELECT `bill_counter` FROM `sales` WHERE `sales`.`c_id` =  $cid AND `sales`.`u_id` =  $uid;";
    $ressaletotal = mysqli_query($conn, $saletotal);
    
    if (mysqli_num_rows($ressaletotal) > 0) {
        
        mysqli_data_seek($ressaletotal, mysqli_num_rows($ressaletotal) - 1);
        $row = mysqli_fetch_assoc($ressaletotal);
        $billcounter = $row['bill_counter'] + $totalamount;
        
    } else {
        
        $billcounter = $totalamount;
        
    }
    
    date_default_timezone_set('Asia/Kolkata');
    $saletime= date('d/m/Y H:i:s ', time());
    $currentTimestamp = time();

    $salesdate = date('d-m-Y', $currentTimestamp);
    $salestime = date('H:i:s', $currentTimestamp);
    
    $stmt = $conn->prepare("UPDATE `dailyrequest` SET `dr_status` = '1', `d_t` = ? WHERE `dailyrequest`.`dr_id` = ?");
    $stmt->bind_param("si" , $saletime, $drid);
    $res = $stmt->execute();
    
    if($res){
        
        $sadd = $conn->prepare("INSERT INTO `sales` (`u_id`, `c_id`, `dr_id`, `req_time`, `dr_order`, `req_total_amount`, `bill_counter`, `date`, `time`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sadd->bind_param("iiissiiss" , $uid, $cid, $drid, $ordertime, $orderdata, $totalamount, $billcounter, $salesdate, $salestime);
        $add = $sadd->execute();
        if($add){
            $response = [
                "success" => "true",
                "message" => "Request Delivered Successfully.",
                "data" => ""
            ];
        }else{
            $response = [
                "success" => "false",
                "message" => "Daily Request Not Added Successfully Error: " . $sql . "<br>" . $conn->error ,
                "data" => ""
            ];
        }
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
    
    $data1 = "set_delivered_status";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);
?>