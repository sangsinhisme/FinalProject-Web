<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports GET')));
    }

    if (!isset($_GET['id']) || !isset($_GET['user'])) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }
    
    $id = $_GET['id'];
    $user = $_GET['user'];
    

    // Update for department table
    $sql = 'UPDATE department set manager = ? where id = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array('',$id));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    //Update for account table
    $sql = 'UPDATE account set role = ?, position = ? where username = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array(1,'Nhân viên',$user));
        die(json_encode(array('code' => 0, 'message' => 'Dismiss success')));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

?>