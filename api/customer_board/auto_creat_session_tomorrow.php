
<?php
use Carbon\Carbon;

if(isset($_REQUEST['stock_time_close']) && !empty($_REQUEST['stock_time_close']) ){
    $stock_time_close = $_REQUEST['stock_time_close'];
}else{
    returnError("Giao dịch hôm nay chưa kết thúc, chưa thể tạo sàn cho hôm sau");
}

$stock_time_close_tomorrow = $stock_time_close + 86400;
$date_tomorrow = date("d", $stock_time_close_tomorrow);
$sql = "SELECT * FROM tbl_trading_stock";
$result = db_qr($sql);
$nums = db_nums($result);
if($nums > 0){
    while($row = db_assoc($result)){
        if(date("d", $row['stock_time_open']) == $date_tomorrow){
            returnError("Đã tạo sàn cho ngày hôm sau");
        }
    }

}

$sql = "SELECT * FROM tbl_trading_stock WHERE stock_time_close = '$stock_time_close'";
$result = db_qr($sql);
$nums = db_nums($result);
if($nums > 0){
    while($row = db_assoc($result)){
        $time_open = $row['stock_time_open'];
        $time_close = $row['stock_time_close'];
        $time_living = $row['stock_time_living'];
        // $quantity = ($time_close - $time_open)/$time_living;
    }

    $time_open_tomorrow = $time_open + 86400;
    $time_close_tomorrow = $time_close + 86400;
    $quantity = ($time_close_tomorrow - $time_open_tomorrow)/$time_living;

    echo $time_open_tomorrow." Tạo sàn cho ngày hôm sau thành công";
    exit();
}



// $yes = Carbon::now();
// echo "Yesterday: $yes\n";

// $tom = Carbon::tomorrow();
// echo "Tomorrow: $tom\n";

// $date_to_timestamp = strtotime($tom);
// $timestamp_to_date = date("d", $date_to_timestamp);
// echo $date_to_timestamp."  ";
// echo $timestamp_to_date;