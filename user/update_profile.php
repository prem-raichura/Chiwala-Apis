<?php
        include 'connection.php';

        $u_id = $_REQUEST["u_id"];
        $u_name = $_REQUEST["u_name"];
        $u_number = $_REQUEST["u_contact"];
        $u_email = $_REQUEST["u_email"];
        $ac_number = $_REQUEST["account_number"];
        $bank_name = $_REQUEST["bank_name"];
        $isfc_code = $_REQUEST["ifsc_code"];
        $name_as_per_bank = $_REQUEST["bank_person_name"];
        
        $response = array(); 
                        
        if(empty($u_id) || empty($u_name) || empty($u_number) || empty($u_email)){
                $response['message'] = "Details Can't Be Empty";
        }else{
                $query = "UPDATE `user` SET `u_name` = '$u_name', `u_number` = $u_number, 
                        `u_email` = '$u_email' , `name_as_per_bank` = '$name_as_per_bank', `bank_name` = '$bank_name', `ac_number` = '$ac_number', `ifsc_code` = '$isfc_code' WHERE `user`.`u_id` = $u_id;";  
                $result = mysqli_query($conn, $query);

                if($result){
                    $response = array(
                    "success" => true,
                    "message" => "Profile Updated",
                    );
                }else{
                    $response['success'] = false;
                    $response['message'] = "Can't Update";
            }
        }
    echo json_encode($response);
               
    include 'maintainlog.php';
        
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $data1 = "update_profile";
        $data2 = $jsonData;
        $data3 = json_encode($response);
        
        maintain_log($data1, $data2, $data3);
?>