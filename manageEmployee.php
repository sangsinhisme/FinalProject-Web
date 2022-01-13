<?php
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['activated'] == 0) {
        header('Location: login.php');
        exit();
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
        
        <div class="management col-lg-8 col-md-10 col-sm-12 col-12">
            <div id ="list-manager-absence" class="right">
            
                <!-- <div class="management-item">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Username:</b> sangsinh</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Ngày tạo:</b> 12/1/2022</a>
                            </div>
                        </div>
                        <div style="margin: 20px">
                            <a class="btn btn-success border" style="color:white" onclick="getEmployee(this)">
                                <i class="fas fa-check"></i>
                            </a>   
                            <a class="btn btn-danger border" style="color:white" onclick= "resetPass(this)">
                                <i class="fas fa-times"></i>
                            </a>  
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>

<!-- Get Absence report dialog -->
<div id="absence-manager-dialog" class="modal hide fade bd-example-modal-lg" tabindex="-1" role="dialog" data-focus-on="input:first" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="header" style="margin: 30px 60px 10px 60px;">
            <h3 style="font-size: 33px;margin-bottom: 20px;">Thông tin ngày nghỉ phép của <strong class="absence-info" style="color: red;"></strong></h3>
        </div>
    
        <div class="profile-content" style="margin: 0 60px;">
            <div class="profile-info">
                <div class="info-list">
                <div class="info-item-wrap">
                    <div class="info-item">
                        <label>Họ và tên</label>
                        <p class="context manager-absence-name"></p>
                    </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Phòng</label>
                            <p class="context manager-absence-department"></p>
                        </div>
                    </div>
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

<!-- Modal approved absence -->
<div class="modal fade" id="approved-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Duyệt đơn nghỉ phép</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong style="color: green">Chấp nhận</strong> yêu cầu nghỉ phép của <strong class="user-absence"></strong></p>
        <div id="approve-absence-error" class='alert alert-danger' style='text-align: center;margin: 10px 23px;display:none'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
        <button type="button" id="confirm-approve" class="btn btn-primary">Đồng ý</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal refused absence -->
<div class="modal fade" id="refused-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Duyệt đơn nghỉ phép</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong style="color: red">Từ chối</strong> yêu cầu nghỉ phép của <strong class="user-absence"></strong></p>
        <div id="refuse-absence-error" class='alert alert-danger' style='text-align: center;margin: 10px 23px;display:none'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
        <button type="button" id="confirm-refused" class="btn btn-primary">Đồng ý</button>
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
