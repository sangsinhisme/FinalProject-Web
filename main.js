// Onload window event
window.onload = function() {
    if (window.location.href.indexOf('manageAccount.php') > -1) {
        loadEmployee()
        // Search function
        $('#search-input').on('change', function () {
            $.ajax({
                url: "./API/search-Employee.php",
                type: "get", //send it through get method
                dataType: "json",
                data: { 
                    name: $('#search-input').val(),
                },
                success: function(data) {
                    $('#list-employee .management-item').remove();
                    data.data.forEach(employee => {
                        let employeeRow = $(`
                        <div class="management-item">
                            <div class="row">
                                <img class="avatar dot-work" src="avatar/${employee.avatar}">
                                <div style="flex: 1;">
                                    <a class="task">${employee.name}</a>
                                    <div class="task-box">
                                        <a class="task text-decoration-none" style="color: var(--dark-green)">Phòng ban: ${employee.department}</a><br>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <a class="btn btn-info border" style="color:white" onclick="getEmployee(this)">
                                        <i class="fas fa-user"></i>
                                    </a>   
                                    <a class="btn btn-success border" style="color:white" onclick= "resetPass(this)">
                                        <i class="fas fa-redo"></i>
                                    </a>  
                                </div>
                            </div>
                        </div>
                        `)
                        employeeRow.attr({
                                'id':JSON.stringify(employee.id),
                                'user':JSON.stringify(employee.username)
                            })
                        $('#list-employee').append(employeeRow)
                    });
                }
              });
        });

        $("#add-employee-btn").click(function () {
            $('#new-employee-dialog').modal({show: true});
            resetAddEmployee()
            $('#confirm-add').unbind().click(function () {
<<<<<<< HEAD
            $.ajax({
                    url: "./API/add-Employee.php",
                    type: "post", //send it through get method
                    contentType: 'application/json',
                    dataType: "json",
                    data: JSON.stringify({
                        username: $('#username').val() ,
                        name: $('#name').val() ,
                        gender: $('input[name=gender]').val(),
                        phone: $('#phone').val(),
                        mail: $('#mail').val(),
                        position: $('#position').val(),
                        department: $('#department').val()
                    }),
                    success: function(respone) {
                        if (respone.code == 0) {
                            $('#new-employee-dialog').modal('toggle');
                            loadEmployee()
=======
            if (validateAddEmployeeForm()) {
                    $.ajax({
                        url: "./API/add-Employee.php",
                        type: "post", //send it through get method
                        contentType: 'application/json',
                        dataType: "json",
                        data: JSON.stringify({ 
                            username: $('#username').val() ,
                            name: $('#name').val() ,
                            gender: $('input[name="genderEmployee"]:checked').val(),
                            phone: $('#phone').val(),
                            mail: $('#mail').val(),
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
>>>>>>> 7c347242a93b7e22a8b889db5d06bd339f0f82e1
                        }
                    });
                }
            })
        });
    }

    /* task index */
    if (window.location.href.indexOf('index.php') > -1) {
        loadTask('task-canceled');
    }

    /* task index */
    if (window.location.href.indexOf('index-ql.php') > -1) {
        loadTask('')
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
                xhr.open("POST", "./API/add-task.php", true);
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

    // manage manager Absence
    if (window.location.href.indexOf('manageAbsence.php') > -1) { 
        loadmanagerAbsence()
    }

    // manage Employee Absence
    if (window.location.href.indexOf('manageEmployee.php') > -1) { 
        loademployeeAbsence()
    }

    /* manager absence */
    if (window.location.href.indexOf('managerAbsence.php') > -1) {
        loadAbsence()
        $("#add-absence-btn").click(function () {
            $('#add-absence-error').hide()
            $('#new-absence-dialog').modal({show: true});
            $('#confirm-add-absence').click(function () {
                if (validateAddAbsenceForm()) {
                    let data = new FormData();
                    data.append("dayoff", $('#number-day-off').val());
                    data.append("reason", $('#reason-absence').val());
                    for ($i = 0; $i < $('#document-absence').prop("files").length; $i++){
                        data.append("file-task[]", $('#document-absence').prop("files")[$i])
                    }
    
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "./API/request-Absence.php", true);
                    xhr.send(data);
                    
                    xhr.onload = function (e){
                        let result = JSON.parse(this.response); 
                        if (result.code === 0){
                            document.getElementById("absence-form").reset();
                            $('#new-absence-dialog').modal('toggle');
                            loadAbsence()
                        }
                        else {
                            $('#add-absence-error').html(result.message).show()
                        }
                    }
                }
            })
        });

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    }

    // ManageDepartment
    if (window.location.href.indexOf('manageDepartment.php') > -1) {
        loadDepartment()

        $('#show-department-manager').on('change', function() {
            if(this.value == 1) {
                loadDepartment()
            }
            else {
                loadManager()
            }
        });

        $("#add-department-btn").click(function () {
            $('#new-department-dialog').modal({show: true});
            resetAddDepartment()
            $('#confirm-add-department').unbind().click(function () {
            if (validateAddDepartmentForm()) {
                $.ajax({
                    url: "./API/add-Department.php",
                    type: "post", //send it through get method
                    contentType: 'application/json',
                    dataType: "json",
                    data: JSON.stringify({ 
                        name: $('#department-name').val(),
                        description: $('#describe-department').val(),
                        room: $('#number-room').val()
                    }),
                    success: function(respone) {
                        if (respone.code == 0) {
                            $('#new-department-dialog').modal('toggle');
                            loadDepartment()
                        }
                        else {
                            $('#add-department-error').show()
                            $('#add-department-error').html(respone.message)
                        }
                    }
                });
            }
            })
        });

    }
    
}

// Validate add employee form
function validateAddEmployeeForm() {
    let usernameRegex = /^[a-z0-9_-]{6,20}$/;
    let checkUsername = document.getElementById("username").value.trim();
    let checkName = document.getElementById("name").value;
    let phone = $('#phone').val()
    let mail = $('#mail').val()
    let position = $('#position').val()
    let department = $('#department').val()

    if (checkUsername.length === 0 && checkName.length === 0) {
       $('#add-employee-error').html("Vui lòng nhập đầy đủ thông tin").show()
       return false
    }else if(checkUsername.length === 0){
        $('#add-employee-error').html("Vui lòng điền tên đăng nhập").show()
        return false
    }else  if(!checkUsername.match(usernameRegex)){
        $('#add-employee-error').html("Tên đăng nhập không hợp lệ").show()
        return false
    }else if (checkName.length === 0){
        $('#add-employee-error').html("Vui lòng nhập họ và tên nhân viên").show()
        return false
    }else if(!$('.genderEmploy').is(':checked')){
        $('#add-employee-error').html("Vui lòng chọn giới tính").show()
        return false
    }else if(phone.length === 0){
        $('#add-employee-error').html("Vui lòng điền số điện thoại").show()
        return false
    }else if(mail.length === 0){
        $('#add-employee-error').html("Vui lòng điền email").show()
        return false
    }else if(position == undefined){
        $('#add-employee-error').html("Vui lòng chọn vị trí").show()
        return false
    }else if(department == undefined){
        $('#add-employee-error').html("Vui lòng chọn phòng ban").show()
        return false
    }
    return true
}

// Validate add absent form
function validateAddAbsenceForm() {
    let dayoff = $('#number-day-off').val()
    let reason = $('#reason-absence').val()

    if(dayoff.length === 0){
        $('#add-absence-error').html("Vui lòng điền số ngày nghỉ").show()
        return false
    }else if (reason.length === 0){
        $('#add-absence-error').html("Vui lòng nhập lí do").show()
        return false
    }
    return true
}

// Validate add department form
function validateAddDepartmentForm() {
    let name = $('#department-name').val()
    let descripe = $('#describe-department').val()
    let room = $('#number-room').val()

    if(name.length === 0){
        $('#add-department-error').html("Vui lòng điền tên phòng ban").show()
        return false
    }else if (descripe.length === 0){
        $('#add-department-error').html("Vui lòng nhập mô tả").show()
        return false
    }else if (room.length === 0){
        $('#add-department-error').html("Vui lòng nhập số phòng").show()
        return false
    }
    return true
}

// Function reset add employee dialog
function resetAddEmployee() {
    $('#add-employee-error').hide()
    $('#username').val("") 
    $('#name').val("") 
    //$('.genderEmploy').val("")
    $('input[name="genderEmployee"]:checked').prop('checked', false)
    $('#phone').val("")
    $('#mail').val("")
    $('#position').val("")
    $.ajax({
        url: "./API/get-Departments.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#department .department-option').remove();
            if (data.status == true) {
                data.data.forEach(department => {
                    $('#department').append(`<option class="department-option" value="${department.departmentName}">${department.departmentName}</option>`);
                });
            }
            else {
                $('#add-employee-error').html("Không thể load các phòng").show()
            }
        }
    });
    $('#department').val("")
}

// Function reset add department dialog
function resetAddDepartment() {
    $('#add-department-error').hide()
    $('#department-name').val('')
    $('#describe-department').val('')
    $('#number-room').val('')
}

/* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
}

/* Set the width of the side navigation to 0 */
function closeNav(){
    document.getElementById("mySidenav").style.width = "0px";
}

// Function get employee info
function getEmployee(e) {
    let user = $(e.parentNode.parentNode.parentNode).attr('id')
    let selecteduser= JSON.parse(user)
    $('#info-employee-dialog').modal({show: true});
    $.ajax({
        type: "GET",
        url: "./API/get-Employee.php?" + $.param({
            "id": selecteduser
        }),
        success: function(respone) {
            if (respone.code == 0) {
                $('.employee-info').html(respone.data.username)
                $('.employee-info-username').html(respone.data.username)
                $('.employee-info-name').html(respone.data.name)
                $('.employee-info-gender').html(respone.data.gender)
                $('.employee-info-phone').html(respone.data.phone)
                $('.employee-info-mail').html(respone.data.mail)
                $('.employee-info-position').html(respone.data.position)
                $('.employee-info-department').html(respone.data.department)
                $("#employee-avatar").attr("src",`./avatar/${respone.data.avatar}`);
            }
        }
    });
}

// Function get Absence report
function getAbsence(e) {
    let absence = $(e).attr('id')
    let selectedAbsence= JSON.parse(absence)
    let color = ''
    $('#info-absence-dialog').modal({show: true});
    $.ajax({
        type: "GET",
        url: "./API/get-userAbsence.php?" + $.param({
            "id": selectedAbsence
        }),
        success: function(respone) {
            if (respone.code == 0) {
                if (respone.data.status == 'waiting') {
                    color = '#107baf'
                }
                else if (respone.data.status == 'approved') {
                    color = 'green'
                }
                else {
                    color = 'red'
                }
                $('.dayoff').html(respone.data.dayAbsence)
                $('#reason-user-absence').html(respone.data.reason)
                $('#file-absence').html(respone.data.file)
                $('#file-absence').attr({
                    "href":"./file_absence/"+respone.data.file,
                    "download" : respone.data.file
                })
                $('.status-report').html(respone.data.status)
                $(".status-report").css("color", color)
                $('.report-date').html(respone.data.date)
            }
        }
    });
}

// Function to approve absence
function confirmApproved(e) {
    let absence = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedAbsence= JSON.parse(absence)
    $('#approved-dialog').modal('show')
    $('.user-absence').html(selectedAbsence.username)
    $('#confirm-approve').click(function() {
        $.ajax({
            type: "GET",
            url: "./API/approve-Absence.php",
            data: {
                id : selectedAbsence.id,
                username: selectedAbsence.username
            },
            success: function(respone) {
                if (respone.code == 0) {
                    $('#approved-dialog').modal('toggle')
                    loadmanagerAbsence()
                }
                else {
                    $('#approve-absence-error').html(respone.message).show()
                }
            }
        });
    })
}


// Function to approve absence for employee
function employeeApproved(e) {
    let absence = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedAbsence= JSON.parse(absence)
    $('#approve-absence-error').hide()
    $('#approved-dialog').modal('show')
    $('.user-absence').html(selectedAbsence.username)
    $('#confirm-approve').click(function() {
        $.ajax({
            type: "GET",
            url: "./API/approve-Absence.php",
            data: {
                id : selectedAbsence.id,
                username: selectedAbsence.username
            },
            success: function(respone) {
                if (respone.code == 0) {
                    $('#approved-dialog').modal('toggle')
                    loademployeeAbsence()
                }
                else {
                    $('#approve-absence-error').html(respone.message).show()
                }
            }
        });
    })
}

// Function to refuse absence
function confirmRefused(e) {
    let absence = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedAbsence= JSON.parse(absence)
    $('#refused-dialog').modal('show')
    $('.user-absence').html(selectedAbsence.username)
    $('#confirm-refused').click(function() {
        $.ajax({
            type: "GET",
            url: "./API/refuse-Absence.php",
            data: {
                id : selectedAbsence.id,
            },
            success: function(respone) {
                if (respone.code == 0) {
                    $('#refused-dialog').modal('toggle')
                    loadmanagerAbsence()
                }
                else {
                    $('#approve-absence-error').html(respone.message).show()
                }
            }
        });
    })
}

// Function to refuse absence employee
function employeeRefused(e) {
    let absence = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedAbsence= JSON.parse(absence)
    $('#refused-dialog').modal('show')
    $('.user-absence').html(selectedAbsence.username)
    $('#confirm-refused').click(function() {
        $.ajax({
            type: "GET",
            url: "./API/refuse-Absence.php",
            data: {
                id : selectedAbsence.id,
            },
            success: function(respone) {
                if (respone.code == 0) {
                    $('#refused-dialog').modal('toggle')
                    loademployeeAbsence()
                }
                else {
                    $('#approve-absence-error').html(respone.message).show()
                }
            }
        });
    })
}

// Function get manager absence report
function getManagerAbsence(e) {
    let absence = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedAbsence= JSON.parse(absence)
    $('#absence-manager-dialog').modal({show: true});
    $.ajax({
        type: "GET",
        url: "./API/get-managerAbsence.php",
        data: {
            id : selectedAbsence.id,
            username: selectedAbsence.username
        },
        success: function(respone) {
            if (respone.code == 0) {
                $('.absence-info').html(selectedAbsence.username)
                $('.manager-absence-name').html(respone.data.name)
                $('.manager-absence-department').html(respone.data.department)
                $('.dayoff').html(respone.data.dayAbsence)
                $('#reason-user-absence').html(respone.data.reason)
                $('#file-absence').html(respone.data.file)
                $('#file-absence').attr({
                    "href":"./file_absence/"+respone.data.file,
                    "download" : respone.data.file
                })
                $('.report-date').html(respone.data.date)
            }
            else if (respone.code == 2) {
                $('.absence-info').html('')
                $('.manager-absence-name').html('')
                $('.manager-absence-department').html('')
                $('.dayoff').html(respone.data.dayAbsence)
                $('#reason-user-absence').html(respone.data.reason)
                $('#file-absence').html(respone.data.file)
                $('#file-absence').attr({
                    "href":"./file_absence/"+respone.data.file,
                    "download" : respone.data.file
                })
                $('.report-date').html(respone.data.date)
            }
        }
    });
}

// Function get department info
function getDepartment(e) {
    let department = $(e.parentNode.parentNode.parentNode).attr('data')
    let selecteddepartment= JSON.parse(department)
    $('#info-department-dialog').modal({show: true});
    $.ajax({
        type: "GET",
        url: "./API/get-Department.php?" + $.param({
            "id": selecteddepartment.id
        }),
        success: function(respone) {
            if (respone.code == 0) {
                $('.department-info').html(respone.data.departmentName)
                $('.department-info-username').html(respone.data.departmentName)
                $('#describe-department-info').html(respone.data.description)
                $('.department-info-room').html(respone.data.room)
                $('.department-info-manager').html(respone.data.name)
                $('.department-info-phone').html(respone.data.phone)
                $('.department-info-mail').html(respone.data.mail)
            }
            else if (respone.code == 2) {
                $('.department-info').html(respone.data.departmentName)
                $('.department-info-username').html(respone.data.departmentName)
                $('#describe-department-info').html(respone.data.description)
                $('.department-info-room').html(respone.data.room)
                $('.department-info-manager').html('')
                $('.department-info-phone').html('')
                $('.department-info-mail').html('')
            }
        }
    });
}

// Function update department
function updateDepartment(e) {
    $('#update-department-dialog').modal('show');
    let department = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectDepartment= JSON.parse(department)
    $('#department-update-info').html(selectDepartment.departmentName)
    $('#update-department-name').val(selectDepartment.departmentName)
    $('#update-describe-department').val(selectDepartment.description)
    $('#update-number-room').val(selectDepartment.room)
    $('#confirm-update-department').unbind().click(function() {
        $.ajax({
            type: "PUT",
            url: "./API/update-Department.php?" + $.param({
                "id": selectDepartment.id
            }),
            data: JSON.stringify({ 
                name: $('#update-department-name').val(),
                description: $('#update-describe-department').val(),
                room: $('#update-number-room').val(),
            }),
            success: function(respone) {
                if (respone.code == 0) {
                    $('#update-department-dialog').modal('toggle');
                    loadDepartment() 
                }
                else {
                    $('#update-department-error').show()
                    $('#update-department-error').html(respone.message)
                }
                
            }
        });
    })
}

// Function dimiss a manager
function dimissManager(e) {
    $('#dimiss-manager-dialog').modal({show: true});
    let department = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedDepartment = JSON.parse(department)
    $('#dismiss-manager-error').hide()
    $('.manager-username').html(selectedDepartment.manager)
    $('.department-dismiss').html(selectedDepartment.departmentName)
    //console.log(selectedDepartment)
    $('#confirm-dimiss-manager').unbind().click(function() {
        $.ajax({
            url: "./API/dismiss-Manager.php",
            type: "GET",
            data: { 
                id: selectedDepartment.id,
                user: selectedDepartment.manager
            },
            success: function(respone) {
                if (respone.code == 0) {
                    $('#dimiss-manager-dialog').modal('toggle');
                    loadManager()
                }
                else {
                    $('#dismiss-manager-error').show()
                    $('#dismiss-manager-error').html(respone.message)
                } 
            }
        });
    })
}

// Function appoint an emloyee to manager
function appointManager(e) {
    $('#new-manager-dialog').modal({show: true});
    $('#manager-name').val("")
    $('#add-manager-error').hide()
    let department = $(e.parentNode.parentNode.parentNode).attr('data')
    let selectedDepartment= JSON.parse(department)
    //console.log(selectedDepartment)
    $('#confirm-add-manager').unbind().click(function() {
        $.ajax({
            type: "POST",
            url: "./API/appoint-Manager.php",
            data: JSON.stringify({ 
                username: $('#manager-name').val(),
                department: selectedDepartment.id
            }),
            success: function(respone) {
                if (respone.code == 0) {
                    $('#new-manager-dialog').modal('toggle');
                    loadManager()
                }
                else {
                    $('#add-manager-error').show()
                    $('#add-manager-error').html(respone.message)
                }
                
            }
        });
    })
}

// Function reset password
function resetPass(e) {
    $('#reset-password-dialog').modal('show');
    let user = $(e.parentNode.parentNode.parentNode).attr('user')
    let selecteduser= JSON.parse(user)
    $('.reset-user').html(selecteduser) 
    $('.resetpass-btn').unbind().click(function () {
        $.ajax({
            type: "GET",
            url: "./API/reset-Password.php?" + $.param({
                "id": selecteduser
            }),
            success: function(respone) {
                if (respone.code == 0) {
                    $('#reset-password-dialog').modal('toggle');
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
let task_convert = {"task-new": "Tác vụ mới", "task-progress" : "Tác vụ đang thực hiện", "task-waiting" : "Tác vụ đang chờ",
"task-rejected": "Tác vụ đã từ chối", "task-complete" : "Tác vụ đã hoàn thành", "task-canceled" : "Tác vụ đã hủy"};

function count_task(process){
    if (process === "task-new") count_task_number[0] += 1;
    if (process === "task-progress") count_task_number[1] += 1;
    if (process === "task-waiting") count_task_number[2] += 1;
    if (process === "task-rejected") count_task_number[3] += 1;
    if (process === "task-complete") count_task_number[4] += 1;
    if (process === "task-canceled") count_task_number[5] += 1;
}

function loadTask(role_show){
    $.ajax({
        url: "./API/get-task-index.php",
        type: "get",
        dataType: "json",
        success: function(data) {
            $('#task-list .management-item').remove();
            data.data.forEach(task => {
                    count_task(task.process)
                    if (task.process !== role_show){
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
                        taskRow.attr('role', role_show)
                        $('#task-list').prepend(taskRow)
                    }
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
    let role = $(e).attr('role')
    $('#profile-task-dialog').modal({show: true});
    $.ajax({
        type: "GET",
        url: "./API/get-task-byID.php?" + $.param({
            "id": selectedTask
        }),
        success: function(respone) {
            if (respone.code == 0) {

                $('#file-task-profile .task-label').remove();
                $('#file-task-profile br').remove();
                $('#file-response-task-profile .task-label').remove();
                $('#file-response-task-profile br').remove();
                $('#task-button .btn').remove();

                $('#rating-task-complete').hide();
                $('#rating-task-div').hide();
                $('#rating-task-file').hide();
                $('#submit-task-file').hide();
                $('#response-task-div').hide();
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
                $('#response-task-profile').attr("placeholder", respone.data.feedback);
                param_value = [respone.data.id, respone.data.file];

                let string = respone.data.file.split('//');
                let string_2 = respone.data.file_submit.split('//') ;

                if (string.length > 0 && respone.data.file !== ''){
                    $('#file-task-profile').append(`<label class='task-label'>Tệp đính kèm</label><br>`);
                    for ($i = 0; $i < string.length; $i++){
                        $('#file-task-profile').append(`<a class='task-label' style='color: var(--dark-green)'   href='task_data/${string[$i]}'>${string[$i]}\n</a><br>`)
                    }
                }
                if (string_2.length > 0  && respone.data.file_submit !== ''){
                    $('#file-response-task-profile').append(`<label class='task-label'>Tệp submit</label><br>`);
                    for ($i = 0; $i < string_2.length; $i++){
                        $('#file-response-task-profile').append(`<a class='task-label' style='color: var(--dark-green)'  href='task_data/${string_2[$i]}'>${string_2[$i]}\n</a><br>`)
                    }
                }

                if(respone.data.process === "task-new") {
                    if (role === ''){
                        $('#deadline-time-task-profile').removeAttr('disabled');
                        $('#deadline-task-profile').removeAttr('disabled');
                        $('#describe-task-profile').removeAttr('disabled');
                        $('#name-task-profile').removeAttr('disabled');
                        $('#task-button').append(`<button id='cancel-task-btn' class='btn btn-logout' onclick='cancel_task(${respone.data.id})'>Hủy Bỏ</button>
                        <button id='change-task-btn' class='btn btn-success btn-login' onclick='update_task(${respone.data.id})'>Cập nhật</button>
                    `);
                    }
                    else {
                        if (respone.data.describ === ""){
                            $('#describe-task-div').hide();
                        }
                        $('#task-button').append(`<button id='change-task-btn' class='btn btn-success btn-login'
                                                         onClick='progress_task(${respone.data.id})'>Nhận tác vụ</button>`
                        );
                    }
                }
                if(respone.data.process === "task-progress"){
                    $('#deadline-time-task-profile').attr('disabled','disabled');
                    $('#deadline-task-profile').attr('disabled','disabled');
                    $('#describe-task-profile').attr('disabled','disabled');
                    if (role !== ''){
                        $('#submit-task-file').show();
                        $('#response-task-div').show();
                        $('#task-button').append(`<button id='change-task-btn' class='btn btn-success btn-login'
                                                         onClick='submit_task(${respone.data.id})'>Gửi tác vụ</button>`
                        )
                    }
                }
                if(respone.data.process === "task-waiting"){
                    if (respone.data.feedback !== ""){
                        $('#response-task-div').show();
                    }
                    if (respone.data.describ === ""){
                        $('#describe-task-div').hide();
                    }
                    if (role === ''){
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
                    if (respone.data.describ === ""){
                        $('#describe-task-div').hide();
                    }
                    if (role !== ''){
                        $('#submit-task-file').show();
                        $('#response-task-div').show();
                        $('#task-button').append(`<button id='change-task-btn' class='btn btn-success btn-login'
                                                         onClick='submit_task(${respone.data.id})'>Gửi tác vụ</button>`
                        )
                    }
                }
            }
        }
    });
}

function submit_task(id){
    let data = new FormData();
    data.append("id-task", id);
    data.append("feedback-task", $('#response-task-profile').val())
    for ($i = 0; $i < $('#submit-task-response').prop("files").length; $i++){
        data.append("file-task[]", $('#submit-task-response').prop("files")[$i])
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./API/submit-task.php", true);
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

function cancel_task(id){
    if (confirm('Thực hiện hủy tác vụ này?')) {
        let data = new FormData();
        data.append("id", id);
        data.append("process", "task-canceled")
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./API/cancel-task.php", true);
        xhr.send(data);
        $('#profile-task-dialog').modal('toggle');
        loadTask();
    }
}

function progress_task(id){
    if (confirm('Thực hiện nhận tác vụ này?')) {
        let data = new FormData();
        data.append("id", id);
        data.append("process", "task-progress")
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./API/cancel-task.php", true);
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
        xhr.open("POST", "./API/update-task.php", true);
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
    let data = new FormData();
    data.append("id-task", id);
    let $rating_choose = $('#rating-task').val();
    if ($rating_choose === "task-complete"){
        data.append("rating-task", $('#rating-task-lv').val());
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./API/complete-task.php", true);
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
        xhr.open("POST", "./API/reject-task.php", true);
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
        $('#deadline-time-task-profile').removeAttr('disabled');
        $('#deadline-task-profile').removeAttr('disabled');
        $('#describe-task-profile').removeAttr('disabled');
    }
}


// Function to get list of employee
function loadEmployee() {
    $.ajax({
        url: "./API/get-Employees.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#list-employee .management-item').remove();
            data.data.forEach(employee => {
                let employeeRow = $(`
                <div class="management-item">
                    <div class="row">
                        <img class="avatar dot-work" src="avatar/${employee.avatar}">
                        <div style="flex: 1;">
                            <a class="task">${employee.name}</a>
                            <div class="task-box">
                                <a class="task text-decoration-none" style="color: var(--dark-green)">Phòng ban: ${employee.department}</a><br>
                            </div>
                        </div>
                        <div class="m-3">
                            <a class="btn btn-info border" style="color:white" onclick="getEmployee(this)">
                                <i class="fas fa-user"></i>
                            </a>   
                            <a class="btn btn-success border" style="color:white" onclick= "resetPass(this)">
                                <i class="fas fa-redo"></i>
                            </a>  
                        </div>
                    </div>
                </div>
                `)
                employeeRow.attr({
                        'id':JSON.stringify(employee.id),
                        'user':JSON.stringify(employee.username)
                    })
                $('#list-employee').append(employeeRow)
            });
        }
      });
}

// Function to get list of deparment
function loadDepartment() {
    $.ajax({
        url: "./API/get-Departments.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#list-department .management-item').remove();
            data.data.forEach(department => {
                let departmentRow = $(`
                <div class="management-item">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Phòng:</b> ${department.departmentName}</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Số phòng:</b> ${department.room}</a>
                            </div>
                        </div>
                        <div class="m-3">
                            <a class="btn btn-info border" style="color:white" onclick="getDepartment(this)">
                                <i class="fas fa-user"></i>
                            </a>   
                            <a class="btn btn-success border" style="color:white" onclick= "updateDepartment(this)">
                                <i class="fas fa-edit"></i>
                            </a>  
                        </div>
                    </div>
                </div>
                `)
                departmentRow.attr('data',JSON.stringify(department))
                $('#list-department').append(departmentRow)
            });
        }
      });
}

// Function to get list of manager
function loadManager() {
    $.ajax({
        url: "./API/get-Departments.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#list-department .management-item').remove();
            data.data.forEach(department => {
                let departmentRow = $(`
                <div class="management-item">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Phòng:</b> ${department.departmentName}</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Trưởng phòng:</b> ${department.manager}</a>
                            </div>
                        </div>
                        <div class="mx-3">
                            <button onclick="appointManager(this)" type="button" class="btn btn-outline-success" style="display: block;padding-right: 15px;margin-bottom: 10px;">Bổ nhiệm</button>
                            <button onclick="dimissManager(this)" type="button" class="btn btn-outline-danger">Bãi nhiệm</button>
                        </div>
                    </div>
                </div>
                `)
                departmentRow.attr('data',JSON.stringify(department))
                $('#list-department').append(departmentRow)
            });
        }
      });
}

// Function to get list of absences request
function loadAbsence() {
    let color = ''
    let icon = ''
    $.ajax({
        url: "./API/get-userAbsences.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#list-absence .management-item').remove();
            data.data.forEach(absence => {
                if (absence.status == 'waiting') {
                    color = '#107baf'
                    icon = '<i style="font-weight:bold;color:#107baf;margin-left: 5px;">...</i>'
                }
                else if (absence.status == 'approved') {
                    color = 'green'
                    icon = '<i style="color:green;margin-left: 5px;" class="fas fa-check-circle"></i>'
                }
                else {
                    color = 'red'
                    icon = '<i style="color:red;margin-left: 5px;" class="fas fa-times-circle"></i>'
                }
                let absenceRow = $(`
                <div class="management-item absence-report" onclick="getAbsence(this)">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Số ngày nghỉ:</b> ${absence.dayAbsence}</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Lí do:</b> ${absence.reason}</a>
                            </div>
                        </div>
                        <div class="m-3">
                            <p style="color:${color};margin: 0;font-size: 22px;font-weight: bold;text-transform:uppercase">${absence.status}${icon} </p>
                            
                        </div>
                    </div>
                </div>
                `)
                absenceRow.attr('id',JSON.stringify(absence.id))
                $('#list-absence').append(absenceRow)
            });
        }
      });
}

// Function to get list of absences manager request
function loadmanagerAbsence() {
    $.ajax({
        url: "./API/get-managerAbsences.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            $('#list-manager-absence .management-item').remove();
            data.data.forEach(absence => {
                let absenceRow = $(`
                <div class="management-item">
                    <div class="row">
                        <div style="flex: 1;margin-left: 20px">
                            <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Username:</b> ${absence.username}</a>
                            <div class="">
                                <a class="task text-decoration-none"><b style="color: var(--dark-green)">Ngày tạo:</b> ${absence.date}</a>
                            </div>
                        </div>
                        <div style="margin: 20px">
                            <a class="btn btn-primary border" style="color:white" onclick="getManagerAbsence(this)">
                                <i class="fas fa-info"></i>
                            </a>  
                            <a class="btn btn-success border" style="color:white" onclick="confirmApproved(this)">
                                <i class="fas fa-check"></i>
                            </a>   
                            <a class="btn btn-danger border" style="color:white" onclick= "confirmRefused(this)">
                                <i class="fas fa-times"></i>
                            </a>  
                        </div>
                    </div>
                </div>
                `)
                absenceRow.attr('data', JSON.stringify(absence))
                $('#list-manager-absence').append(absenceRow)
            });
        }
      });
}

// Function to get list of absences employee request
function loademployeeAbsence() {
    $.ajax({
        url: "./API/get-employeeAbsences.php", //Change your localhost link
        type: "get", //send it through get method
        dataType: "json",
        success: function(data) {
            if (data.status == true) {
                $('#list-manager-absence .management-item').remove();
                data.data.forEach(absence => {
                    let absenceRow = $(`
                    <div class="management-item">
                        <div class="row">
                            <div style="flex: 1;margin-left: 20px">
                                <a class="task" style="font-size: 25px;text-transform: uppercase"><b style="color: var(--dark-green)">Username:</b> ${absence.username}</a>
                                <div class="">
                                    <a class="task text-decoration-none"><b style="color: var(--dark-green)">Ngày tạo:</b> ${absence.date}</a>
                                </div>
                            </div>
                            <div style="margin: 20px">
                                <a class="btn btn-primary border" style="color:white" onclick="getManagerAbsence(this)">
                                    <i class="fas fa-info"></i>
                                </a>  
                                <a class="btn btn-success border" style="color:white" onclick="employeeApproved(this)">
                                    <i class="fas fa-check"></i>
                                </a>   
                                <a class="btn btn-danger border" style="color:white" onclick= "employeeRefused(this)">
                                    <i class="fas fa-times"></i>
                                </a>  
                            </div>
                        </div>
                    </div>
                    `)
                    absenceRow.attr('data', JSON.stringify(absence))
                    $('#list-manager-absence').append(absenceRow)
                });
            }
        }
      });
}

let check = false;
// Function open navbar-user-info
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



// Function to preview avatar
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#user-avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Function to upload avatar
function uploadAvatar() {
    if ($('#file-upload-avatar').get(0).files.length === 0) {
        $('#upload-avt-error').fadeIn(2000).fadeOut(3000)
    }
    else {
            let file_data = $('#file-upload-avatar').prop('files')[0];   
            let form_data = new FormData();                  
            form_data.append('file', file_data);                           
            $.ajax({
                url: './upload-avatar.php', // <-- point to server-side PHP script 
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(respone){
                        let res = JSON.parse(respone)
                        if (res.code == 0) {
                            $('#upload-success-dialog').modal('show');
                            $('#upload-success-dialog').on('hidden.bs.modal', function () {
                                $('.avatar').attr('src', './avatar/' + res.avatar);
                            })
                        }
                        else {
                            $('#upload-success-dialog').modal('show');
                            $('#upload-avt-icon').attr('src', './images/error-icon.png');
                            $('#upload-avt-descrip').html(res.message)
                        }
                }
            });
    }
    
}

// Function to repassword user
function resetUserPassword() {
    $('#reset-pass-dialog').modal('show')
    $('#confirm-repass').unbind().click(function () {
        if (validateRepassword()) {
            $.ajax({
                    url: "./API/change-Password.php",
                    type: "post", //send it through get method
                    contentType: 'application/json',
                    dataType: "json",
                    data: JSON.stringify({ 
                        oldpass: $('#oldpass').val() ,
                        newpass: $('#newpass').val() ,
                    }),
                    success: function(respone) {
                        if (respone.code == 0) {
                            $('#reset-pass-dialog').modal('toggle');
                            $('#reset-pass-success').fadeIn(3000).fadeOut(2000)
                        }
                        else {
                            $('#reset-pass-error').show()
                            $('#reset-pass-error').html(respone.message)
                        }
                    }
                });
        }
    })
}

// Function to validate repassword form
function validateRepassword() {
        let oldpass = $('#oldpass').val()
        let newpass = $('#newpass').val()
        let confirmpass = $('#confirmpass').val()
        if (oldpass.length == 0) {
            $('#reset-pass-error').html('Vui lòng điền mật khẩu cũ').show()
            return false
        }
        else if (newpass.length == 0) {
            $('#reset-pass-error').html('Vui lòng điền mật khẩu mới').show()
            return false
        }
        else if (confirmpass.length == 0) {
            $('#reset-pass-error').html('Vui lòng xác nhận mật khẩu').show()
            return false
        }
        else if(newpass !== confirmpass) {
            $('#reset-pass-error').html('Xác nhận mật khẩu mới không khớp').show()
            return false
        }
        return true
}

