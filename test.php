<?php
    session_start();
    require_once('./connection.php');
    $sql = 'SELECT status ,expire_on
            FROM requestabsence
            WHERE username = ?
            ORDER BY date DESC
            LIMIT 1';

    $user = $_GET['user'];
    $stm = $dbCon->prepare($sql);
    $stm->execute(array($user));
    $row = $stm->fetch();

    if ($row['status'] == 'waiting') {
        die(json_encode(array('code' => 1, 'message' => 'Không thể tạo yêu cầu khi có đơn đang chờ duyệt')));
    }
    else if (time() < $row['expire_on']) {
        die(json_encode(array('code' => 1, 'message' => 'Phải sau 7 ngày khi được duyệt mới được tạo đơn mới')));
    }
    //die(json_encode(array('code' => 0, 'message' => 'Ok la')));
    echo time();
?>