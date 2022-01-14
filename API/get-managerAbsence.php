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
    $data1 = array();
    $data2 = array();
    $data = array();

    $sql = 'SELECT dayAbsence,reason,file,status,date FROM requestabsence WHERE id = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $data1 = $stmt->fetch(PDO::FETCH_ASSOC);
            $sql = 'SELECT name,department FROM account where username = ?';
            try{
                $stmt = $dbCon->prepare($sql);
                $stmt->execute(array($username));
                if ($stmt->rowCount() > 0) {
                    $data2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    $data = array_merge($data2, $data1);
                    die(json_encode(array('code' => 0, 'data' => $data)));
                }
                else {
                    die(json_encode(array('code' => 2, 'data' => $data1)));
                }
                
            }
            catch(PDOException $ex){
                die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
            }
        }
        else {
            die(json_encode(array('code' => 1, 'message' => 'Error')));
        }
    }
    catch(PDOException $ex){
        die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
    }

?>