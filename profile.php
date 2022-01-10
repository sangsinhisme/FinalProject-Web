<?php
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['activated'] == 0) {
        header('Location: login.php');
        exit();
    }
    $error = '';
    $username = '';
    $name = '';
    $gender = '';
    $phone = '';
    $mail = '';
    $position = '';
    $department = '';
    $avatar = '';
    require_once ('./connection.php');
    $sql = 'SELECT username,name,gender,phone,mail,position,department,avatar FROM account where username = ?';

    try{
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($_SESSION['user']));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $data['username'];
        $name = $data['name'];
        $gender = $data['gender'];
        $phone = $data['phone'];
        $mail = $data['mail'];
        $position = $data['position'];
        $department = $data['department'];
        $avatar = $data['avatar'];
    }
    catch(PDOException $ex){
        $error = $ex->getMessage();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="./style.css">
    <title>Hồ sơ của tôi</title>
</head>
<body class="body-profile">

<?php
    require_once('./include/NavbarQL.php');
?>

<div style="padding-top: 1.75rem;">
    <div class="container-fluid title col-lg-8 col-md-10 col-sm-12">
        <div class="header">
            <h3>Hồ Sơ Của Tôi</h3>
            <p>Quản lý thông tin hồ sơ của bạn</p>
        </div>
    
        <div class="profile-content">
            <div class="profile-info">
                <div class="info-list">
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Tên tài khoản</label>
                            <p class="context"><?= $username ?></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Mật khẩu</label>
                            <p class="context">********* <a style="text-decoration: underline;color:#05a;cursor: pointer;" id="resetPass-btn" onclick="resetUserPassword()">Thay đổi</a></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Tên</label>
                            <p class="context"><?= $name ?></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Giới tính</label>
                            <p class="context"><?= $gender ?></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Số điện thoại</label>
                            <p class="context"><?= $phone ?></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Email</label>
                            <p class="context"><?= $mail ?></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Chức vụ</label>
                            <p class="context"><?= $position ?></p>
                        </div>
                    </div>
                    <div class="info-item-wrap">
                        <div class="info-item">
                            <label>Phòng ban</label>
                            <p class="context"><?= $department ?></p>
                        </div>
                    </div>
                    <div id="reset-pass-success" class='alert alert-success' style='text-align: center;margin: 10px 23px;display:none'>Đổi mật khẩu thành công</div>
                    <div id="upload-avt-error" class='alert alert-danger' style='text-align: center;margin: 10px 23px;display:none'>Vui lòng chọn ảnh để upload</div>
                    <div class="save-btn">
                        <button onclick="uploadAvatar()" id="upload-avt-btn" type="button" class="btn btn-profile" aria-disabled="false">Lưu</button>
                    </div>
    
                </div>
            </div>
            <div class="profile-img">
                <div class="info-image">
                    <div class="info-img">
                        <div class="img-wrap">
                            <img id="user-avatar" src="./avatar/<?= $avatar ?>" alt="">
                        </div>
                        <input id="file-upload-avatar" type="file" accept="image/jpeg, image/png" onchange="readURL(this);">
                        <label for="file-upload-avatar" class="custom-file-upload">Chọn Ảnh</label>
                        <div class="descrip">
                            <div>Dụng lượng file tối đa 1 MB</div>
                            <div>Định dạng:.JPEG, .PNG</div>
                        </div>
                    </div>
                    <!-- <img src=".\images\profile\photo-1453728013993-6d66e9c9123a.jpg" alt=""> -->
                    <!-- <input type="file" value="Chọn ảnh"> -->
                </div>
            </div>
        </div>   
    </div>
</div>

<!-- Modal Upload Success!-->
<div class="modal fade" id="upload-success-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img id="upload-avt-icon" style="width: 60px;margin: auto;display: block;" src="./images/success-24.png" alt="success-icon">
        <p id="upload-avt-descrip" style="text-align: center;margin: 1rem; font-size: 21px;">Upload avatar thành công !</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal Reset Password! -->
<div class="modal fade" id="reset-pass-dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h1 class="mt-4 mb-2">Thay đổi mật khẩu</h1>
                </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="task-label" for="oldpass">Mật khẩu cũ</label>
                    <input id="oldpass" type="password" class="form-input" placeholder="Nhập mật khẩu cũ">
                </div>
                <div class="form-group">
                    <label class="task-label" for="newpass">Mật khẩu mới</label>
                    <input id="newpass" type="password" class="form-input" placeholder="Nhập mật khẩu mới">
                </div>
                <div class="form-group">
                    <label class="task-label" for="confirmpass">Nhập lại mật khẩu mới</label>
                    <input id="confirmpass" type="password" class="form-input" placeholder="Nhập lại mật khẩu mới">
                </div>
                <div id="reset-pass-error" class='alert alert-danger' style='text-align: center;margin: 0 23px;display:none'></div>               
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id ="confirm-repass" class="btn btn-success">Save</button>
            </div>            
            </div>
        </div>
    </div>
</div>

<script src="main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>