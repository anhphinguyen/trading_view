<?php

if (isset($_REQUEST['session_time_break']) && !empty($_REQUEST['session_time_break'])) {
    $session_time_break = $_REQUEST['session_time_break'];
} else {
    $session_time_break = time();
}


$sql = "SELECT * FROM tbl_trading_session 
        WHERE session_time_break <= '$session_time_break'
        AND session_time_close > '$session_time_break'";
        
$result = db_qr($sql);
$nums = db_nums($result);
$result_arr = array();
if ($nums > 0) {
    $result_item = array(
        'status_trade' => "block"
    );
    array_push($result_arr, $result_item);
    reJson($result_arr);
}

$sql = "SELECT * FROM tbl_trading_session 
        WHERE session_time_open <= '$session_time_break'
        AND session_time_break > '$session_time_break'";
$result = db_qr($sql);
$nums = db_nums($result);
$result_arr = array();
if ($nums > 0) {
    $result_item = array(
        'status_trade' => "trading"
    );
    array_push($result_arr, $result_item);
    reJson($result_arr);
}
