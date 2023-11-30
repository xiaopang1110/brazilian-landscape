<?php
session_start();
include 'controllers/storybook.php';
$admin = new Dashboard();

if(!$admin->get_session())
{
    header("location:index.php");
}
$getuser=$admin->getadmininfo($_SESSION['uid']);
if(isset($_POST['changepassword']))
{
    $oldpwd=$admin->encrypt_decrypt('encrypt',$_POST['oldpwd']);
    $newpwd=$_POST['newpwd'];
    $confirmpwd=$_POST['confirmpwd'];
    $id=$_SESSION['uid'];
    $admininfo = $admin->getadmininfo($id);
    if($oldpwd == $admininfo->password)
    {
        if($newpwd == $confirmpwd)
        {

            $update=$admin->updatepassword($id,$newpwd);
            if($update)
            {
                ?>
                <script>
                    alert("Password Change Successfully..");
                    window.location='include/logout.php';
                </script>
                <?php
            }
            else
            {
                ?>
                <script>
                    alert("Network Error Please Trt Again");
                </script>
                <?php
            }
        }
        else
        {
            ?>
            <script>
                alert("New Password And Confirm Password Are Not Match");
            </script>
            <?php
        }

    }
    else
    {
        ?>
        <script>
            alert("Old Password Wrong...");
        </script>
        <?php
    }

}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>Story Book | Change Password</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="icon" type="image/png" href="uploads/logo.png"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <?php include 'include/header.php';?>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <?php include 'include/sidebar.php';?>
    <!-- end #sidebar -->

    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Change Password</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Change Password <small></small></h1>
        <!-- end page-header -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-6">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Profile Detail</h4>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Old Password: </label>
                                <div class="col-md-9">
                                    <input type="password" name="oldpwd" placeholder="Old Password" required="" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">New Password: </label>
                                <div class="col-md-9">
                                    <input type="password" name="newpwd" placeholder="New Password" required="" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Confirm Password: </label>
                                <div class="col-md-9">
                                    <input type="password" name="confirmpwd" placeholder="Confirm Password" required="" class="form-control"  />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <?php
                                    if($getuser->rights == 1)
                                    {
                                        ?>
                                        <input type="submit" value="Change Password" name="changepassword" class="btn btn-sm btn-success">
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <input type="submit" value="Change Password" class="btn btn-sm btn-success" onclick="demo()">
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->

        </div>
        <!-- end row -->


    </div>
    <!-- end #content -->



    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="assets/crossbrowserjs/html5shiv.js"></script>
<script src="assets/crossbrowserjs/respond.min.js"></script>
<script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    function demo() {
        alert("You Are Demo User");
    }
    function selectimage()
    {
        var x =document.getElementById('file');
        x.click();

    }
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("file").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("catimage").src = oFREvent.target.result;
        };
    };

</script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-53034621-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
