<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports POST')));
    }

    if (!isset($_POST['id-task']) ) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }

    $id = $_POST['id-task'];
    $rating = $_POST['rating-task'];

    $sql = 'UPDATE `task` SET `rating`=?, `process`=? WHERE `id` = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($rating, "task-complete" ,$id));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    die(json_encode(array('code' => 0, 'data' => $data)));


?>