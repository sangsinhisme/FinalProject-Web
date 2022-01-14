<?php
header('Access-Control-Allow-Origin: *');

$host = 'mysql-server';
$dbName = 'project';
$username = 'root';
$password = 'root';

    try{
        $dbCon = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $ex){
        die(json_encode(array('status' => false, 'data' => 'Unable to connect: ' . $ex->getMessage())));
    }

    function error_response($code, $message){
        $res = array();
        $res['code'] = $code;
        $res['message'] = $message;

        die(json_encode($res));
    }

?>