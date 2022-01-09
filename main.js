
// Onload window event
window.onload = function() {
    if (window.location.href.indexOf('manageAccount.php') > -1) {
        loadEmployee()

        $("#add-employee-btn").click(function () {
            $('#new-employee-dialog').modal({show: true});
            $('#confirm-add').click(function () {
            $.ajax({
                    url: "http://localhost/Finalproject/API/add-Employee.php",
                    type: "post", //send it through get method
                    contentType: 'application/json',
                    dataType: "json",
                    data: JSON.stringify({ 
                        username: $('#username').val() ,
                        name: $('#name').val() ,
                        position: $('#position').val(),
                        department: $('#department').val()
                    }),
                    success: function(respone) {
                        if (respone.code == 0) {
                            $('#new-employee-dialog').modal('toggle');
                            loadEmployee()
                        }
                        else {
                            $('#add-employee-error').show()
                            $('#add-employee-error').html(respone.message)
                        }
                    }
                });
            })
        });
    }

    /* task index */
    if (window.location.href.indexOf('index.php') > -1) {
        loadTask()
        $("#add-task-btn").click(function () {
            $('#new-task-dialog').modal({show: true});
            $('#add-task').click(function () {
                let data = new FormData();
                data.append("name-task", $('#name-task').val());
                data.append("employee-task", $('#employee-task').val());
                data.append("deadline-task", $('#deadline-task').val());
                data.append("deadtime-task", $('#deadline-time-task').val());
                data.append("describ-task", $('#describe-task').val());
                data.append("process-task", "task-new");
                for ($i = 0; $i < $('#file-task').prop("files").length; $i++){
                    data.append("file-task[]", $('#file-task').prop("files")[$i])
                }

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "http://localhost/Finalproject/API/add-task.php", true);
                xhr.send(data);
                xhr.onload = function (e){
                    let result = JSON.parse(this.response);
                    if (result.code === 0){
                        document.getElementById("task-form").reset();
                        $('#add-task-success').html(result.message)
                        $('#add-task-success').fadeIn()
                        $('#add-task-success').fadeOut(3000)
                        loadTask()
                    }
                    else {
                        $('#add-task-error').html(result.message)
                        $('#add-task-error').fadeIn()
                        $('#add-task-error').fadeOut(3000)
                        $('#name-task').focus();
                    }
                }
            })
        });
    }
    
}

/* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "310px";
}

/* Set the width of the side navigation to 0 */
function closeNav(){
    document.getElementById("mySidenav").style.width = "0px";
}

function getEmployee(e) {
    let user = $(e).attr('user')
    let selecteduser= JSON.parse(user)
    $('#info-employee-dialog').modal({show: true});
    $('.employee-info').html(selecteduser)
    $.ajax({
        type: "GET",
        url: "http://localhost:8888/FinalProject-Web/API/get-Employee.php?" + $.param({
            "id": selecteduser
        }),
        success: function(respone) {
            if (respone.code == 0) {
                $('.employee-info-username').html(respone.data.username)
                $('.employee-info-name').html(respone.data.name)
                $('.employee-info-position').html(respone.data.position)
                $('.employee-info-department').html(respone.data.department)
                $("#employee-avatar").attr("src",`./avatar/${respone.data.avatar}`);
            }
        }
    });
}

// Function reset password
function resetPass(e) {
    $('#resetPass').modal({show: true});
    let user = $(e.parentNode.parentNode).attr('user')
    let selecteduser= JSON.parse(user)
    $('.reset-user').html(selecteduser) 
    $('.resetpass-btn').click(function () {
        $.ajax({
            type: "GET",
            url: "http://localhost:8888/FinalProject-Web/API/reset-Password.php?" + $.param({
                "id": selecteduser
            }),
            success: function(respone) {
                if (respone.code == 0) {
                    $('#resetPass').modal('toggle');
                    loadEmployee()
                }
                else {
                    $('#reset-password-error').show()
                    $('#reset-password-error').html(respone.message)
                }
            }
        });
    })
}

let count_task_number = [0, 0, 0, 0, 0, 0];
let task_convert = {"task-new": "Tác vụ mới", "task-process" : "Tác vụ đang được thực hiện", "task-waiting" : "Tác vụ đang chờ",
"task-rejected": "Tác vụ đã từ chối", "task-complete" : "Tác vụ đã hoàn thành", "task-canceled" : "Tác vụ đã hủy"};

function count_task(process){
    if (process === "task-new") count_task_number[0] += 1;
    if (process === "task-progress") count_task_number[1] += 1;
    if (process === "task-waiting") count_task_number[2] += 1;
    if (process === "task-rejected") count_task_number[3] += 1;
    if (process === "task-complete") count_task_number[4] += 1;
    if (process === "task-canceled") count_task_number[5] += 1;
}

