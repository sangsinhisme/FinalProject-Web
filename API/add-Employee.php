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

    if (!property_exists($input,property:'username') ||
    !property_exists($input,property:'name') ||
    !property_exists($input,property:'gender') ||
    !property_exists($input,property:'phone') ||
    !property_exists($input,property:'mail') ||
    !property_exists($input,property:'position') ||
    !property_exists($input,property:'department')) 
    {
        http_response_code(response_code:400);
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    if (empty($input->username) || empty($input->name) || empty($input->gender) || empty($input->phone) || empty($input->mail) || empty($input->position) || empty($input->department)) {
        die(json_encode(array('code' => 1, 'message' => 'Invalid Input')));
    }

    $username = $input->username;
    $name = $input->name;
    $gender = $input->gender;
    $phone = $input->phone;
    $mail = $input->mail;
    $position = $input->position;
    $department = $input->department;
    $pass = password_hash($username,PASSWORD_DEFAULT);
    $data = array();

    $sql = 'SELECT * FROM account WHERE username = ?';
    $stmt = $dbCon->prepare($sql);
    $stmt->execute(array($username));
    if($stmt->rowCount() == 0) {
        if ($position == "2") {
            $sql = 'SELECT manager FROM department WHERE departmentName = ?';
            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array($department));
            $data = $stmt->fetch();  
            if (strlen($data['manager']) == 0) {
                // Update for department table
                $sql = 'UPDATE department set manager = ? where departmentName = ?';
                try{
                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute(array($username,$department));
                }
                catch(PDOException $ex){
                    die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
                }
                // Insert to account table
                $sql = 'INSERT INTO account(username,password,activated,role,name,gender,phone,mail,position,department,avatar) VALUES(?,?,?,?,?,?,?,?,?,?,?)';
                try{
                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute(array($username,$pass,'',$position,$name,convertGender($gender),$phone,$mail,convert($position),$department,'avatar.jpg'));
                    die(json_encode(array('code' => 0, 'message' => 'Add success')));
                }
                catch(PDOException $ex){
                    die(json_encode(array('code' => 1, 'message' => 'Error')));
                }
            }
            else {
                die(json_encode(array('code' => 1, 'message' => 'Phòng này đã có trưởng phòng')));
            }
        }
        else {
            $sql = 'INSERT INTO account(username,password,activated,role,name,gender,phone,mail,position,department,avatar) VALUES(?,?,?,?,?,?,?,?,?,?,?)';
            try{
                $stmt = $dbCon->prepare($sql);
                $stmt->execute(array($username,$pass,'',$position,$name,convertGender($gender),$phone,$mail,convert($position),$department,'avatar.jpg'));
                die(json_encode(array('code' => 0, 'message' => 'Add success')));
            }
            catch(PDOException $ex){
                die(json_encode(array('code' => 1, 'message' => 'Error')));
            }
        }
    }
    else {
        die(json_encode(array('code' => 1, 'message' => 'Tài khoản đã được tạo')));
    } 

    function convert($position) {
        $res = "Nhân viên";
        if ($position == "2") {
            $res = "Trưởng phòng";
        }
        return $res;
    }

    function convertGender($gender) {
        $res = "Nam";
        if ($gender == "2") {
            $res = "Nữ";
        }
        return $res;
    }
    // function convertDepartment($department) {
    //     $res = "Triển khai phần mềm";
    //     if ($department == "1") {
    //         $res = "Phát triển phần mềm";
    //     }
    //     else if ($department == "2") {
    //         $res = "Kiểm thử phần mềm";
    //     }
    //     return $res;
    // }
?>