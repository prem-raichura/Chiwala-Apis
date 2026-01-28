<?php
        $response = array();   
        include 'connection.php';

        $p_id = $_REQUEST["p_id"];
        $u_id = $_REQUEST["u_id"];
        $p_name = $_REQUEST["product_name"];
        $p_price = $_REQUEST["product_price"];
        $type = $_REQUEST['type'];
                        
        if(empty($u_id) || empty($p_name) || empty($p_price) || empty($type)){
                $response = "Details Can't Be Empty";
        }else{
            if($type == "add"){
                $query = "INSERT INTO `product` (`u_id`, `p_name`, `p_price`) 
                        VALUES ('$u_id', '$p_name', '$p_price');";  
                $result = mysqli_query($conn, $query);

                if($result){
                    $response = array(
                            "success" => true,
                            "message" => "Product Added",
                            "data" => ""
                        );
                }else{
                    $response = array(
                            "success" => false,
                            "message" => "Product Not Added",
                            "data" => ""
                        );
                }
            }
            if($type == "update"){
                $query = "UPDATE `product` SET `p_name` = '$p_name', `p_price` = '$p_price' 
                    WHERE `product`.`p_id` = '$p_id';";  
                $result = mysqli_query($conn, $query);

                if($result){
                    $response = array(
                            "success" => true,
                            "message" => "Product Updated",
                            "data" => ""
                        );
                }else{
                    $response = array(
                            "success" => false,
                            "message" => "Product Not Updated",
                            "data" => ""
                        );
                }
            }
    }
    echo json_encode($response);
       
    include 'maintainlog.php';
        
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $data1 = "product_add_update";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>