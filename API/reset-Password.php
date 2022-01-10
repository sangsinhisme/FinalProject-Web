<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports GET')));
    }

    if (!isset($_GET['id']) ) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }
      
    $id = $_GET['id'];
    $pass = password_hash($id,PASSWORD_DEFAULT);

    $sql = 'UPDATE account set password = ?,activated = ? where username = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($pass,'',$id));

        $count = $stmt->rowCount();

        if ($count == 1) {
            die(json_encode(array('code' => 0, 'message' => 'Reset success')));
        }else {
            die(json_encode(array('code' => 1, 'message' => 'Reset failed')));
        }


    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }
?>