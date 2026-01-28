<?php

    include 'connection.php';
    
    $uid = $_REQUEST["u_id"];
    $cid = $_REQUEST["c_id"];
    
    // Use prepared statements to prevent SQL injection
    $query_c = "SELECT * FROM dailyrequest WHERE u_id = ? AND c_id = ?";
    $stmt = $conn->prepare($query_c);
    $stmt->bind_param("ss", $uid, $cid);
    $stmt->execute();
    $result_c = $stmt->get_result();
    
    $data = [];
    
    if ($result_c) {
        while ($row = $result_c->fetch_assoc()) {
            $order_no = $row['order_no'];
            $order_key = "order_" . $order_no;
    
            if (!array_key_exists($order_key, $data)) {
                $data[$order_key] = [];
            }
    
            $data[$order_key][] = [
                "qty" => $row['dr_quantity'],
                "product" => [
                    "p_id" => $row['p_id'],
                    "p_name" => $row['dr_product'],
                    "p_price" => $row['dr_price']
                ]
            ];
        }
    
        if (!empty($data)) {
            $response = [
                "success" => true,
                "message" => "Data Found Successfully",
                "data" => $data
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "No Data Found",
                "data" => $data
            ];
        }
    } else {
        $response = [
            "success" => false,
            "message" => "Error in database query",
            "data" => []
        ];
    }
    
    // Close the database connection
    $stmt->close();
    $conn->close();
    
    // Output JSON response directly
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    // Assuming `maintain_log` function logs appropriately
    $jsonData = file_get_contents('php://input');
    $data1 = "fetch_daily_req_specific";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
?>
