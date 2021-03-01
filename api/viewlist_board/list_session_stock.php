<?php
if (isset($_REQUEST['time_open']) && !empty($_REQUEST['time_open'])) {
    $time_open = $_REQUEST['time_open'];
}

if (isset($_REQUEST['time_break']) && !empty($_REQUEST['time_break'])) {
    $time_break = $_REQUEST['time_break'];
}
$day_today = date('d', time());


$sql = "SELECT * FROM tbl_trading_session";
$result = db_qr($sql);
$nums = db_nums($result);
$session_arr = array();
if ($nums > 0) {
    $session_arr['success'] = "true";
    $session_arr['total'] = "";
    $session_arr['data'] = array();
    while ($row = db_assoc($result)) {
        if (isset($time_open) && !empty($time_open)) {
            if ($row['session_time_open'] == $time_open) {
                $session_item = array(
                    'time_open' => $row['session_time_open'],
                    'time_living' => $row['session_time_living'],
                    'time_break' => $row['session_time_break'],
                    'time_close' => $row['session_time_close'],
                );
                array_push($session_arr['data'], $session_item);
            }
        }else if (isset($time_break) && !empty($time_break)) {
            if ($row['session_time_break'] == $time_break) {
                $session_item = array(
                    'time_open' => $row['session_time_open'],
                    'time_living' => $row['session_time_living'],
                    'time_break' => $row['session_time_break'],
                    'time_close' => $row['session_time_close'],
                );
                array_push($session_arr['data'], $session_item);
            }
        } else {
            if (date('d', $row['session_time_open']) == $day_today) {
                $session_item = array(
                    'time_open' => $row['session_time_open'],
                    'time_living' => $row['session_time_living'],
                    'time_break' => $row['session_time_break'],
                    'time_close' => $row['session_time_close'],
                );
                array_push($session_arr['data'], $session_item);
            }
        }
    }
    $session_arr['total'] = count($session_arr['data']);
    echo json_encode($session_arr);
    exit();
}
returnError("Không tồn tại phiên");
