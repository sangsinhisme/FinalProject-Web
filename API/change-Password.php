<?php
    session_start();
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(response_code:405);
        die(json_encode(array('code' => 4, 'message' => 'This API only supports POST')));
    }
  
    $input = json_decode(file_get_contents('php://input'));
    if (is_null($input)) {
        die(json_encode(array('code' => 2, 'message' => 'This API only supports JSON')));
    }

    if (!property_exists($input,property:'oldpass') ||
    !property_exists($input,property:'newpass')) 
    {
        http_response_code(response_code:400);
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    if (empty($input->oldpass) || empty($input->newpass)) {
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    $oldpass = $input->oldpass;
    $newpass = $input->newpass;

    $sql = 'SELECT password FROM account WHERE username = ?';
    $stmt = $dbCon->prepare($sql);
    $stmt->execute(array($_SESSION['user']));
    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        if (password_verify($oldpass,$row['password'])) {
            $sql = 'UPDATE account set password = ? where username = ?';
            try{
                $stmt = $dbCon->prepare($sql);
                $stmt->execute(array(password_hash($newpass,PASSWORD_DEFAULT),$_SESSION['user']));

                $count = $stmt->rowCount();

                if ($count == 1) {
                    die(json_encode(array('code' => 0, 'message' => 'Repassword success')));
                }else {
                    die(json_encode(array('code' => 1, 'message' => 'Repassword failed')));
                }
            }
            catch(PDOException $ex){
                die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
            }
        }
        else {
            die(json_encode(array('code' => 1, 'message' => 'Mật khẩu cũ không hợp lệ')));
        }
    }
    else {
        die(json_encode(array('code' => 1, 'message' => 'Error')));
    }
?>