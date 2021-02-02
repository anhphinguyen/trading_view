<?php
include_once 'basic_auth.php';
include_once "../lib/database.php";
include_once "../lib/connect.php";
include_once "../lib/reuse_function.php";
include_once "../lib/validation.php";

include_once "../lib/jwt/php-jwt-master/src/JWT.php";

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Methods: GET");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// check if data recived is from raw - if so, assign it to $_REQUEST
if (!isset($_REQUEST['detect'])) {
    // get raw json data
    $_REQUEST = json_decode(file_get_contents('php://input'), true);
    if (!isset($_REQUEST['detect'])) {
        echo json_encode(array(
            'message' => 'detect parameter not found !'
        ));
        exit();
    }
}
// handle detect value
$detect = $_REQUEST['detect'];

switch ($detect) {

    /*admin board*/
    case 'open_stock':{
        include_once 'admin_board/open_stock.php';
        break;
    }
    case 'set_open_stock':{
        include_once 'admin_board/set_open_stock.php';
        break;
    }
    /*customer board*/
    case 'login':{
        include_once 'customer_board/login.php';
        break;
    }
    case 'register':{
        include_once 'customer_board/register.php';
        break;
    }
    /*viewlist board*/
    case 'get_coordinate':{
        include_once 'viewlist_board/get_coordinate.php';
        break;
    }

    default: {
            echo json_encode(array(
                'success' => 'false',
                'massage' => 'detect has been failed'
            ));
        }
}
