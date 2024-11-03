<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/dist/img/user2-160x160.jpg" class="img-circle">
            </div>
            <div class="pull-left info">
                <p><?= ucfirst($_SESSION['username']) ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li>
                <a href="asset_list.php"><i class="fa fa-pie-chart"></i><span>Manajemen Aset</span></a>
            </li>
            <li>
                <a href="attb_list.php"><i class="fa fa-recycle"></i><span>ATTB</span>
                </a>
            </li>
            <li>
                <a href="area_list.php">
                    <i class="fa fa-money"></i><span>Area</span>
                </a>
            </li>

            <li>
                <a href="mutation_list.php">
                    <i class="fa fa-money"></i><span>Mutasi</span>
                </a>
            </li>
            <li>
                <a href="lab_list.php">
                    <i class="fa fa-money"></i><span>Labs</span>
                </a>
            </li>
            <?php if ($_SESSION['is_admin']): ?>
                <li class="header">SETTINGS</li>
                <li><a href="user_list.php"><i class="fa fa-user"></i> <span>Users</span></a></li>
            <?php endif; ?>
        </ul>
    </section>
</aside>