<?php
        include 'connection.php';

        $u_id = $_REQUEST['u_id'];
        $c_id = $_REQUEST['c_id'];
        
        // $filterdata = json_decode($_REQUEST['filter_data'],true);
        
        if ($_REQUEST['filter_type'] == NULL || empty($_REQUEST['filter_type'])){
            
            $query = "SELECT * FROM `sales` WHERE `u_id` = '$u_id' AND `c_id` = '$c_id' ORDER BY `date`;";
            $result = mysqli_query($conn, $query);
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            
            if (!empty($data)){
                $response = array(
                        'success' => 'true',
                        'message' => 'Sales Data Found.',
                        'data' => $data,
                    );
            } else {
                $response = array(
                    'success' => 'false',
                    'message' => 'No Sales Data Found.',
                    'data' => "",
                );
            }
            
        }else{
            
            if($_REQUEST['filter_type'] == "date"){
                
                if($_REQUEST['start_date'] != NULL || !empty($_REQUEST['start_date'])){
                    
                    if($_REQUEST['end_date'] != NULL || !empty($_REQUEST['end_date'])){
                        
                        $startdate = date('d-m-Y', strtotime($_REQUEST['start_date']));
                        $enddate = date('d-m-Y', strtotime($_REQUEST['end_date']));
                        
                        // echo $startdate;
                        // echo $enddate;
                        
                        $query = "SELECT * FROM `sales` WHERE `u_id` = '$u_id' AND `c_id` = '$c_id' AND `date` BETWEEN '$startdate' AND '$enddate' ORDER BY `date`;";
                        $result = mysqli_query($conn, $query);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $data[] = $row;
                            }
                        }
                        
                        if (!empty($data)){
                            $response = array(
                                    'success' => 'true',
                                    'message' => 'Sales Data Found.',
                                    'data' => $data,
                                );
                        } else {
                            $response = array(
                                'success' => 'false',
                                'message' => 'No Sales Data Found.',
                                'data' => "",
                            );
                        }
                        
                    }else{
                        $response = array(
                            'success' => 'false',
                            'message' => 'Select End Date.',
                            'data' => "",
                        );
                    }
                    
                }else{
                    $response = array(
                        'success' => 'false',
                        'message' => 'Select Start Date.',
                        'data' => "",
                    );
                }
                
            }elseif($_REQUEST['filter_type'] == "month"){
                
                if($_REQUEST['month'] != NULL || !empty($_REQUEST['month'])){
                    
                    $month = $_REQUEST['month'];
                    
                    $query = "SELECT * FROM `sales` WHERE `u_id` = '$u_id' AND `c_id` = '$c_id' AND MONTH(STR_TO_DATE(date, '%d-%m-%Y')) = $month ORDER BY `date`;";
                    $result = mysqli_query($conn, $query);
            
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                    }
                    
                    if (!empty($data)){
                        $response = array(
                                'success' => 'true',
                                'message' => 'Sales Data Found.',
                                'data' => $data,
                            );
                    } else {
                        $response = array(
                            'success' => 'false',
                            'message' => 'No Sales Data Found.',
                            'data' => "",
                        );
                    }
                    
                }else{
                    $response = array(
                        'success' => 'false',
                        'message' => 'Select Month.',
                        'data' => "",
                    );
                }
                
            }
                
        }
        
        
        echo json_encode($response);

        include 'maintainlog.php';

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $data1 = "sales_specific_list";
        $data2 = $jsonData;
        $data3 = json_encode($data);
        
        maintain_log($data1, $data2, $data3);
?>