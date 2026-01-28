<?php

    include 'connection.php';
    
    $que = "SELECT * FROM `dailyrequest`;";
    $res = mysqli_query($conn, $que);
    
    date_default_timezone_set('Asia/Kolkata');
    
    $current_date = date('d-m-Y');
    // echo $current_date;
    
    $uid = $_REQUEST["u_id"];

    $sql = "SELECT `customer`.*,`sales`.* 
            FROM sales JOIN `customer` ON `sales`.c_id = `customer`.c_id WHERE `customer`.`u_id`= '$uid'
            AND `customer`.`c_status` = 0 AND `sales`.`date` = '$current_date' ORDER BY `sales`.`req_time`";
    $result = mysqli_query($conn, $sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    if (!empty($data)){
        $response = array(
                'success' => 'true',
                'message' => 'Delivered orders Found.',
                'data' => $data,
            );
    } else {
        $response = array(
            'success' => 'false',
            'message' => 'No Delivered Orders Found.',
            'data' => "",
        );
    }
    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "delivered_list_request";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);

?>

    