<?php
if(isset($_REQUEST['id_stock']) && !empty($_REQUEST['id_stock'])){
    $id_stock = $_REQUEST['id_stock'];
}else{
    returnError("Nhập id_stock");
}

if(isset($_REQUEST['open_stock']) && !empty($_REQUEST['open_stock'])){
    if($_REQUEST['open_stock'] == 'open'){
        $open_stock = $_REQUEST['open_stock'];
    }else{
        returnError("Nhập open_stock");
    }
}else{
    returnError("Nhập open_stock");
}

$sql = "UPDATE tbl_trading_stock SET stock_status = '$open_stock' WHERE id = '$id_stock' AND stock_status = 'close'";

if(db_qr($sql)){
    returnSuccess("Mở sàn thành công");
}