<?php
    session_start();
    if(isset($_FILES['file'])){
        require_once ('./connection.php');
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $username = $_SESSION['user'];
        
        if ( 0 < $_FILES['file']['error'] ) {
            die(json_encode(array('code' => 1, 'message' => 'Error: ' . $_FILES['file']['error'])));
        }
        
        if($file_size > 1048576) {
            die(json_encode(array('code' => 1, 'message' => 'File size must less 1 MB')));
        }
        $sql = 'UPDATE account set avatar = ? where username = ?';
        $filename = './avatar/'.$file_name;
        try{
            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array($file_name,$username));
    
            $count = $stmt->rowCount();
            die(json_encode(array('code' => 1, 'message' => $file_name.$username.$file_tmp)));
            if ($count == 1) {
                if (!file_exists($filename)) {
                    move_uploaded_file($file_tmp,"./avatar/".$file_name);
                }
                else {
                    unlink($file_tmp);
                }
                $_SESSION['avatar'] = $file_name;
                die(json_encode(array('code' => 0, 'avatar' => $file_name)));
            }
            else {
                die(json_encode(array('code' => 1, 'message' => 'Upload failed')));
            }
        }
        catch(PDOException $ex){
            die(json_encode(array('code' => 1, 'message' => $ex->getMessage())));
        }
         
     }
?>