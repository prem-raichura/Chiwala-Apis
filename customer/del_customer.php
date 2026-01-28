<?php
        $response = array();   
        include 'connection.php';

        $c_id = $_REQUEST["c_id"];
                        
        if(empty($c_id)){
                $response = "Details Can't Be Empty";
        }else{
                $query = "UPDATE `customer` SET `c_status` = '1' WHERE `customer`.`c_id` = '$c_id';";  
                $result = mysqli_query($conn, $query);

                if($result){
                    $response = array(
                    "success" => true,
                    "message" => "Customer Deleted",
                    "data" => ""
                    );
                }else{
                    $response = array(
                    "success" => false,
                    "message" => "Customer Not Deleted",
                    "data" => ""
                    );
            }
        }
    echo json_encode($response);
    
    include 'maintainlog.php';
        
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $data1 = "del_customer";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>