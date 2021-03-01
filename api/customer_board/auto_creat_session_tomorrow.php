
<?php
use Carbon\Carbon;

if(isset($_REQUEST['stock_time_close']) && !empty($_REQUEST['stock_time_close']) ){
    $stock_time_close = $_REQUEST['stock_time_close'];
}else{
    returnError("Giao dịch hôm nay chưa kết thúc, chưa thể tạo sàn cho hôm sau");
}


// $sql = "SELECT * FROM tbl_trading_stock WHERE stock_time_close = '$stock_time_close' DESC";
// $result = db_qr($sql);
// $nums = db_nums($result);
// if($nums > 0){
//     while($row = db_assoc($result)){
//         $
//     }
// }



// $yes = Carbon::now();
// echo "Yesterday: $yes\n";

// $tom = Carbon::tomorrow();
// echo "Tomorrow: $tom\n";

// $date_to_timestamp = strtotime($tom);
// $timestamp_to_date = date("d", $date_to_timestamp);
// echo $date_to_timestamp."  ";
// echo $timestamp_to_date;