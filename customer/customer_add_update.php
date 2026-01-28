<?php
    
    header("Content-Type: application/json");
    
    $response = array();
    include 'connection.php';
    
    $u_id = isset($_REQUEST["u_id"]) ? $_REQUEST["u_id"] : "";
    $c_name = isset($_REQUEST["c_name"]) ? $_REQUEST["c_name"] : "";
    $c_contact = isset($_REQUEST["c_contact"]) ? $_REQUEST["c_contact"] : "";
    $c_address = isset($_REQUEST["c_address"]) ? $_REQUEST["c_address"] : "";
    $c_office = isset($_REQUEST["c_office"]) ? $_REQUEST["c_office"] : "";
    $alerttype = isset($_REQUEST['alert_type']) ? $_REQUEST['alert_type'] : "";
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
    
    if (empty($u_id) || empty($c_name) || empty($c_contact) || empty($c_address) || empty($c_office) || empty($type)) {
        $response = array(
            "success" => false,
            "message" => "Details can't be empty",
            "data" => ""
        );
    } else {
        $c_name = mysqli_real_escape_string($conn, $c_name);
        $c_contact = mysqli_real_escape_string($conn, $c_contact);
        $c_address = mysqli_real_escape_string($conn, $c_address);
        $c_office = mysqli_real_escape_string($conn, $c_office);
    
        if ($type == "add") {
            $que = "INSERT INTO `customer` (u_id, c_name, c_number, c_address, c_office, alert_type) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $que);
            mysqli_stmt_bind_param($stmt, "issssi", $u_id, $c_name, $c_contact, $c_address, $c_office, $alerttype);
            $res = mysqli_stmt_execute($stmt);
    
            if ($res) {
                $response = array(
                    "success" => true,
                    "message" => "Customer added",
                    "data" => ""
                );
            } else {
                $response = array(
                    "success" => false,
                    "message" => "Customer not added: " . mysqli_error($conn),
                    "data" => ""
                );
            }
        }
    
        if ($type == "update") {
            $c_id = isset($_REQUEST["c_id"]) ? $_REQUEST["c_id"] : "";
    
            $query = "UPDATE `customer` SET `c_name` = ?, `c_number` = ?, `c_address` = ?, `c_office` = ?, `alert_type` = ? WHERE `customer`.`c_id` = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssii", $c_name, $c_contact, $c_address, $c_office, $alerttype, $c_id);
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                $response = array(
                    "success" => true,
                    "message" => "Customer updated",
                    "data" => ""
                );
            } else {
                $response = array(
                    "success" => false,
                    "message" => "Customer not updated: " . mysqli_error($conn),
                    "data" => ""
                );
            }
        }
    }
    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "customer_add_update";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);
?>
