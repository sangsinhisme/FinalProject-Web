// Onload window event
window.onload = function() {
    if (window.location.href.indexOf('manageAccount.php') > -1) {
        loadEmployee()

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
            })
        });

    }
    
}

// Function reset add employee dialog
function resetAddEmployee() {
    $('#add-employee-error').hide()
    $('#username').val("") ,
    $('#name').val("") ,
    $('input[name=gender]').val(""),
    $('#phone').val(""),
    $('#mail').val(""),
    $('#position').val(""),
    $('#department').val("")
}

// Function reset add department dialog
function resetAddDepartment() {
    $('#add-department-error').hide()
    $('#department-name').val(''),
    $('#describe-department').val(''),
    $('#number-room').val('')
}

/* Set the width of the side navigation to 250px */
function openNav() {
    document.getElementById("mySidenav").style.width = "310px";
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