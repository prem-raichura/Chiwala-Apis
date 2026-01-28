<?php

include 'connection.php';

    $que = "SELECT * FROM `dailyrequest`;";
    $res = mysqli_query($conn, $que);

    date_default_timezone_set('Asia/Kolkata');
    
    // $twentyFourHoursAgo = strtotime('-23 hours -30 minutes');
    $twentyFourHoursAgo = strtotime('-30 seconds');
    $formattedTime  = date('d/m/Y H:i:s ', $twentyFourHoursAgo);
    
    if(mysqli_num_rows($res) > 0){
        while($row = mysqli_fetch_assoc($res)){
            
            $c_id = $row['c_id'];
            $dt = $row['d_t'];
            
            if(!empty($dt)){
                $date1 = $dt;
                $date2 = $formattedTime;
                
                if ($date1 <= $date2){
                    $q = "UPDATE `dailyrequest` SET `dr_status` = '0', `d_t` = '' 
                            WHERE `dailyrequest`.`c_id` = $c_id;";
                    $r = mysqli_query($conn, $q);
                }
            }
        }
    }

function fetchDataFromDatabase()
{
    include 'connection.php';

    $uid = $_REQUEST["u_id"];

    $data = array();

    $query = "SELECT `customer`.*,`dailyrequest`.* 
            FROM dailyrequest JOIN `customer` ON `dailyrequest`.c_id = `customer`.c_id WHERE `customer`.`u_id`= '$uid'
            AND `customer`.`c_status` = 0 ORDER BY `customer`.`c_id` ASC";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function getDailyRequestList()
{
    $dataFromDatabase = fetchDataFromDatabase();

    $response = array(
        "success" => true,
        "message" => "daily request list fetched.",
        "data" => array(),
    );

    $previousCId = null;
    $products = array();

    foreach ($dataFromDatabase as $request) {
        $currentCId = $request["c_id"];
        $customer = array(
            "c_id" => $request["c_id"],
            "c_name" => $request["c_name"],
            "c_office" => $request["c_office"],
            "c_address" => $request["c_address"],
            "c_contact" => $request["c_number"],
        );
            $product = array(
                "p_id" => $request["p_id"],
                "p_name" => $request["dr_product"],
                "p_price" => $request["dr_price"],
                "qty" => $request["dr_quantity"],
            );
        
            if ($currentCId === $previousCId) {
                $products[] = $product;
            } else {
                if (!empty($products)) {
                    $requestItem["products"] = $products;
                    $response["data"][] = $requestItem;
                }
                $requestItem = array(
                    "status" => $request["dr_status"],
                    "customer" => $customer,
                );
                $products = array($product);
            }
    
            $previousCId = $currentCId;
        }
    
        // Add the last request item to the response
        if (!empty($products)) {
            $requestItem["products"] = $products;
            $response["data"][] = $requestItem;
        }else{
            $response = array(
        "success" => false,
        "message" => "daily request list not fetched.",
        "data" => array(),
    );
        }
    
        return $response;
}

$responseData = getDailyRequestList();
echo json_encode($responseData);

    include 'maintainlog.php';
        
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "daily_req_list";
    $data2 = $jsonData;
    $data3 = json_encode($responseData);
    
    maintain_log($data1, $data2, $data3);
?>
