<?php

if(isset($_REQUEST['id_user']) && !empty($_REQUEST['id_user'])){
    $id_user = $_REQUEST['id_user'];
}else{
    returnError("Nhập id_user");
}

if(isset($_REQUEST['id_stock']) && !empty($_REQUEST['id_stock'])){
    $id_stock = $_REQUEST['id_stock'];
}else{
    returnError("Nhập id_stock");
}

if(isset($_REQUEST['bet_money']) && !empty($_REQUEST['bet_money'])){
    $bet_money = $_REQUEST['bet_money'];
}else{
    returnError("Nhập bet_money");
}

if(isset($_REQUEST['play_status_trading']) && !empty($_REQUEST['play_status_trading'])){
    $play_status_trading = $_REQUEST['play_status_trading'];
}else{
    returnError("Nhập play_status_trading");
}


$sql = "INSERT INTO tbl_trading_playing SET
        id_user = '$id_user',
        id_stock = '$id_stock',
        play_bet_money = '$bet_money',
        play_status_trading = '$play_status_trading'";
if(db_qr($sql)){
    $id_insert = mysqli_insert_id($conn);

    $sql = "SELECT * FROM tbl_trading_playing WHERE id = '$id_insert'";
    $result = db_qr($sql);
    if(db_nums($result)){
        while($row = db_assoc($result)){
            $result_arr = array(
                'id_playing' => $row['id'],
                'id_user' => $row['id_user'],
                'id_stock' => $row['id_stock'],
                'bet_money' => $row['play_bet_money'],
                'play_status_trading' => $row['play_status_trading'],
                'play_result' => (!empty($row['play_status_bet']))?$row['play_status_bet']:"",
            );
        }

        reJson($result);
    }
}