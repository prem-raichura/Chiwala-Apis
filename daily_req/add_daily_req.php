<?php
    include 'connection.php';
    
    $body1 = $_REQUEST['body_value'];
    
    $body = json_decode($body1, true);
    $uid = $body['u_id'];
    $cid = $body['customer']['c_id'];
    
    $flag = true; // Set initial flag value
    
    // Delete all records for the customer
    $delall = "DELETE FROM dailyrequest WHERE c_id = $cid";
    $del = mysqli_query($conn, $delall);
    
    for ($orderNumber = 1; $orderNumber <= 5; $orderNumber++) {
        $currentOrder = $body['order_data']["order_$orderNumber"];
        
        if (!empty($currentOrder)) {
            foreach ($currentOrder as $item) {
                $qyt = $item['qty'];
                $pid = $item['product']['p_id'];
                $pname = $item['product']['p_name'];
                $pprice = $item['product']['p_price'];
    
                $dradd = $conn->prepare("INSERT INTO `dailyrequest` (`u_id`, `p_id`, `c_id`, `order_no`, `dr_product`, `dr_price`, `dr_quantity`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $dradd->bind_param("iiiisii", $uid, $pid, $cid, $orderNumber, $pname, $pprice, $qyt);
    
                $add = $dradd->execute();
                
                if (!$add) {
                    $flag = false;
                    // Handle error logging or other actions
                }
            }
        }
    }
    
    if ($flag) {
        $response = [
            "success" => "true",
            "message" => "Daily Request Added Successfully".$pname,
            "data" => ""
        ];
    } else {
        $response = [
            "success" => "false",
            "message" => "Daily Request Not Added Successfully Error: " . $sql . "<br>" . $conn->error . $qyt,
            "data" => ""
        ];
    }
    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "add_daily_req";
    $data2 = $data;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);
?>
