<?php
        $response = array();   
        include 'connection.php';
        include 'maintainlog.php';
        
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);

        $p_id = $_REQUEST["p_id"];
                        
        if(empty($p_id)){
                $response = "Details Can't Be Empty";
        }else{
                $query = "UPDATE `product` SET `p_status` = '1' WHERE `product`.`p_id` = '$p_id';";  
                $result = mysqli_query($conn, $query);

                if($result){
                    $response = array(
                            "success" => true,
                            "message" => "Product Deleted",
                            "data" => ""
                        );
                }else{
                    $response = array(
                            "success" => false,
                            "message" => "Product Not Deleted",
                            "data" => ""
                        );
            }
        }
    echo json_encode($response);
        
        $data1 = "del_product";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>