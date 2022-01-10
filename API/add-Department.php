<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports POST')));
    }

    $input = json_decode(file_get_contents('php://input'));
    // echo json_encode(array('status' => true, 'data' => $input));
    if (is_null($input)) {
        die(json_encode(array('code' => 2, 'message' => 'This API only supports JSON')));
    }

    if (!property_exists($input,property:'name') ||
    !property_exists($input,property:'description') ||
    !property_exists($input,property:'room')) 
    {
        http_response_code(response_code:400);
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    if (empty($input->name) || empty($input->description) || empty($input->room)) {
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    $name = $input->name;
    $description = $input->description;
    $room = $input->room;

    $sql = 'SELECT * FROM department WHERE departmentName = ?';
    $stmt = $dbCon->prepare($sql);
    $stmt->execute(array($name));
    if($stmt->rowCount() == 0) {
        $sql = 'INSERT INTO department(departmentName,description,room,manager) VALUES(?,?,?,?)';
        try{
            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array($name,$description,$room,''));
            die(json_encode(array('code' => 0, 'message' => 'Add success')));
        }
        catch(PDOException $ex){
            die(json_encode(array('code' => 1, 'message' => 'Error')));
        }
    }
    else {
        die(json_encode(array('code' => 1, 'message' => 'Phòng ban đã tồn tại')));
    } 
?>