<?php
session_start();
include 'controllers/storybook.php';
include 'function.php';
$admin = new Dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
}
$getuser=$admin->getadmininfo($_SESSION['uid']);




if(isset($_POST['editstory']))
{
    if($getuser->rights == 1) {
    	if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="")
	    {
	    	$reomveimage=$admin->unlinkimage($_POST['oldimage'],"uploads");

	        $path = $_FILES['file']['name'];
	        $ext = pathinfo($path, PATHINFO_EXTENSION);
	        $tmp_file=$_FILES['file']['tmp_name'];
	        $imagename= "story_".time().".".$ext;
	        $file_path="uploads/".$imagename;

	        if(move_uploaded_file($tmp_file,$file_path))
	        {
	            extract($_REQUEST);
		        $time = time();
		        $editstory = $admin->editstory($story_id,$category,$story_title,$story,$imagename);
		        if ($editstory) 
		        {
			        ?>
			            <script>
			                window.location = 'editstory.php?Axl3j4g6t='<?php echo $_GET['Axl3j4g6t'];?>;
			            </script>
			        <?php
				} 
				else 
				{
					?>
						<script>
							alert("! Please Try Again.. !!!");
						</script>
					<?php
				}
	        }
	        else
	        {
	            ?>
	            <script>
	                alert("! Error For Uploading file !!!");
	            </script>
	            <?php
	        }
	    }
	    else
	    {
	    	extract($_REQUEST);
		    $time = time();
		   	$editstory = $admin->editstory($story_id,$category,$story_title,$story,"none");
		    if ($editstory) 
		    {
			    ?>
			            <script>
			                window.location = 'editstory.php?Axl3j4g6t='<?php echo $_GET['Axl3j4g6t'];?>;
			            </script>
			        <?php
				} 
				else 
				{
					?>
						<script>
							alert("! Please Try Again.. !!!");
						</script>
					<?php
				}
	    }
    }
    else
    {
        ?>
        <script>
            alert("You are demo user");
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
	<title>Story Book | Edit Story</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
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
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css" rel="stylesheet" />
	<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
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
				<li><a href="javascript:;">Home</a></li>
				<li class="active">Edit Story</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Edit Story</h1>
			<!-- end page-header -->
			
			
			<!-- begin row -->
			<div class="row">
                <!-- begin col-12 -->

                <?php
                	$querystring=$_GET['Axl3j4g6t'];
                	$enc_str1=$admin->encrypt_decrypt("decrypt",$querystring);
					$val11=explode("=",$enc_str1);
					$storyid=$val11[1];

                	$storydetail=$admin->getstorybyid($storyid);
                ?>

                <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="form-wysiwyg-2">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Edit Story</h4>
                        </div>
                        	
                        <div class="panel-body panel-form">
                			<div class="col-md-6">
                				<form  name="addquestion" method="POST" enctype="multipart/form-data">
                					<input type="hidden" name="story_id" value="<?php echo $storydetail->story_id;?>">
                					<input type="hidden" name="oldimage" value="<?php echo $storydetail->image;?>">
                					<div class="form-group">
			                            <div class="col-md-12" style="margin-top: 15px">
			                            </div>
			                        </div>
                					<div class="form-group">
			                            <label class="col-md-2 control-label">Select Category: </label>
			                            <div class="col-md-10">
			                                <select class="form-control" name="category" onchange="getcategory(this.value)" required="" style="border: 1px solid #ccd0d4 !important;">
			                                	<option value="">Select Category</option>
			                                    <?php
			                                    	$category = $admin->getallcategory();
			                                        foreach ($category as $val)
			                                        {
			                                        	if($val['category_id'] == $storydetail->category_id)
			                                        	{
			                                        		?>
				                                            <option value="<?php echo $val['category_id'];?>" selected><?php echo $val['name'];?></option>
				                                            <?php
			                                        	}
			                                        	else
			                                        	{
			                                        		?>
				                                            <option value="<?php echo $val['category_id'];?>"><?php echo $val['name'];?></option>
				                                            <?php
			                                        	}
			                                        }
			                                    ?>
			                                </select>
			                            </div>
			                        </div>


			                        <div class="form-group">
			                            <div class="col-md-12" style="margin-top: 30px">
			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Story Title: </label>
			                            <div class="col-md-10">
			                                <input type="text" name="story_title" class="textarea form-control" value="<?php echo $storydetail->story_title;?>"  placeholder="Story Title" >
			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <div class="col-md-12" style="margin-top: 30px">
			                            </div>
			                        </div>


			                         <style type="text/css">
			                        	div#cke_editor1{
										    border: 1px solid #ccc !important;
										}
			                        </style>
			                       
			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Story: </label>
			                            <div class="col-md-10">
			                                <textarea class="textarea form-control" name="story"  id="editor1" placeholder="Story" rows="12"><?php echo $storydetail->story; ?></textarea>
			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <div class="col-md-12" style="margin-top: 30px">
			                            </div>
			                        </div>


			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Story Image: </label>
			                            <div class="col-md-10">
			                                <input type="file" name="file" class="form-control"  />
			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <div class="col-md-12" style="margin-top: 30px">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Selected Image: </label>
			                            <div class="col-md-10">
			                                <img src="uploads/<?php echo $storydetail->image; ?>" style="width: 150px">
			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <div class="col-md-12" style="margin-top: 30px">
			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <label class="col-md-2 control-label"></label>
			                            <div class="col-md-10">
			                                <input type="submit" name="editstory" value="Edit Story" class="btn btn-sm btn-success">
			                            </div>
			                        </div>

									<div class="form-group">
			                            <div class="col-md-12" style="margin-top: 30px">
			                            </div>
			                        </div>

								</form>
								
                			</div>
                			
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
	<script src="assets/plugins/ckeditor/ckeditor.js"></script>
	<script src="assets/plugins/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
	<script src="assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
	<script src="assets/js/form-wysiwyg.demo.min.js"></script>
	<script src="assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			FormWysihtml5.init();
		});

		$(document).ready(function() {
			App.init();
			FormWysihtml6.init();
		});
	</script>

	<script>
    	CKEDITOR.replace('editor1');
    	CKEDITOR.replace('editor2');
    </script>

<script type="text/javascript">
	function getcategory(id){
        $.ajax({
            type: "POST",
            url: "ajax/getcategorybyid.php",
            data: {querystring:id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#showcategory').replaceWith($('#showcategory').html(data));
                }
                else
                {

                }
            }
        });
    }

    function getlevelbycategory(id){
        $.ajax({
            type: "POST",
            url: "ajax/getlevelbycategory.php",
            data: {querystring:id},
            cache: false,
            success: function (data)
            {
                if (data)
                {
                    $('#showlevel').replaceWith($('#showlevel').html(data));
                }
                else
                {

                }
            }
        });
    }
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
