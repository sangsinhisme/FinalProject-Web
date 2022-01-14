<?php
    session_start();
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    $name = $_SESSION['user'];
    $role = $_SESSION['role'];
    $department = $_SESSION['department'];
    $dayoff= $_POST['dayoff'];
    $reason = $_POST['reason'];
    $file_output = "";

    // if(!isset($name) || !isset($employee) || !isset($deadline) || !isset($deadtime) ){
    //     error_response(1, 'Dữ liệu không hợp lệ.');
    // }

    // if($name === "" || $employee === "" || $deadline === "" || $deadtime === ""){
    //     error_response(4, 'Vui lòng nhập đủ thông tin.');
    // }

    // Check
    $sql = 'SELECT status ,expire_on
            FROM requestabsence
            WHERE username = ?
            ORDER BY date DESC
            LIMIT 1';

    $stm = $dbCon->prepare($sql);
    $stm->execute(array($_SESSION['user']));
    if ($stm->rowCount() > 0) {
        $row = $stm->fetch();
    
        if ($row['status'] == 'waiting') {
            die(json_encode(array('code' => 1, 'message' => 'Không thể tạo yêu cầu khi có đơn đang chờ duyệt')));
        }
        else if (time() < $row['expire_on']) {
            die(json_encode(array('code' => 1, 'message' => 'Phải sau 7 ngày khi được duyệt mới được tạo đơn mới')));
        }
    }


    if(isset($_FILES['file-task'])){
        $countFiles = count($_FILES['file-task']['name']);
        for ($i = 0; $i < $countFiles; $i++){
            $file_name = $_FILES['file-task']['name'][$i];
            $file_size = $_FILES['file-task']['size'][$i];
            $file_tmp = $_FILES['file-task']['tmp_name'][$i];
            $file_type = $_FILES['file-task']['type'][$i];
            $array = explode('.', $_FILES['file-task']['name'][$i]);
            $file_ext = strtolower(end($array));

            $extensions= array('txt', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'png', 'mp3', 'mp4',
                'pdf', 'rar', 'zip');

            if(in_array($file_ext,$extensions) === false){
                error_response(2, 'File không hợp lệ');
            }

            if($file_size > 524288000) {
                error_response(3, 'File size > 50MB');
            }
            $file = "../file_absence/".$file_name;
            move_uploaded_file($file_tmp,$file);
            if ($i == 0){
                $file_output = $file_name;
            }
            else{
                $file_output = $file_name . '//' . $file_output;
            }
        }

    }

    $sql = 'INSERT INTO `requestabsence`(`username`,`department`,`role`,`dayAbsence`, `reason`, `file`, `status`, `date`,`expire_on`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

    $data = array($name, $department, $role, $dayoff, $reason, $file_output, 'waiting', date("Y/m/d h:i:sa"), time() + 604800);
    $stm = $dbCon->prepare($sql);
    $stm->execute($data);
    if ($stm->rowCount() == 1){
        die(json_encode(array('code' => 0, 'message' => 'Yêu cầu thành công')));
    }
    die(json_encode(array('code' => 1, 'message' => 'Yêu cầu thất bại.')));

?>