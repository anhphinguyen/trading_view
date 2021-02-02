<?php

if(isset($_REQUEST['username']) && !(empty($_REQUEST['username']))){
    if(is_username($_REQUEST['username'])){
        $username = $_REQUEST['username'];
    }else{
        returnError("username không đúng định dạng");
    }
}else{
    returnError("Nhập username");
}

if(isset($_REQUEST['password']) && !(empty($_REQUEST['password']))){
    if(is_password($_REQUEST['password'])){
        $password = md5($_REQUEST['password']);
    }else{
        returnError("password không đúng định dạng");
    }
}else{
    returnError("Nhập password");
}

if(isset($_REQUEST['money_unit']) && !(empty($_REQUEST['money_unit']))){
    $money_unit = $_REQUEST['money_unit'];
}else{
    returnError("Nhập money_unit");
}

$sql = "SELECT * FROM tbl_user_infomation WHERE user_name = '$username'";
$result = db_qr($sql);
if((db_nums($result)) > 0){
    returnError("Đã tồn tại user");
}

$sql = "INSERT INTO tbl_user_infomation SET user_name = '$username', user_password = '$password', user_money_unit = '$money_unit'";
if(db_qr($sql)){
    $id_user = mysqli_insert_id($conn);

    $sql = "SELECT * FROM tbl_user_infomation WHERE id = '$id_user'";
    $result = db_qr($sql);
    if(db_nums($result) > 0){
        while($row = db_assoc($result)){
            $result_arr = array(
                'id_user' => $row['id'],
                'username' => $row['user_name'],
                'money' => $row['user_money'],
                'money_unit' => $row['user_money_unit']
            );
        }
        reJson($result_arr);
    }
}