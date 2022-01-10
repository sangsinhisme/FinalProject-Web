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
    require_once('./include/NavbarQL.php');
?>

<div class="container-fluid align-items-center">
    <div class="background col-lg-8 col-md-10 col-sm-12"></div>
</div>

<div style="position: relative;">
    <div class="container-fluid" style="position: absolute; top: 10px ;display: flex; justify-content: center;">
        <div class="management col-lg-2 col-md-3 col-sm-4 col-5">
            <div class="management-item">
                <button id="add-employee-btn" class="button-add text-center" data-toggle="modal">Thêm nhân viên</button>
                <div class="search-group has-search">
                    <span class="fa fa-search form-icon-search"></span>
                    <input type="search" id="search-input" name=search class="form-control" placeholder="Search.."/>
                </div>
            </div>
        </div>
        <div class="management col-lg-6 col-md-7 col-sm-8 col-7" style="padding-left: 20px">
            <div id ="list-employee" class="right">

                <!-- <div class="management-item">
                    <div class="row">
                        <img class="avatar dot-work" src="images/male.svg">
                        <div style="flex: 1;">
                            <a class="task">Nguyễn Hữu Huy</a>
                            <div class="task-box">
                                <a class="task text-decoration-none" style="color: var(--dark-green)">Phòng ban: Quản trị kinh doanh</a><br>
                            </div>
                        </div>
                        <div class="resetpass" href="#" onclick="confirmRemoval()">ResetPassword</div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</div>

<!-- Get Employee dialog -->
<div id="info-employee-dialog" class="modal hide fade bd-example-modal-lg" tabindex="-1" role="dialog" data-focus-on="input:first" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="header" style="margin: 30px 60px 10px 60px;">
            <h3 style="font-size: 33px;margin-bottom: 20px;">Hồ Sơ Của <strong class="employee-info" style="color: red;">huuhuy</strong></h3>
            <p style="font-size: 20px;">Quản lý thông tin hồ sơ của nhân viên</p>
        </div>
    
        <div class="profile-content" style="margin: 0 60px;">
            <div class="profile-info">
                <div class="info-list">
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Tài khoản</label>
                            <p class="context employee-info-username">Tonyteo</p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Mật khẩu</label>
                            <p class="context">*********</p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Họ và tên</label>
                            <p class="context employee-info-name"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Giới tính</label>
                            <p class="context employee-info-gender"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Số điện thoại</label>
                            <p class="context employee-info-phone"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Email</label>
                            <p class="context employee-info-mail"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Chức vụ</label>
                            <p class="context employee-info-position"></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Phòng</label>
                            <p class="context employee-info-department"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-img">
                <div class="info-image">
                    <div class="info-img">
                        <div class="img-wrap">
                            <img id="employee-avatar" src=".\avatar\avatar.jpg" alt="avatar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<!-- Add new dialog -->
<div class="modal fade" id="new-employee-dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h1 class="mt-4 mb-2">Thêm nhân viên mới</h1>
                </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="task-label" for="username">Tên đăng nhập</label>
                    <input id="username" type="text" class="form-input" placeholder="Nhập tên tài khoản">
                </div>
                <div class="form-group">
                    <label class="task-label" for="name">Họ và tên</label>
                    <input id="name" name="name" type="text" class="form-input" placeholder="Nhập họ và tên">
                </div>
                <div class="form-group">
                    <label class="task-label">Giới tính</label>
                    <div style="font-size: 16px;margin: 1px 5% 0 5%;">
                        <input id="male" type="radio" name="gender" value="1">
                        <label style="margin: 0"  for="male">Nam</label>
                        <input id="female" type="radio" name="gender" value="2">
                        <label style="margin: 0" for="female">Nữ</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="task-label" for="phone">Số điện thoại</label>
                    <input id="phone" name="phone" type="tel" class="form-input" placeholder="Nhập số điện thoại">
                </div>
                <div class="form-group">
                    <label class="task-label" for="mail">Email</label>
                    <input id="mail" name="mail" type="text" class="form-input" placeholder="Nhập email">
                </div>
                <div class="form-group">
                    <label class="task-label" for="position">Chức vụ</label>
                    <select id="position" name="position" class="form-input" style="padding: 2px 14px">
                        <option value="1">Nhân viên</option>
                        <option value="2">Trưởng phòng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="task-label" for="department">Phòng/Ban</label>
                    <select id="department" name="department" class="form-input" style="padding: 2px 14px">
                        <option value="1">Công nghệ thông tin</option>
                        <option value="2">Kế toán</option>
                        <option value="3">Nhân sự</option>
                    </select>
                </div>
                <div id="add-employee-error" class='alert alert-danger' style='text-align: center;margin: 0 23px;display:none'></div>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="confirm-add" class="btn btn-success">Save</button>
            </div>            
            </div>
        </div>
    </div>
</div>


<!-- Reset Dialog -->
<div id="reset-password-dialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn reset <strong class="reset-user"></strong> ?</p>
            </div>
            <div id="reset-password-error" class='alert alert-danger' style='text-align: center;display: none;'></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-success resetpass-btn">Reset</button>
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
