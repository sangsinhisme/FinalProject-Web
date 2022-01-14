<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(response_code:405);
        error_response(4, 'This API only supports POST');
    }

    if (!isset($_POST['id']) ) {
        error_response(1, 'Parameters not valid');
    }

    $id = $_POST['id'];
    $process = $_POST['process'];

    $sql = 'UPDATE `task` SET `process`=? WHERE id = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($process, $id));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    die(json_encode(array('code' => 0, 'data' => $data)));


?>