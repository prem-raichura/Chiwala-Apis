<?php
    include 'connection.php';
    
    $sid = $_REQUEST['s_id'];
    // $uid = $_REQUEST['u_id'];
    // $drid = $_REQUEST['order_id'];
    // $cid = $_REQUEST['c_id'];
    // $ordertime = $_REQUEST['order_time'];
    $orderdata = $_REQUEST['order_data'];
    $totalamount = $_REQUEST['order_total_amount'];
    
    $saletotal = "SELECT `req_total_amount`, `bill_counter` FROM `sales` WHERE `sales`.`s_id` = $sid;";
    $ressaletotal = mysqli_query($conn, $saletotal);
    
    if ($ressaletotal) {
        $row = mysqli_fetch_assoc($ressaletotal);
        $oldcounter = $row['bill_counter'] - $row['req_total_amount'];
        $final_bill_counter =  $oldcounter + $totalamount;
        
        $query = "UPDATE `sales` SET `dr_order` = '$orderdata', `req_total_amount` = '$totalamount', `bill_counter` = '$final_bill_counter' WHERE `sales`.`s_id` = $sid;";  
        $result = mysqli_query($conn, $query);
        
        if($result){
            $response = [
                "success" => "true",
                "message" => "Delivered Order Updated.",
                "data" => ""
            ];
        }else{
            $response = [
                "success" => "false",
                "message" => "Delivered Order Not Updated. Error: " . $sql . "<br>" . $conn->error ,
                "data" => ""
            ];
        }
        
    } else {
        echo "Error executing query: " . mysqli_error($conn);
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