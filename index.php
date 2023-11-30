<?php
session_start();
include_once 'controllers/authantication.php';
$admin = new Admin();
if(isset($_SESSION['login']))
{
    header("location:dashboard.php");
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<title>Story Book | Login</title>
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
    <style type="text/css">
        html,body{
            overflow-y:hidden;
        }
    </style>
</head>
<body class="pace-top" >
	<!-- begin #page-loader -->
	<!--<div id="page-loader" class="fade in"><span class="spinner"></span></div>-->
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">

	    <!-- begin login -->
        <div class="login bg-black animated fadeInDown">

            <!-- begin brand -->
            <div class="login-header">

                <div class="brand">
                    <img src="uploads/logo.png" height="100" width="100"><!--<span class="logo"></span>--> Story Book Admin
                </div>

                
            </div>
            <!-- end brand -->
            <div class="login-content">
                <form  method="POST" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <input type="text"  name="username" class="form-control input-lg" placeholder="Username" onclick="onmouserightclick()"/>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password"  name="password" class="form-control input-lg" placeholder="Password" />
                    </div>
                    
                    <div class="login-buttons">
                        <button type="submit" name="login" class="btn btn-success btn-block btn-lg">Sign me in</button>
                    </div>
                </form>
                <br>
                <p style="color: #fff" id="err"></p>
                <p style="color: #fff" id="msg"></p><br>
            </div>

        </div>
        <!-- end login -->
        
        
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
    

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

    <?php
if(isset($_POST['login'])){
    extract($_REQUEST);
    $login=$admin->check_login($username,$password);
    if($login)
    {
        ?>
        <script>
            document.getElementById("msg").innerHTML="<i class='icon icon-login'></i> Login Successfully !!!";
            window.location='dashboard.php';
        </script>
    <?php
    }
    else
    {
    ?>
        <script>
            document.getElementById("err").innerHTML="! Invalid Login Username And Password !!!";
        </script>
        <?php
    }
}
?>
<script>
    function onmouserightclick()
    {
        document.getElementById("err").innerHTML="";
    }
</script>
</body>

</html>
