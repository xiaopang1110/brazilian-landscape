<?php
$getuser=$admin->getadmininfo($_SESSION['uid']);
?>

<!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="dashboard.php" class="navbar-brand"><span><img src="uploads/logo.png" height="20" width="20"></span> Story Book Admin</a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->
                
                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown navbar-user">
                        <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="uploads/<?php echo $getuser->image; ?>" alt="" />
                            <span class="hidden-xs"><?php echo $getuser->username; ?></span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                            <li><a href="profile.php">Edit Profile</a></li>
                            <li><a href="changepassword.php">Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="include/logout.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- end header navigation right -->
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->