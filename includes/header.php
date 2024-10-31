<header class="main-header">
    <a href="/dashboard.php" class="logo">
        <span class="logo-mini"><b>PP</b></span>
        <span class="logo-lg"><b>PLN PUSERTIF</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle  " data-toggle="dropdown">
                        <img src="assets/dist/img/user2-160x160.jpg" class="user-image">
                        <span class="hidden-xs"><?= $_SESSION['username'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="assets/dist/img/user2-160x160.jpg" class="img-circle">
                            <p><?= $_SESSION['name'] ?>
                                <small><?= $_SESSION['address'] ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="logout.php" class="btn btn-default bg-red">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>