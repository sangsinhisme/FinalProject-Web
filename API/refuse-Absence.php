<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports GET')));
    }

    if (!isset($_GET['id'])) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }
      
    $id = $_GET['id'];

    $sql = 'UPDATE requestabsence set status = ? WHERE id = ?';
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array('refused',$id));
        die(json_encode(array('code' => 0, 'message' => 'Refused success')));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

?>