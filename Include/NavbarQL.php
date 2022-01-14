
<nav class="navbar navbar-expand-lg border-bottom border-gray">
    <div class="navbar-child order-0 mr-auto">
        <div class="navbar-nav">
            <div class="nav-item department">
                <span id="pointer" class="pointer" onclick="openNav()">&#9776;</span>
                <a><?= 'Phòng ' . $_SESSION['department'] ?? 'Phòng Kiểm Thử Phần Mềm' ?><br/></a>
            </div>
        </div>
    </div>
    <ul id="primary-navigation" data-visible="false" class="primary-navigation flex navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="./manageAccount.php"> Quản lý nhân viên  </a></li>
        <li class="nav-item"><a class="nav-link" href="./manageDepartment.php"> Quản lý phòng ban </a></li>
        <li class="nav-item"><a class="nav-link" href="./manageAbsence.php"> Quản lý nghỉ phép </a></li>
    </ul>

    <div class="navbar-child mx-auto">
        <div id ="user-info" >
            <img class="avatar" src="avatar/<?= isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '' ?>">
            <span class = "topbar_name"><?= isset($_SESSION['user']) ? $_SESSION['user'] : 'Undefine' ?></span>
            <div class="navbar-user-list">
                <a class = "navbar-user-item" href="./profile.php">Tài khoản của tôi</a>
                <a class = "navbar-user-item" href="#">Nhắn tin</a>
                <a class = "navbar-user-item" href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </div>
</nav>
