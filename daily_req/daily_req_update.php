<?php
        include 'connection.php';
        include 'maintainlog.php';

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {

        if ($data === null) {
            $response = array(
                "status" => "false",
                "message" => "Error parsing JSON data."
            );
            echo json_encode($response);
            exit;
        }
        date_default_timezone_set('Asia/Kolkata');
        $t= date('d/m/Y H:i:s ', time());
        $time= date('d/m/Y H:i:s ', time());
        
        $u_id = $data['u_id'];

        $customer = $data['customer'];
        $c_id = $customer['c_id'];
        $c_name = $customer['c_name'];
        $c_office = $customer['c_office'];
        $c_address = $customer['c_address'];
        $c_contact = $customer['c_contact'];
        
                
        $query = "UPDATE `dailyrequest` SET `dr_status` = '1', `d_t` = '$t' WHERE `dailyrequest`.`c_id` = $c_id;";
        $result = mysqli_query($conn, $query);
        
        $products = $data['products'];
        if($result){
            foreach ($products as $product) {
                $p_id = $product['p_id'];
                $p_name = $product['p_name'];
                $p_price = $product['p_price'];
                $qty = $product['qty'];
                $que = "INSERT INTO `sales` (`u_id`, `c_id`, `c_name`, `c_office`, `c_address`, `c_contact`, `p_id`, `p_name`, `p_price`, `qty`,`date_time`) VALUES ('$u_id', '$c_id', '$c_name', '$c_office', '$c_address', '$c_contact', '$p_id', '$p_name', '$p_price', '$qty','$time');";
                $res = mysqli_query($conn, $que);
            }               
        }
        if($res){
            $response = array(
                "status" => "true",
                "message" => "Product Delivered"
                );
            }
        echo json_encode($response);
    }        
        $data1 = "daily_req_update";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>