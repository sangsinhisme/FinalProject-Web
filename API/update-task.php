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

    $name = $_POST['name-task'];
    $id = $_POST['id-task'];
    $deadline = $_POST['deadline-task'];
    $deadtime = $_POST['deadtime-task'];
    $describ= $_POST['describ-task'];

    if(!isset($name) || !isset($deadline) || !isset($deadtime) ){
        error_response(1, 'Dữ liệu không hợp lệ.');
    }

    if($name === "" || $deadline === "" || $deadtime === ""){
        error_response(4, 'Vui lòng nhập đủ thông tin.');
    }

    $sql = 'UPDATE `task` SET `name`=?,`deadline`=?,`deadtime`=?,`describ`=? WHERE `id` = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($name, $deadline, $deadtime, $describ, $id));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    die(json_encode(array('code' => 0, 'data' => $data)));


?>