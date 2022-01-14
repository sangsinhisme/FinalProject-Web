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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="./style.css?<?php echo time(); ?>">
</head>

<body>

<?php
require_once('include/Navbar.php')
?>

<div class="container-fluid align-items-center">
    <div class="background col-lg-8 col-md-10 col-sm-12"></div>
</div>

<div style="position: relative;">
    <div class="container-fluid" style="position: absolute; top: 10px ;display: flex; justify-content: center;">
        <div class="management col-lg-2 col-md-3 col-sm-4 col-5">
            <button class="button-notice text-center" style="margin-top: 16px; padding: 10px">Nhật ký hoạt động</button>
            <div class="management-item">
                <a>Tiến độ công việc</a>
                <div class="task-box">
                    <span class="dot task-new"></span><a class="task" id="task-new">0 Mới</a><br>
                </div>
                <div class="task-box">
                    <span class="dot task-progress"></span><a class="task" id="task-process">0 Đang thực hiện</a><br>
                </div>
                <div class="task-box">
                    <span class="dot task-waiting"></span><a class="task" id="task-waiting">0 Đang chờ</a><br>
                </div>
                <div class="task-box">
                    <span class="dot task-rejected"></span><a class="task" id="task-rejected">0 Từ chối</a><br>
                </div>
            </div>
            <div class="management-item">
                <a>Tổng số tác vụ</a>
                <div class="task-box">
                    <span class="dot task-complete"></span><a class="task" id="task-complete">0 Đã hoàn thành</a><br>
                </div>
                <div style="display: flex; align-items: center; display: none" >
                    <span class="dot task-canceled"></span><a class="task" id="task-canceled">0 Đã hủy</a><br>
                </div>
            </div>
        </div>
        <div class="management col-lg-6 col-md-7 col-sm-8 col-7" style="padding-left: 20px">
            <div id="task-list" class="right">
            </div>
    </div>
</div>

<div class="modal fade" id="profile-task-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h1 class="mt-4 mb-2">Thông tin tác vụ</h1>
            </div>
            <form id="task-form" method="post" class="px-4 px-sm-4 px-m-5 px-lg-4 pt-3" enctype="multipart/form-data" onsubmit="return false;">
                <div class="renew">
                    <div class="form-group">
                        <label class="task-label" for="name-tas-profilek">Tên tác vụ</label>
                        <input id="name-task-profile" name="name-task" type="text" class="form-input" disabled="disabled">
                    </div>
                    <div class="form-group">
                        <label class="task-label" for="employee-task-profile">Trạng thái</label>
                        <input id="process-task-profile" name="name-task" type="text" class="form-input" disabled="disabled">
                    </div>
                    <div class="form-group">
                        <label class="task-label" for="employee-task-profile">Người thực hiện</label>
                        <input id="employee-task-profile" name="name-task" type="text" class="form-input" disabled="disabled">
                    </div>
                    <div class="form-group" id="rating-task-div" onclick="rating_task_check()">
                        <label class="task-label" for="rating-task">Đánh giá</label>
                        <select id="rating-task" name="rating-task" class="form-input" style="padding: 2px 14px">
                            <option value="task-complete" class="text-success">Hoàn thành</option>
                            <option value="task-canceled" class="text-danger">Từ chối</option>
                        </select>
                    </div>
                    <div class="form-group" id="rating-task-complete">
                        <label class="task-label" for="rating-task-lv">Mức độ hoàn thành</label>
                        <select id="rating-task-lv" name="rating-task-lv" class="form-input" style="padding: 2px 14px">
                            <option value="Good">Good</option>
                            <option value="Ok">Ok</option>
                            <option value="Bad">Bad</option>
                        </select>
                    </div>
                    <div class="form-group" id="deadline-task-div">
                        <label class="task-label" for="deadline-task-profile">Hạn nộp</label>
                        <input id="deadline-task-profile" name="deadline-task" type="date" class="form-input" disabled="disabled">
                    </div>
                    <div class="form-group" id="deadtine-task-div">
                        <label class="task-label" for="deadline-time-task-profile">Thời gian</label>
                        <input id="deadline-time-task-profile" name="deadline-time-task" type="time" class="form-input" disabled="disabled">
                    </div>
                    <div class="form-group" id="describe-task-div">
                        <label class="task-label" for="describe-task-profile">Nội dung</label>
                        <textarea id="describe-task-profile" name="describe-task" rows="1" class="form-input"style="height: auto;" disabled="disabled"></textarea>
                    </div>
                    <div class="form-group" id="rating-task-file">
                        <label class="task-label" for="file-task-response">Đính kèm tệp phản hồi</label>
                        <input id="file-task-response" class="form-input" name="file-task-response" type="file" style="display: inline-flex;text-indent: -130px; padding: 10px 14px;" multiple>
                    </div>
                    <div class="form-group" id="file-task-profile">
                    </div>
                    <div class="form-group" id="file-response-task-profile">
                    </div>
                    <div class="form-group" id="response-task-div" >
                        <label class="task-label" for="response-task-profile">Phản hồi</label>
                        <textarea id="response-task-profile" name="response-task" rows="1" class="form-input"style="height: auto;"></textarea>
                    </div>
                    <div class="form-group" id="submit-task-file">
                        <label class="task-label" for="submit-task-response">Tập tin thực hiện</label>
                        <input id="submit-task-response" class="form-input" name="submit-task-response" type="file" style="display: inline-flex;text-indent: -130px; padding: 10px 14px;" multiple>
                    </div>
                </div>
                <div id="add-task-error-profile" class='alert-danger' style='text-align: center;margin: 0 23px;display:none'></div>
                <div class="input-group custom-control custom-checkbox pb-4">
                    <div class="custom-button text-right" id="task-button">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript" src="./main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
