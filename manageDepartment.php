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
<body style="min-height: 120vh;">
<?php
    require_once('./include/NavbarQL.php');
?>

<div class="container-fluid align-items-center">
    <div class="background col-lg-8 col-md-10 col-sm-12"></div>
</div>

<div style="position: relative;">
    <div class="container-fluid" style="position: absolute; top: 10px ;display: flex; justify-content: center;">
        <div class="management col-lg-2 col-md-3 col-sm-4 col-5">
            <div class="management-item">
                <button id="add-department-btn" class="button-add text-center">Thêm phòng ban</button>
                <!-- <button id="appoint-department-btn" class="button-add text-center">Thêm trưởng phòng</button> -->
                <select id="show-department-manager" style="margin-top: 15px;" class="form-select button-notice text-center">
                    <option value="1">Xem các phòng</option>
                    <option value="2">Các trưởng phòng</option>
                </select>
            </div>
        </div>
        <div class="management col-lg-6 col-md-7 col-sm-8 col-7" style="padding-left: 20px">
            <div id ="list-department" class="right">

                <!-- <div class="management-item">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Phòng:</b> Phát triển phần mềm</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Trưởng phòng:</b> sangsinh</a>
                            </div>
                        </div>
                        <div class="m-3">
                            <button type="button" class="btn btn-outline-danger">Bãi nhiệm</button>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>


<!-- Add new dialog -->
<div class="modal fade" id="new-department-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h1 class="mt-4 mb-2">Thêm phòng ban mới</h1>
                </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="task-label" for="department-name">Tên phòng ban</label>
                    <input id="department-name" type="text" class="form-input" placeholder="Nhập tên phòng ban">
                </div>
                <div class="form-group">
                        <label class="task-label" for="describe-department">Mô tả</label>
                        <textarea id="describe-department" rows="4" class="form-input" placeholder="Mô tả phòng ban" style="height: auto;"></textarea>
                    </div>
                <div class="form-group">
                    <label class="task-label" for="number-room">Số phòng</label>
                    <input id="number-room" type="number" class="form-input" min="1" max="30">
                </div>
                <div id="add-department-error" class='alert alert-danger' style='text-align: center;margin: 0 23px;display:none'></div>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="confirm-add-department" class="btn btn-success">Save</button>
            </div>            
            </div>
        </div>
    </div>
</div>


<!-- Update department dialog -->
<div class="modal fade" id="update-department-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h1 class="mt-4 mb-2">Chỉnh sửa thông tin phòng <strong id="department-update-info" style="color: red;"></strong></h1>
                </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="task-label" for="department-name">Tên phòng ban</label>
                    <input id="update-department-name" type="text" class="form-input">
                </div>
                <div class="form-group">
                        <label class="task-label" for="describe-department">Mô tả</label>
                        <textarea id="update-describe-department" rows="4" class="form-input" style="height: auto;"></textarea>
                    </div>
                <div class="form-group">
                    <label class="task-label" for="number-room">Số phòng</label>
                    <input id="update-number-room" type="number" class="form-input" min="1" max="30">
                </div>
                <div id="update-department-error" class='alert alert-danger' style='text-align: center;margin: 0 23px;display:none'></div>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="confirm-update-department" class="btn btn-success">Save</button>
            </div>            
            </div>
        </div>
    </div>
</div>


<!-- Get Department dialog -->
<div id="info-department-dialog" class="modal hide fade bd-example-modal-lg" tabindex="-1" role="dialog" data-focus-on="input:first" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="header" style="margin: 30px 60px 10px 60px;">
            <h3 style="font-size: 33px;margin-bottom: 20px;">Thông tin phòng <strong class="department-info" style="color: red;"></strong></h3>
        </div>
    
        <div class="profile-content" style="margin: 0 60px;">
            <div class="profile-info">
                <div class="info-list">
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Tên phòng ban</label>
                            <p class="context department-info-username"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Mô tả</label>
                            <textarea id="describe-department-info" rows="4" class="form-input" style="height: auto;"></textarea>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Số phòng</label>
                            <p class="context department-info-room"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Trưởng phòng</label>
                            <p class="context department-info-manager"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Số điện thoại</label>
                            <p class="context department-info-phone"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Email liên lạc</label>
                            <p class="context department-info-mail"></p>
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

<!-- Add new manager -->
<div class="modal fade" id="new-manager-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h1 class="mt-4 mb-2">Bổ nhiệm trưởng phòng mới</h1>
                </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="task-label" for="manager-name">Bổ nhiệm nhân viên</label>
                    <input id="manager-name" type="text" class="form-input" placeholder="Nhập tên tài khoản nhân viên">
                </div>
                <div style="margin: 0 35px;font-size: 13px;color: #5f6368;">Vì tên nhân viên trong công ty có thể trùng nên cần nhập tên tài khoản</div>
                <div id="add-manager-error" class='alert alert-danger' style='text-align: center;margin: 10px 23px;display:none'></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="confirm-add-manager" class="btn btn-success">Save</button>
            </div>            
            </div>
        </div>
    </div>
</div>

<!-- Dimiss a manager -->
<div class="modal fade" id="dimiss-manager-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bãi nhiệm nhân viên</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bãi nhiệm nhân viên <strong class="manager-username" style="color: red;font-size: 20px;">sangsinh</strong> đang là trưởng phòng <strong class="department-dismiss" style="color: red;font-size: 20px;"></strong>?</p>
        <div id="dismiss-manager-error" class='alert alert-danger' style='text-align: center;margin: 10px 23px;display:none'></div>  
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
        <button type="button" id ="confirm-dimiss-manager" class="btn btn-primary">Có</button>
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