function loadTask(){
    $.ajax({
        url: "http://localhost/Finalproject/API/get-task-index.php",
        type: "get",
        dataType: "json",
        success: function(data) {
            $('#task-list .management-item').remove();
            data.data.forEach(task => {
                count_task(task.process)
                let taskRow = $(`
                <div class="management-item" onclick="getTask(this)">
                    <div class="row" style="display: block">
                        <span class="dot-work ${task.process}"></span>
                        <span>
                            <a class="task-label">${task.name}</a>
                            <a class="task-right"style="display: none">${task.id}</a>
                            <div class="task-box">
                                <a class="task">To: ${task.employee}</a>
                                <a class="task-right">${task.deadline}</a>
                            </div>
                        </span>
                    </div>
                </div>
                `)
                taskRow.attr('id-task',JSON.stringify(task.id))
                $('#task-list').prepend(taskRow)
            });
            document.getElementById('task-new').innerText = count_task_number[0] + " Mới";
            document.getElementById('task-process').innerText = count_task_number[1] + " Đang thực hiện";
            document.getElementById('task-waiting').innerText = count_task_number[2] + " Đang chờ";
            document.getElementById('task-rejected').innerText = count_task_number[3] + " Từ chối";
            document.getElementById('task-complete').innerText = count_task_number[4] + " Đã hoàn thành";
            document.getElementById('task-canceled').innerText = count_task_number[5] + " Đã hủy";
            count_task_number = [0, 0, 0, 0, 0, 0];
        }
    });
}

function getTask(e){
    let task = $(e).attr('id-task')
    let selectedTask= JSON.parse(task)
    $('#profile-task-dialog').modal({show: true});
    $.ajax({
        type: "GET",
        url: "http://localhost/Finalproject/API/get-task-byID.php?" + $.param({
            "id": selectedTask
        }),
        success: function(respone) {
            if (respone.code == 0) {
                $('#file-task-profile .task-label').remove();
                $('#file-task-profile br').remove();
                $('#task-button .btn').remove();

                $('#rating-task-complete').hide();
                $('#rating-task-div').hide();
                $('#rating-task-file').hide();
                $('#deadline-task-div').show();
                $('#deadtine-task-div').show();
                $('#describe-task-div').show();

                $('#name-task-profile').attr("value", respone.data.name);
                $('#name-task-profile').attr('disabled','disabled');
                $('#process-task-profile').attr("value", task_convert[respone.data.process]);
                $('#employee-task-profile').attr("value", respone.data.employee);
                $('#employee-task-profile').css('color',"#00563F");
                $('#deadline-task-profile').attr("value", respone.data.deadline);
                $('#deadline-time-task-profile').attr("value", respone.data.deadtime);
                $('#describe-task-profile').attr("placeholder", respone.data.describ);
                $('#feedback-task-profile').attr("placeholder", respone.data.feedback);
                param_value = [respone.data.id, respone.data.file];

                let string = respone.data.file.split('//');
                if (string.length > 1){
                    $('#file-task-profile').append(`<label class='task-label'>Tệp đính kèm</label><br>`);
                    for ($i = 0; $i < string.length; $i++){
                        $('#file-task-profile').append(`<a class='task-label' href='task_data/${string[$i]}'>${string[$i]}\n</a><br>`)
                    }
                }
                if(respone.data.process === "task-new") {
                    $('#name-task-profile').removeAttr('disabled');
                    $('#task-button').append(`<button id='cancel-task-btn' class='btn btn-logout' onclick='cancel_task(${respone.data.id})'>Hủy Bỏ</button>
                        <button id='change-task-btn' class='btn btn-success btn-login' onclick='update_task(${respone.data.id})'>Cập nhật</button>
                    `);
                }
                if(respone.data.process === "task-waiting"){
                    $('#rating-task-lv').removeAttr('disabled');
                    $('#rating-task-div').show();
                    $('#rating-task-complete').show();
                    $('#rating-task').css('color',"#00563F");
                    $('#deadline-task-div').hide();
                    $('#deadtine-task-div').hide();
                    $('#describe-task-div').hide();
                    $('#task-button').append(`<button id='rating-task-btn' class='btn btn-success btn-login' onclick='rating_task(param_value)'>Đánh giá</button>
                    `);
                }
                if(respone.data.process === "task-complete") {
                    $('#deadline-task-div').hide();
                    $('#deadtine-task-div').hide();
                    $('#describe-task-div').hide();
                    $('#rating-task-complete').show();
                    $('#rating-task-lv').attr('disabled','disabled');
                    $('#rating-task-complete select').val(respone.data.rating);
                }
                if(respone.data.process === "task-rejected") {

                }
            }
        }
    });
}

