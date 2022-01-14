<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports GET')));
    }

    if (!isset($_GET['id']) || !isset($_GET['username']) ) {
        die(json_encode(array('code' => 1, 'message' => 'Parameters not valid')));
    }
      
    $id = $_GET['id'];
    $username = $_GET['username'];
    $dayoff = 0;
    $row = array();

    $sql = 'SELECT dayoff FROM account WHERE username = ?';
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($username));
        if ($stmt->rowCount() > 0) { 
            $row = $stmt->fetch();
            $dayoff = $row['dayoff'];
        }
        else {
            die(json_encode(array('code' => 1, 'message' => 'Không tìm thấy tài khoản')));
        }
        
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    $sql = 'SELECT dayAbsence FROM requestabsence where id = ?';
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $dayoff = $dayoff + $row['dayAbsence'];  
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    $sql = 'UPDATE account set dayoff = ? WHERE username = ?';
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($dayoff,$username));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

    $sql = 'UPDATE requestabsence set status = ? WHERE id = ?';
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array('approved',$id));
        die(json_encode(array('code' => 0, 'message' => 'Approved succes')));
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

?>