<?php

if(isset($_REQUEST['stock_time_open']) && !empty($_REQUEST['stock_time_open'])){
    $stock_time_open = $_REQUEST['stock_time_open'];
}else{
    returnError("Nhập stock_time_open");
}

if(isset($_REQUEST['stock_time_living']) && !empty($_REQUEST['stock_time_living'])){
    $stock_time_living = $_REQUEST['stock_time_living'];
}else{
    returnError("Nhập stock_time_living");
}

if(isset($_REQUEST['stock_quantity']) && !empty($_REQUEST['stock_quantity'])){
    $stock_quantity = $_REQUEST['stock_quantity'];
}else{
    returnError("Nhập stock_quantity");
}


$sql = "INSERT INTO tbl_trading_stock SET 
        stock_time_open = '$stock_time_open', 
        stock_time_living = '$stock_time_living',
        stock_quantity = '$stock_quantity'";
if(db_qr($sql)){
    $id_insert = mysqli_insert_id($conn);

    $sql = "SELECT * FROM tbl_trading_stock WHERE id = '$id_insert'";
    $result = db_qr($sql);
    if(db_nums($result)){
        while($row = db_assoc($result)){
            $result_arr = array(
                'stock_time_open' => $row['stock_stock_time_open'],
                'stock_time_living' => $row['stock_stock_time_living'],
                'stock_quantity' => $row['stock_stock_quantity'],
                'status' => $row['stock_status']
            ); 
        }
        reJson($result);
    }
}