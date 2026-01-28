<?php
    include 'connection.php';
    // $uid = $_COOKIE["u_id"];
    
    $uid = $_REQUEST["u_id"];
    $s_key = $_REQUEST["keyword"];
    
    if(!isset($s_key) || empty($s_key)){
        $query_p = "SELECT * FROM product WHERE u_id = '$uid' AND `p_status` = 0";
        $result_p = mysqli_query($conn, $query_p);
    }else{
        $query_p = "SELECT * FROM product WHERE u_id = '$uid' AND `p_status` = 0 AND p_name LIKE '%$s_key%'";
        $result_p = mysqli_query($conn, $query_p);
    }
    
    
    $products = array();

    // Prepare the response structure
    if (mysqli_num_rows($result_p) > 0) {

        // Prepare the response array
        while ($row = $result_p->fetch_assoc()) {
            $product = array(
                "p_id" => $row['p_id'],
                "p_name" => $row['p_name'],
                "p_price" => $row['p_price'],
            );
            $products[] = $product;
        }
        $response = array(
            "success" => true,
            "message" => "Products fetch Successful",
            "data" => array(
                "products" => $products
            )
        );
        
    } else {
        $response['success'] = false;
        $response['message'] = "No Products";
    }

    // Convert the response to JSON format
    echo json_encode($response);
                
    mysqli_close($conn);
           
    include 'maintainlog.php';
        
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $data1 = "product_api";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>