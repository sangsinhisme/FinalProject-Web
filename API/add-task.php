<?php
    header(header: 'Content-Type: application/json; charset=utf-8');
    require_once ('../connection.php');

    $name = $_POST['name-task'];
    $employee = $_POST['employee-task'];
    $deadline = $_POST['deadline-task'];
    $deadtime = $_POST['deadtime-task'];
    $describ= $_POST['describ-task'];
    $process = $_POST['process-task'];
    $file_output = "";

    if(!isset($name) || !isset($employee) || !isset($deadline) || !isset($deadtime) ){
        error_response(1, 'Dữ liệu không hợp lệ.');
    }

    if($name === "" || $employee === "" || $deadline === "" || $deadtime === ""){
        error_response(4, 'Vui lòng nhập đủ thông tin.');
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
            $file = "../task_data/".$file_name;
            move_uploaded_file($file_tmp,$file);
            if ($i == 0){
                $file_output = $file_name;
            }
            else{
                $file_output = $file_name . '//' . $file_output;
            }
        }

        }

    $sql = 'INSERT INTO `task`(`name`, `employee`, `deadline`, `deadtime`, `describ`, `file`, `process`) VALUES (?, ?, ?, ?, ?, ?, ?)';

    $data = array($name, $employee, $deadline, $deadtime, $describ, $file_output, $process);
    $stm = $dbCon->prepare($sql);
    $stm->execute($data);
    if ($stm->rowCount() == 1){
        error_response(0, "Thêm tác vụ thành công");
    }
    error_response(5, "Thêm tác vụ thất bại! Có lỗi xảy ra.");



?>