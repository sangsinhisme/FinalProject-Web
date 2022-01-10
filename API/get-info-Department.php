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

    $sql = 'SELECT departmentName,description,room FROM department where id = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            die(json_encode(array('code' => 0, 'data' => $data)));
        }
        else {
            die(json_encode(array('code' => 1, 'message' => 'Error')));
        }
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }


?>