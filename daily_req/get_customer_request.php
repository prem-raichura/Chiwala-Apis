<?php
    include 'connection.php';
    
    $uid = $_REQUEST['u_id'];
    $cid = $_REQUEST['customer_id'];
    
    $query_c = "SELECT * FROM dailyrequest WHERE u_id = ? AND c_id = ? ORDER BY req_time";
    $stmt = $conn->prepare($query_c);
    $stmt->bind_param("ss", $uid, $cid);
    $stmt->execute();
    $result_c = $stmt->get_result();
    
    // if(!empty($result_c->fetch_assoc())){
        
        $response = array(
            'success' => 'true',
            'message' => 'Request Found Successfully.',
            'data' => array()
        );
        
        while ($row = $result_c->fetch_assoc()) {
            $reqId = $row['dr_id'];
    
            $response['data'][] = array(
                'u_id' => $row['u_id'],
                'req_id' => $reqId,
                'customer_id' => $row['c_id'],
                'req_data' => json_decode($row['dr_order']),
                'req_order_time' => $row['req_time'],
            );
        }
    // }else{
    //     $response = array(
    //         'success' => 'false',
    //         'message' => 'No Data Found.',
    //         'data' => ""
    //     );
    // }

    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "get_customer_request";
    $data2 = $data;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);
    
?>