<?php

if(isset($_REQUEST['id_user']) && !empty($_REQUEST['id_user'])){
    $id_user = $_REQUEST['id_user'];
}else{
    returnError("Nhập id_user");
}

if(isset($_REQUEST['money_amount']) && !empty($_REQUEST['money_amount'])){
    $money_amount = $_REQUEST['money_amount'];
}else{
    returnError("Nhập money_amount");
}


$sql = "SELECT * FROM tbl_user_infomation WHERE id = '$id_user'";
$result = db_qr($sql);
$nums = db_nums($result);
if($nums > 0){
    while($row = db_assoc($result)){
        if($row['user_money_status'] == "DEMO"){
            $sql = "UPDATE tbl_user_infomation SET
                    user_money = '$money_amount',
                    user_money_status = 'REAL'
                    WHERE id = '$id_user'";
            if(db_qr($sql)){
                returnSuccess("Xin chúc mừng! Bạn đã trở thành trader chính hiệu");
            }
        }else{
            $add_money = $row['user_money'] + $money_amount;

            $sql = "UPDATE tbl_user_infomation SET
                    user_money = '$add_money'
                    WHERE id = '$id_user'";
            if(db_qr($sql)){
                returnSuccess("Nạp tiền vào tài khoản thành công");
            }
        }
    }
}