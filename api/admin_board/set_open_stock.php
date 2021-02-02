<?php

if(isset($_REQUEST['time_open']) && !empty($_REQUEST['time_open'])){
    $time_open = $_REQUEST['time_open'];
}else{
    returnError("Nhập time_open");
}

if(isset($_REQUEST['time_living']) && !empty($_REQUEST['time_living'])){
    $time_living = $_REQUEST['time_living'];
}else{
    returnError("Nhập time_living");
}

if(isset($_REQUEST['time_refresh']) && !empty($_REQUEST['time_refresh'])){
    $time_living = $_REQUEST['time_refresh'];
}else{
    returnError("Nhập time_refresh");
}


$sql = "INSERT INTO tbl_trading_stock SET 
        stock_time_open = '$time_open', 
        stock_time_living = '$time_living',
        stock_time_refresh = '$time_refresh'";
if(db_qr($sql)){
    $id_insert = mysqli_insert_id($conn);

    $sql = "SELECT * FROM tbl_trading_stock WHERE id = '$id_insert'";
    $result = db_qr($sql);
    if(db_nums($result)){
        while($row = db_assoc($result)){
            $result_arr = array(
                'time_open' => $row['stock_time_open'],
                'time_living' => $row['stock_time_living'],
                'time_refresh' => $row['stock_time_refresh'],
                'status' => $row['stock_status']
            ); 
        }
        reJson($result);
    }
}