function cancel_task(id){
    if (confirm('Thực hiện hủy tác vụ này?')) {
        let data = new FormData();
        data.append("id", id);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/Finalproject/API/cancel-task.php", true);
        xhr.send(data);
        $('#profile-task-dialog').modal('toggle');
        loadTask();
    }
}

function update_task(id){
    let data = new FormData();
    data.append("id-task", id);
    data.append("name-task", $('#name-task-profile').val());
    data.append("deadline-task", $('#deadline-task-profile').val());
    data.append("deadtime-task", $('#deadline-time-task-profile').val());
    data.append("describ-task", $('#describe-task-profile').val());
    if (confirm('Thực hiện cập nhật tác vụ?')) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/Finalproject/API/update-task.php", true);
        xhr.send(data);
        xhr.onload = function (e){
            let result = JSON.parse(this.response);
            if (result.code === 0){
                $('#profile-task-dialog').modal('toggle');
                loadTask()
            }
            else {
                $('#add-task-error-profile').html(result.message)
                $('#add-task-error-profile').fadeIn()
                $('#add-task-error-profile').fadeOut(3000)
                $('#name-task-profile').focus();
            }
        }

    }
}

function rating_task(param_value){
    id = param_value[0]
    file_old = param_value[1]
    alert(file_old)
    let data = new FormData();
    data.append("id-task", id);
    let $rating_choose = $('#rating-task').val();
    if ($rating_choose === "task-complete"){
        data.append("rating-task", $('#rating-task-lv').val());
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/Finalproject/API/complete-task.php", true);
        xhr.send(data);
        $('#profile-task-dialog').modal('toggle');
        loadTask();
    }
    else {
        data.append("file-old", file_old);
        data.append("deadline-task", $('#deadline-task-profile').val());
        data.append("deadtime-task", $('#deadline-time-task-profile').val());
        data.append("describ-task", $('#describe-task-profile').val());
        for ($i = 0; $i < $('#file-task-response').prop("files").length; $i++){
            data.append("file-task[]", $('#file-task-response').prop("files")[$i])
        }
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/Finalproject/API/reject-task.php", true);
        xhr.send(data);
        xhr.onload = function (e){
            let result = JSON.parse(this.response);
            if (result.code === 0){
                $('#profile-task-dialog').modal('toggle');
                loadTask()
            }
            else {
                $('#add-task-error-profile').html(result.message)
                $('#add-task-error-profile').fadeIn()
                $('#add-task-error-profile').fadeOut(3000)
            }
        }
    }

}

function rating_task_check(){
    let $rating_choose = $('#rating-task').val();
    if ($rating_choose === "task-complete"){
        $('#rating-task').css('color',"#00563F");
        $('#rating-task-complete').show();
        $('#rating-task-file').hide();
        $('#deadline-task-div').hide();
        $('#deadtine-task-div').hide();
        $('#describe-task-div').hide();
    }
    else {
        $('#rating-task-complete').hide();
        $('#rating-task').css('color',"#BB061C");
        $('#rating-task-file').show();
        $('#rating-task-file').show();
        $('#deadline-task-div').show();
        $('#deadtine-task-div').show();
        $('#describe-task-div').show();
    }
}


// Function to get list of employee
function loadEmployee() {
    $.ajax({
        url: "http://localhost:8888/FinalProject-Web/API/get-Employees.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#list-employee .management-item').remove();
            data.data.forEach(employee => {
                let employeeRow = $(`
                <div class="management-item" onclick="getEmployee(this)">
                    <div class="row">
                        <img class="avatar dot-work" src="avatar/${employee.avatar}">
                        <div style="flex: 1;">
                            <a class="task">${employee.name}</a>
                            <div class="task-box">
                                <a class="task text-decoration-none" style="color: var(--dark-green)">Phòng ban: ${employee.department}</a><br>
                            </div>
                        </div>
                        <div class="resetpass" href="#" onclick="resetPass(this)">ResetPassword</div>
                    </div>
                </div>
                `)
                employeeRow.attr('user',JSON.stringify(employee.username))
                $('#list-employee').append(employeeRow)
            });
        }
      });
}


let check = false;

document.addEventListener("click", (evt) => {
    const flyoutElement = document.getElementById("user-info");
    let targetElement = evt.target; // clicked element  
    do {
        if (targetElement == flyoutElement) {
            // This is a click inside.
            if (!check) {
                check = true;
                document.getElementsByClassName("navbar-user-list")[0].style.display = 'block';
                return;
            }
            else if (check) {
                check = false;
                document.getElementsByClassName("navbar-user-list")[0].style.display = 'none';
                return;
            }
        }
        // Go up the DOM
        targetElement = targetElement.parentNode;
    } while (targetElement);
    
    // This is a click outside.
    check = false;
    document.getElementsByClassName("navbar-user-list")[0].style.display = 'none';
});

