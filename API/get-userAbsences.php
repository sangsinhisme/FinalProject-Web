<?php
    session_start();
    require_once ('../connection.php');

    $sql = 'SELECT * 
    FROM requestabsence
    WHERE username = ? AND role = ?
    ORDER BY date DESC';
    
    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($_SESSION['user'],$_SESSION['role']));
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