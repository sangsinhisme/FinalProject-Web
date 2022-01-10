<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports PUT')));
    }

    if (!isset($_GET['id']) ) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }
      
    $input = json_decode(file_get_contents('php://input'));
    // echo json_encode(array('status' => true, 'data' => $input));
    if (is_null($input)) {
        die(json_encode(array('code' => 2, 'message' => 'This API only supports JSON')));
    }

    if (!property_exists($input,property:'name') ||
    !property_exists($input,property:'description') ||
    !property_exists($input,property:'room')
    ) {
        http_response_code(response_code:400);
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    if (empty($input->name) || empty($input->room) || empty($input->description)) {
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    $id = $_GET['id'];
    $name = $input->name;
    $description = $input->description;
    $room = $input->room;

    $sql = 'UPDATE department set departmentName = ?, description = ?, room = ? where id = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($name,$description,$room,$id));
        die(json_encode(array('code' => 0, 'message' => 'Update success')));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }


?>