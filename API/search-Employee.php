<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports GET')));
    }

    if (!isset($_GET['name'])) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }
    
    $name = '%'.$_GET['name'].'%';
    $sql = 'SELECT * FROM account WHERE role != 3 and name like ?';
    //print_r($name);
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($name));
    }
    catch(PDOException $ex){
        die(json_encode(array('status' => false, 'data' => $ex->getMessage())));
    }

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))

    {
        $data[] = $row;
    }

    echo json_encode(array('status' => true, 'data' => $data));

?>