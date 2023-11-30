<!-- begin #sidebar -->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar user -->
                <ul class="nav">
                    <li class="nav-profile">
                        <div class="image">
                            <a href="profile.php"><img src="uploads/<?php echo $getuser->image; ?>" alt="" /></a>
                        </div>
                        <div class="info">
                            <?php echo $getuser->username; ?>
                            <small><?php echo $getuser->email; ?></small>
                        </div>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                <ul class="nav">
                    <li class="nav-header"></li>
                    <li class="has-sub ">
                        <a href="dashboard.php">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-laptop"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="category.php">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-list"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="story.php">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-book"></i>
                            <span>Story</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="homebanner.php">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-home"></i>
                            <span>Home Banner</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="newstory.php">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-book"></i>
                            <span>New Story</span>
                        </a>
                    </li>
                    
                   
                    
                    <!-- begin sidebar minify button -->
                    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                    <!-- end sidebar minify button -->
                </ul>
                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
        </div>
        <div class="sidebar-bg"></div>
        <!-- end #sidebar -->