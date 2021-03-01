<?php
$sql = "SELECT * FROM tbl_trading_coordinate WHERE id = 27";
$result = db_qr($sql);
$nums = db_nums($result);
if($nums > 0){
    while($row = db_assoc($result)){
        $coodinate_xy = $row['coordinate_xy'];
        $coodinate_xy_arr = explode('},', $coodinate_xy);
            echo count($coodinate_xy_arr);
            exit();
        // foreach($coodinate_xy as $xy){
        //     echo $xy;
        //     exit();
        // }
    }
}