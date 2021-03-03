<?php
if (isset($_REQUEST['session_time_open']) && !empty($_REQUEST['session_time_open'])) {
    $session_time_open = $_REQUEST['session_time_open'];
} else {
    returnError("Nhập session_time_open");
}

$sql =  "UPDATE tbl_trading_session SET
            session_status = 'open'
            WHERE session_time_open = '$session_time_open'";
db_qr($sql);
$sql =  "UPDATE tbl_trading_session SET
            session_status = 'close'
            WHERE session_time_close = '$session_time_open'";
db_qr($sql);



$sql = "SELECT * FROM tbl_trading_session 
        WHERE session_time_open <= '$session_time_open' 
        AND session_time_close >= '$session_time_open'";

$result = db_qr($sql);
$nums = db_nums($result);
if ($nums > 0) {
    while ($row = db_assoc($result)) {
        $id_session = $row['id'];
        $id_stock = $row['id_stock'];
        $session_number = $row['session_number'];
        $time_open = $row['session_time_open'];
        $day_session = date('d', $row['session_time_open']);
    }
} else {
    returnError("Chưa có phiên giao dịch này");
}

if (isset($_REQUEST['coordinate_xy']) && !empty($_REQUEST['coordinate_xy'])) {
    $coordinate_xy = $_REQUEST['coordinate_xy'];
} else {
    returnError("Nhập coordinate_xy");
}

if (isset($_REQUEST['time_present']) && !empty($_REQUEST['time_present'])) {
    $time_present = $_REQUEST['time_present'];
} else {
    returnError("Nhập time_present");
}

$sql = "UPDATE tbl_trading_session 
        SET session_time_present = '$time_present' 
        WHERE session_time_open <= '$time_present' 
        AND session_time_close > '$time_present'";


db_qr($sql);


$sql = "SELECT * FROM tbl_trading_coordinate WHERE id_session = '$id_session'";


$result = db_qr($sql);
$nums = db_nums($result);
if ($nums > 0) {
    while ($row = db_assoc($result)) {
        $coordinate_xy_db = $row['coordinate_xy'];
        $coordinate_xy_arr = substr($coordinate_xy_db, 0, -1) . "," . $coordinate_xy . "]";

        $sql = "UPDATE tbl_trading_coordinate SET
                coordinate_xy = '$coordinate_xy_arr'
                WHERE id_session = '$id_session'";
        // echo $sql;
        // exit();
        $result_arr = array();

        if (db_qr($sql)) {
            $sql = "SELECT * FROM tbl_trading_session 
                    WHERE session_time_break <= '$session_time_open' 
                    AND session_time_close >= '$session_time_open'";
            $result = db_qr($sql);
            $nums = db_nums($result);
            if ($nums > 0) {

                $sql = "SELECT * FROM tbl_trading_coordinate 
                        WHERE id_session = '$id_session'";
        
                $result = db_qr($sql);
                $nums = db_nums($result);
                if ($nums > 0) {
                    while ($row = db_assoc($result)) {
                        $result_item = array(
                            'id_session' => $row['id_session'],
                            'status_trade' => 'block',
                            'coordinate_g' => $row['coordinate_g']
                        );
                        array_push($result_arr, $result_item);
                    }
                }
                reJson($result_arr);
            }
            $sql = "SELECT * FROM tbl_trading_coordinate 
                        WHERE id_session = '$id_session'";
        
                $result = db_qr($sql);
                $nums = db_nums($result);
                if ($nums > 0) {
                    while ($row = db_assoc($result)) {
                        $result_item = array(
                            'id_session' => $row['id_session'],
                            'status_trade' => 'trading',
                            'coordinate_g' => $row['coordinate_g']
                        );
                        array_push($result_arr, $result_item);
                    }
                }
                reJson($result_arr);
        };
    }
}

$coordinate_xy_arr = "[" . $coordinate_xy . "]";
$sql = "INSERT INTO tbl_trading_coordinate SET
        id_stock = '$id_stock',
        id_session = '$id_session',
        coordinate_xy = '$coordinate_xy_arr',
        coordinate_g = '$coordinate_xy'";


if (db_qr($sql)) {
    // $id_insert = mysqli_insert_id($conn);
    $result_arr = array();

    $sql = "SELECT * FROM tbl_trading_session WHERE id = '$id_session' AND session_time_open = '$session_time_open'";

    $result = db_qr($sql);
    $nums = db_nums($result);
    if ($nums > 0) {
        $sql = "SELECT * FROM tbl_trading_coordinate 
        WHERE id_session = '$id_session'";

        $result = db_qr($sql);
        $nums = db_nums($result);
        if ($nums > 0) {
            while ($row = db_assoc($result)) {
                $result_item = array(
                    'id_session' => $row['id_session'],
                    'status_trade' => 'trading',
                    'coordinate_g' => $row['coordinate_g']
                );
                array_push($result_arr, $result_item);
            }
        }
        reJson($result_arr);
    }
}
