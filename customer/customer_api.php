<?php
    include 'connection.php';
    
    $uid = $_REQUEST["u_id"];
    $s_key = $_REQUEST["keyword"];
    
    if(!isset($s_key) || empty($s_key)){
        $query_c = "SELECT * FROM customer WHERE u_id = '$uid' AND `c_status` = 0";
        $result_c = mysqli_query($conn, $query_c);
    }else{
        $query_c = "SELECT * FROM customer WHERE u_id = '$uid' AND `c_status` = 0 AND c_name LIKE '%$s_key%'";
        $result_c = mysqli_query($conn, $query_c);
    }
    
    $customers = array();
    
    if (mysqli_num_rows($result_c) > 0) {

        while ($row = $result_c->fetch_assoc()) {
            $customer = array(
                "c_id" => $row['c_id'],
                "c_name" => $row['c_name'],
                "c_number" => $row['c_number'],
                "c_address" => $row['c_address'],
                "c_office" => $row['c_office'],
                "alert_type" => $row['alert_type'],
            );
            $customers[] = $customer;
        }
        $response = array(
            "success" => true,
            "message" => "Customers fetch Successful",
            "data" => array(
                "customers" => $customers
            )
        );
        
    } else {
        $response['success'] = false;
        $response['message'] = "No Customer";
    }

    echo json_encode($response);
    
    mysqli_close($conn);
    
    include 'maintainlog.php';

    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "customer_api";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
?>