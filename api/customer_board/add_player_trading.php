<?php

if(isset($_REQUEST['id_user']) && !empty($_REQUEST['id_user'])){
    $id_user = $_REQUEST['id_user'];
}else{
    returnError("Nhập id_user");
}

if(isset($_REQUEST['id_session']) && !empty($_REQUEST['id_session'])){
    $id_session = $_REQUEST['id_session'];
}else{
    returnError("Nhập id_session");
}

if(isset($_REQUEST['play_time']) && !empty($_REQUEST['play_time'])){
    $play_time = $_REQUEST['play_time'];
}else{
    returnError("Nhập play_time");
}

if(isset($_REQUEST['bet_money']) && !empty($_REQUEST['bet_money'])){
    $bet_money = $_REQUEST['bet_money'];
}else{
    returnError("Nhập bet_money");
}

if(isset($_REQUEST['play_status_trade']) && !empty($_REQUEST['play_status_trade'])){
    $play_status_trade = $_REQUEST['play_status_trade'];
}else{
    returnError("Nhập play_status_trade");
}

$sql = "SELECT * FROM tbl_user_infomation WHERE id = '$id_user'";
$result = db_qr($sql);
$nums = db_nums($result);
if($nums > 0){
    while($row = db_assoc($result)){
        $sub_money = $row['user_money'] - $bet_money;
        $sql = "UPDATE tbl_user_infomation SET user_money = '$sub_money' WHERE id = '$id_user'";
        db_qr($sql);
    }
}


$sql = "SELECT * FROM tbl_trading_playing 
        WHERE id_session = '$id_session' 
        AND id_user = '$id_user' 
        AND play_status_trade = '$play_status_trade'";

        
$result = db_qr($sql);
$nums = db_nums($result);
if($nums > 0){
    while($row = db_assoc($result)){
        if($row['play_bet_money'] > 0){
            $bet_money_update = $row['play_bet_money'] + $bet_money;
            $sql = "UPDATE tbl_trading_playing SET
                    play_bet_money = '$bet_money_update'
                    WHERE id_user = '$id_user' 
                    AND id_session = '$id_session'
                    AND play_status_trade = '$play_status_trade'";

            if(db_qr($sql)){
                $sql = "SELECT * FROM tbl_trading_playing
                        WHERE id_user = '$id_user' 
                        AND id_session = '$id_session'
                        AND play_status_trade = '$play_status_trade'";
                $result = db_qr($sql);
                if(db_nums($result)){
                    while($row = db_assoc($result)){
                        $result_arr = array(
                            'id_playing' => $row['id'],
                            'id_user' => $row['id_user'],
                            'id_session' => $row['id_session'],
                            'bet_money' => $row['play_bet_money'],
                            'play_status_trade' => $row['play_status_trade'],
                            'play_result' => $row['play_status_bet'],
                        );
                    }
                    reJson($result_arr);
                }
            }
        }
    }
}else{
    $sql = "INSERT INTO tbl_trading_playing SET
            id_user = '$id_user',
            id_session = '$id_session',
            play_bet_money = '$bet_money',
            play_time = '$play_time',
            play_status_trade = '$play_status_trade'";
    if(db_qr($sql)){
        $id_insert = mysqli_insert_id($conn);
    
        $sql = "SELECT * FROM tbl_trading_playing WHERE id = '$id_insert'";
        $result = db_qr($sql);
        if(db_nums($result)){
            while($row = db_assoc($result)){
                $result_arr = array(
                    'id_playing' => $row['id'],
                    'id_user' => $row['id_user'],
                    'id_session' => $row['id_session'],
                    'bet_money' => $row['play_bet_money'],
                    'play_status_trade' => $row['play_status_trade'],
                    'play_result' => (!empty($row['play_status_bet']))?$row['play_status_bet']:"",
                );
            }
            reJson($result_arr);
        }
    }
}
