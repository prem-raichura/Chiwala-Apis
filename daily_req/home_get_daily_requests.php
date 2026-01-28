<?php

    include 'connection.php';
    
    $que = "SELECT * FROM `dailyrequest`;";
    $res = mysqli_query($conn, $que);
    
    date_default_timezone_set('Asia/Kolkata');
    
    $current_time = date('H:i:s');

    $one_hour_before = date('H:i:s', strtotime('-1 hour', strtotime($current_time)));
    $one_hour_after = date('H:i:s', strtotime('+1 hour', strtotime($current_time)));
    
    $twentyFourHoursAgo = strtotime('-23 hours -30 minutes');
    // $twentyFourHoursAgo = strtotime('-10 seconds');
    $formattedTime  = date('d/m/Y H:i:s ', $twentyFourHoursAgo);
    
    if(mysqli_num_rows($res) > 0){
        while($roww = mysqli_fetch_assoc($res)){
            
            $drid = $roww['dr_id'];
            $dt = $roww['d_t'];
            
            if(!empty($dt)){
                $date1 = $dt;
                $date2 = $formattedTime;
                
                if ($date1 <= $date2){
                    $q = "UPDATE `dailyrequest` SET `dr_status` = '0', `d_t` = NULL 
                            WHERE `dailyrequest`.`dr_id` = $drid;";
                    $r = mysqli_query($conn, $q);
                }
            }
        }
    }
    
    $uid = $_REQUEST["u_id"];

    $sql = "SELECT `customer`.*,`dailyrequest`.* 
            FROM dailyrequest JOIN `customer` ON `dailyrequest`.c_id = `customer`.c_id WHERE `customer`.`u_id`= '$uid'
            AND `customer`.`c_status` = 0 AND `dailyrequest`.`dr_status` = 0 AND TIME(`dailyrequest`.`req_time`) BETWEEN '$one_hour_before' AND '$one_hour_after' ORDER BY `dailyrequest`.`req_time`";
    $result = mysqli_query($conn, $sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    if (!empty($data)){
        $response = array(
                'success' => 'true',
                'message' => 'Daily Requests Found.',
                'data' => $data,
            );
    } else {
        $response = array(
            'success' => 'false',
            'message' => 'No Daily Requests Found.',
            'data' => "",
        );
    }
    
    echo json_encode($response);
    
    include 'maintainlog.php';
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    $data1 = "home_get_daily_requests";
    $data2 = $jsonData;
    $data3 = json_encode($response);
    
    maintain_log($data1, $data2, $data3);
    
    mysqli_close($conn);

?>
