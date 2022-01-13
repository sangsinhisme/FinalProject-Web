<nav class="navbar navbar-expand-lg border-bottom border-gray">
    <div class="navbar-child order-0">
        <ul class="navbar-nav">
            <li class="nav-item">
                <span id="pointer" class="pointer" onclick="openNav()">&#9776;</span>
            </li>
            <li class="nav-item department">
                <a>Phòng Ban Kiểm Thử Phần Mềm<br /></a>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="index.php"> Tình trạng công việc </a> </li>
        <li class="nav-item"><a class="nav-link" href="managerAbsence.php"> Danh sách nghỉ phép </a></li>
        <li class="nav-item"><a class="nav-link" href="manageEmployee.php"> Quản lý nhân viên </a></li>
    </ul>

    <div class="navbar-child mx-auto">
        <div id ="user-info" >
            <img class="avatar" src="images/male.svg">
            <span class = "topbar_name"><?= $_SESSION['user'] ?></span>
            <div class="navbar-user-list">
                <a class = "navbar-user-item" href="./profile.php">Tài khoản của tôi</a>
                <a class = "navbar-user-item" href="#">Nhắn tin</a>
                <a class = "navbar-user-item" href="./logout.php">Đăng xuất</a>
            </div>
        </div>
    </div>
</nav>
