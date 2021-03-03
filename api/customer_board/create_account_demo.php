<?php
$string = "ABCDEFGHIJKMNOPQTUVXYZWRabcdefghijklmnopqtuvxyzwr1234567890";

$random_username = strval(substr(str_shuffle($string), -8).substr(time(),3, -3));
$random_password = strval(substr(str_shuffle($string), -8).substr(time(),-8));

$sql = "INSERT INTO tbl_user_demo SET
        username = '$random_username',
        password = '$random_password'";
        
if(db_qr($sql)){
    $id = mysqli_insert_id($conn);
    $result_arr = array();
    $sql = "SELECT * FROM tbl_user_demo WHERE id = '$id'";
    $result = db_qr($sql);
    $nums = db_nums($result);
    if($nums > 0){
        while($row = db_assoc($result)){
            $result_item = array(
                'username' => $row['username'],
                'password' => $row['password'],
            );
            array_push($result_arr, $result_item);
        }
    }
    // echo $random_password." ".$random_username;
    reJson($result_arr);
}
