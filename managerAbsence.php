<?php
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['activated'] == 0) {
        header('Location: login.php');
        exit();
    }

    $dayoff = 0;
    $dayleft = 0;

    require_once('connection.php');
    $sql = 'SELECT role,dayoff FROM account WHERE username = ?';
    $stmt = $dbCon->prepare($sql);
    $stmt->execute(array($_SESSION['user']));
    if($stmt->rowCount() > 0) { 
        $row = $stmt->fetch();
        $dayoff = $row['dayoff'];
        if ($row['role'] == 1) {
            $dayleft = 12 - $row['dayoff'];
        }
        else {
            $dayleft = 15 - $row['dayoff'];
            if ($dayleft < 0) {
                $dayleft = 0;
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link 
         rel="stylesheet"
         href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
         integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="./style.css">
</head>
<body>
<?php
    require_once('./include/Navbar.php');
?>

<div class="container-fluid align-items-center">
    <div class="background col-lg-8 col-md-10 col-sm-12"></div>
</div>

<div style="position: relative;">
    <div class="container-fluid" style="position: absolute; top: 10px ;display: flex; justify-content: center;">
        <div class="management col-lg-2 col-md-3 col-sm-4 col-5">
            <div class="management-item">
                <button id="add-absence-btn" class="button-add text-center" data-toggle="modal">Yêu cầu nghỉ phép</button>
                <!-- <div class="search-group has-search"> -->
                   <p class="number-dayAbsence">Đã nghỉ <strong style="color: red;"><?= $dayoff ?></strong> ngày</p>
                   <p class="number-canAbsence">Có thể nghỉ <strong><?= $dayleft ?></strong> ngày</p>
                <!-- </div> -->
            </div>
        </div>
        <div class="management col-lg-6 col-md-7 col-sm-8 col-7" style="padding-left: 20px">
            <div id ="list-absence" class="right">

                <!-- <div class="management-item">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Số ngày nghỉ:</b> 5</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Lí do:</b> bị bệnh</a>
                            </div>
                        </div>
                        <div class="m-3">
                            <p style="color:red;margin: 0;font-size: 22px;font-weight: bold;">Waiting</p>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>

<!-- Add new absence dialog -->
<div class="modal fade" id="new-absence-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h2 style="font-weight: bold;" class="mt-4 mb-2">Tạo yêu cầu nghỉ phép</h2>
                </div>
            <div class="modal-body">
                <form id="absence-form" method="post" class="px-4 px-sm-4 px-m-5 px-lg-4 pt-3" enctype="multipart/form-data" onsubmit="return false">
                    <div class="form-group">
                        <label class="task-label" for="number-day-off">Số ngày muốn nghỉ</label>
                        <input id="number-day-off" name="number-day-off" type="number" class="form-input" min="1" max="30">
                    </div>
                    <div class="form-group">
                        <label class="task-label" for="reason-absence">Lí do</label>
                        <textarea id="reason-absence" name="reason-absence" rows="4" class="form-input" placeholder="Mô tả lí do" style="height: auto;"></textarea>
                    </div>
                    <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name = "document-absence" id="document-absence"> 
                                <label class="custom-file-label" for="document-absence">File đính kèm</label>
                            </div>
                    </div>
                    <div id="add-absence-error" class='alert alert-danger' style='text-align: center;margin: 0 23px;display:none;height: auto;'></div>
                    
                </form>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="confirm-add-absence" class="btn btn-success">Save</button>
            </div>            
            </div>
        </div>
    </div>
</div>

<!-- Get Absence report dialog -->
<div id="info-absence-dialog" class="modal hide fade bd-example-modal-lg" tabindex="-1" role="dialog" data-focus-on="input:first" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="header" style="margin: 30px 60px 10px 60px;">
            <h3 style="font-size: 33px;margin-bottom: 20px;">Thông tin ngày nghỉ phép <strong class="absence-info" style="color: red;"></strong></h3>
        </div>
    
        <div class="profile-content" style="margin: 0 60px;">
            <div class="profile-info">
                <div class="info-list">
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Số ngày nghỉ</label>
                            <p class="context dayoff"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Lí do</label>
                            <textarea id="reason-user-absence" rows="4" class="form-input" style="height: auto;"></textarea>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Tệp đính kèm</label>
                            <a id="file-absence" style="margin-left: 10px;" href="./file_absence/1.1-1.4 (1).docx" download="1.1-1.4 (1).docx">download</a>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Trạng thái</label>
                            <p class="context status-report"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Ngày tạo</label>
                            <p class="context report-date"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> 

    </div>
  </div>
</div>


<script type="text/javascript" src="./main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
