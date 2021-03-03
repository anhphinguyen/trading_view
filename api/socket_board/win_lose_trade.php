<?php

if (isset($_REQUEST['time_break']) && !empty($_REQUEST['time_break'])) {
    $time_break = $_REQUEST['time_break'];
} else {
    $time_break = time();
}

$sql = "SELECT * FROM tbl_trading_session 
        WHERE session_time_open <= '$time_break'
        AND session_time_close > '$time_break'
        AND session_time_break <= '$time_break'";

$result = db_qr($sql);
$nums = db_nums($result);
if ($nums == 0) {
    returnError("Chưa đến thời gian dừng đặt cược");
}


$sql = "SELECT * FROM tbl_trading_session 
        WHERE session_time_open <= '$time_break'
        AND session_time_close > '$time_break'";
$result = db_qr($sql);
$num = db_nums($result);
if ($num > 0) {
    while ($row = db_assoc($result)) {
        $id_session = $row['id'];
        $session_time_close = $row['session_time_close'];
    }
} else {
    returnError('Chưa có phiên được tạo');
}

$sql_trade_up = "SELECT SUM(play_bet_money) as total_money_up FROM tbl_trading_playing 
                 WHERE id_session = '$id_session' 
                 AND play_status_trade = 'up'";
$result_trade_up = db_qr($sql_trade_up);
$nums_trade_up = db_nums($result_trade_up);
if ($nums_trade_up > 0) {
    while ($row_up = db_assoc($result_trade_up)) {
        $total_trade_up = $row_up['total_money_up'];
    }
}

$sql_trade_down = "SELECT SUM(play_bet_money) as total_money_down FROM tbl_trading_playing 
                 WHERE id_session = '$id_session' 
                 AND play_status_trade = 'down'";

$result_trade_down = db_qr($sql_trade_down);
$nums_trade_down = db_nums($result_trade_down);
if ($nums_trade_down > 0) {
    while ($row_down = db_assoc($result_trade_down)) {
        $total_trade_down = $row_down['total_money_down'];
    }
}

if ($total_trade_up >= $total_trade_down) {
    $result_trade = "up";
    $sql = "UPDATE tbl_trading_playing SET 
            play_status_bet = 'win'
            WHERE id_session = '$id_session' 
            AND play_status_trade = 'up'";
    db_qr($sql);
    $sql = "UPDATE tbl_trading_playing SET 
            play_status_bet = 'lose'
            WHERE id_session = '$id_session' 
            AND play_status_trade = 'down'";
    db_qr($sql);
} else {
    $result_trade = "down";
    $sql = "UPDATE tbl_trading_playing SET 
            play_status_bet = 'win'
            WHERE id_session = '$id_session' 
            AND play_status_trade = 'down'";
    db_qr($sql);
    $sql = "UPDATE tbl_trading_playing SET 
            play_status_bet = 'lose'
            WHERE id_session = '$id_session' 
            AND play_status_trade = 'up'";
    db_qr($sql);
}

$sql_session = "SELECT id FROM tbl_trading_session 
                WHERE session_time_open <= '$time_break'
                AND session_time_close >= '$time_break'";
$result_session = db_qr($sql_session);
$nums_session = db_nums($result_session);
if ($nums_session > 0) {
    while ($row_session = db_assoc($result_session)) {
        $id_session = $row_session['id'];
    }
}

$sql_get_coordinate_g = "SELECT coordinate_g FROM tbl_trading_coordinate
                            WHERE id_session = '$id_session'";
// echo $sql_get_coordinate_g;
// exit();
$result_get_coordinate_g = db_qr($sql_get_coordinate_g);
$nums_get_coordinate_g = db_nums($result_get_coordinate_g);

if ($nums_get_coordinate_g > 0) {
    while ($row_get_coordinate_g = db_assoc($result_get_coordinate_g)) {
        $coordinate_g = $row_get_coordinate_g['coordinate_g'];
    }
}
$result_arr = array();
$result_item = array(
    'result_trade' => $result_trade,
    'coordinate_g' => isset($coordinate_g)?$coordinate_g:"null",
    'time_close' => $session_time_close
);
array_push($result_arr, $result_item);


reJson($result_arr);
