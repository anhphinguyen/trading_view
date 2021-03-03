<?php

if(isset($_REQUEST['session_time_open']) && !empty($_REQUEST['session_time_open'])){
    $session_time_open = $_REQUEST['session_time_open'];
    $sql = "SELECT session_time_open FROM tbl_trading_session";
    $result = db_qr($sql);
    $num = db_nums($result);
    if($num > 0){
        while($row = db_assoc($result)){
            if(date('d', $row['session_time_open']) == date('d', $session_time_open)){
                returnError("Đã tạo sàn cho ngày này");
            }
        }
    }
}else{
    returnError("Nhập session_time_open");
}

if(isset($_REQUEST['session_time_living']) && !empty($_REQUEST['session_time_living'])){
    $session_time_living = $_REQUEST['session_time_living'];
}else{
    returnError("Nhập session_time_living");
}

if(isset($_REQUEST['session_time_close']) && !empty($_REQUEST['session_time_close'])){
    $session_time_close = $_REQUEST['session_time_close'];
}else{
    returnError("Nhập session_time_close");
}

$delta_time = $session_time_close - $session_time_open;

$quantity = $delta_time / $session_time_living;

$time_start = $session_time_open;

$sql = "INSERT INTO tbl_trading_stock SET
        stock_time_open = '$session_time_open',
        stock_time_close = '$session_time_close',
        stock_time_living = '$session_time_living',
        stock_quantity = '$quantity'";
if(db_qr($sql)){
    $id_stock = mysqli_insert_id($conn);

    for($i = 1; $i <= $quantity; $i++){
        $time_session = $time_start + $session_time_living;
        $time_break = $time_session - 60;  // mặc đinh thời gian không cho phép đặt cược là 60s
        $sql = "INSERT INTO tbl_trading_session SET 
                id_stock = '$id_stock',
                session_number = '$i',
                session_time_open = '$time_start', 
                session_time_break = '$time_break',
                session_time_close = '$time_session'";
        if(db_qr($sql)){
            $success = true;
        };
        $time_start = $time_session;
    }
    if(isset($success)){
        returnSuccess("Tạo sàn thành công");
    }
}



// $sql = "INSERT INTO tbl_trading_session SET 
//         session_time_open = '$session_time_open', 
//         session_time_living = '$session_time_living',
//         session_time_close = '$session_time_close'";
// if(db_qr($sql)){
//     $id_insert = mysqli_insert_id($conn);

//     $sql = "SELECT * FROM tbl_trading_session WHERE id = '$id_insert'";
//     $result = db_qr($sql);
//     if(db_nums($result)){
//         while($row = db_assoc($result)){
//             $result_arr = array(
//                 'session_time_open' => $row['session_session_time_open'],
//                 'session_time_living' => $row['session_session_time_living'],
//                 'session_time_close' => $row['session_session_time_close'],
//                 'status' => $row['session_status']
//             ); 
//         }
//         reJson($result);
//     }
// }