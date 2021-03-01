<?php
// $day_today = time();
$day_today = 1614589801;

// $sql = "SELECT * FROM tbl_trading_stock WHERE stock_time_open <= '$day_today' AND stock_time_close >= '$day_today'";

// $result = db_qr($sql);
// $nums = db_nums($result);
// if ($nums > 0) {
//     while ($row = db_assoc($result)) {
//         $id_stock = $row['id'];
//         $stock_quantity = $row['stock_quantity'];
//     }
// } else {
//     returnError("Hôm nay không có sàn giao dịch");
// }

// for ($i = 0; $i < $stock_quantity; $i++) {

$sql = "SELECT 
                    tbl_trading_session.id as id_session,
                    tbl_trading_session.id_stock as id_stock,
                    tbl_trading_session.session_time_open as session_time_open,
                    tbl_trading_session.session_time_present as session_time_present,
                    tbl_trading_session.session_number as session_number,

                    tbl_trading_coordinate.id as id_coordinate,
                    tbl_trading_coordinate.coordinate_xy as coordinate_xy,
                    tbl_trading_coordinate.coordinate_g as coordinate_g
                    FROM tbl_trading_session 
                    LEFT JOIN tbl_trading_coordinate ON tbl_trading_coordinate.id_session = tbl_trading_session.id
                    WHERE tbl_trading_session.session_time_open <= '$day_today' 
                    AND tbl_trading_session.session_time_close >= '$day_today'";
// echo $sql;
// exit();

$result = db_qr($sql);
$nums = db_nums($result);
$result_arr = array();

if ($nums > 0) {
        while ($row = db_assoc($result)) {
            $result_item = array(
                'id_coordinate' => $row['id_coordinate'],
                'id_stock' => $row['id_stock'],
                'id_session' => $row['id_session'],
                'time_open' => $row['session_time_open'],
                'time_present' => $row['session_time_present'],
                'time_duration' => $row['session_time_present'] - $row['session_time_open'],
                'sesion_number' => $row['session_number'],
                'coordinate_xy' => $row['coordinate_xy'],
                'coordinate_g' => $row['coordinate_g'],
            );
            array_push($result_arr, $result_item);
        }
        reJson($result_arr);
        // $id_session = $row['id'];
        // $id_stock = $row['id_stock'];
        // $session_number = $row['session_number'];

        // $sql_time_open = "SELECT * FROM tbl_trading_session WHERE id = '$id_session'";
        // // echo $sql_time_open;
        // // exit();
        // $result_time_open = db_qr($sql_time_open);
        // $nums_time_open = db_nums($result_time_open);
        // if ($nums_time_open > 0) {
        //     while ($row_time_open = db_assoc($result_time_open)){
        //         $time_open = $row_time_open['session_time_open'];
        //     }
        // }
        // $day_session = date('d', $row['session_time_open']);

        // // echo $time_open;
        // // exit();
} else {
    returnError("Chưa có phiên giao dịch này");
}


//     $sql = "SELECT * FROM tbl_trading_coordinate WHERE id_stock = '$id_stock'";
//     $result = db_qr($sql);
//     $nums = db_nums($result);
//     $result_arr = array();
//     if ($nums > 0) {
//         while ($row = db_assoc($result)) {
//             $result_item = array(
//                 'id_coordinate' => $row['id'],
//                 'id_stock' => $row['id_stock'],
//                 'id_session' => $row['id_session'],
//                 'time_open' => $time_open,
//                 'time_present' => $row['time_present'],
//                 'time_duration' => $row['time_present'] - $time_open,
//                 'sesion_number' => $session_number,
//                 'coordinate_xy' => $row['coordinate_xy'],
//                 'coordinate_g' => $row['coordinate_g'],
//             );
//             array_push($result_arr, $result_item);
//         }
//         reJson($result_arr);
//     }
// // }
