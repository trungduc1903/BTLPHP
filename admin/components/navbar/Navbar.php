<!-- <?php
        ob_start();
        $page = "";
        if (isset($page)) {
            $page = $_GET["page"];
        }
        $isReportActive = str_contains($page, "report");
        $isUserAcvite = str_contains($page, "user");
        $isSubjectAcvite = str_contains($page, "subject");
        $isTeacherAcvite = str_contains($page, "teacher");
        $isClassAcvite = str_contains($page, "class");
        $isScoreAcvite = str_contains($page, "score");
        $isAboutAcvite = str_contains($page, "about");
        if (str_contains($page, "score_class")) {
            $isClassAcvite = false;
            $isScoreAcvite = true;
        }
        ?> -->
<div class="navbar-wrapper">
    <!-- user router -->
    <a href="?page=report">
        <div class="nav-item <?php if ($isReportActive) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-file-chart-line"></i>
            </span>
            Thống kê - tổng kết
        </div>
    </a>

    <a href="?page=user">
        <div class="nav-item <?php if ($isUserAcvite) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-user-friends"></i>
            </span>
            Quản lý nhân viên
        </div>
    </a>

    <a href="?page=subject">
        <div class="nav-item <?php if ($isSubjectAcvite) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-books"></i>
            </span>
            Danh sách môn học
        </div>
    </a>

    <a href="?page=teacher">
        <div class="nav-item <?php if ($isTeacherAcvite) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-chalkboard-teacher"></i>
            </span>
            Quản lý giáo viên
        </div>
    </a>

    <a href="?page=class">
        <div class="nav-item <?php if ($isClassAcvite) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-users-class"></i>
            </span>
            Quản lý lớp học
        </div>
    </a>

    <a href="?page=score">
        <div class="nav-item <?php if ($isScoreAcvite) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-poll-h"></i>
            </span>
            Quản lý điểm số
        </div>
    </a>

    <a href="?page=about">
        <div class="nav-item <?php if ($isAboutAcvite) echo "active" ?>">
            <span class="nav-icon">
                <i class="far fa-info-circle"></i>
            </span>
            Giới thiệu
        </div>
    </a>
</div>