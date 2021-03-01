<?php

$sql = "SELECT * FROM banks";
$result = db_qr($sql);
$nums = db_nums($result);
$result_arr = array();
if($nums > 0){
    while($row = db_assoc($result)){
        $result_item = array(
            'en_name' => $row['en_name'],
            'vn_name' => $row['vn_name'],
            'shortName' => $row['shortName'],
            'bankCode' => $row['bankCode'],
        );
        array_push($result_arr, $result_item);
    }
    reJson($result_arr);
}