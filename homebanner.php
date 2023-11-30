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
$story = $admin->getallstory();


?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>Story Book | Home Banner</title>
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

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/isotope/isotope.css" rel="stylesheet" />
    <link href="assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN PAGE CSS STYLE ================== -->
    <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="assets/plugins/powerange/powerange.min.css" rel="stylesheet" />
    <!-- ================== END PAGE CSS STYLE ================== -->


    <!-- ================== BEGIN PAGINATION CSS STYLE ================== -->
    <link href="assets/pagination.css" rel="stylesheet" type="text/css">
    <link href="assets/B_grey.css" rel="stylesheet" type="text/css" />
    <!-- ================== END PAGINATION CSS STYLE ================== -->

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
            <li class="active">Home Banner</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Home Banner <small></small></h1>
        <!-- end page-header -->


        <?php
        if(isset($_GET['perpage']) && $_GET['perpage']!="")
        {
            $per_page=$_GET['perpage'];
        }
        else
        {
            $per_page = 8;
        }

        if(isset($_GET['page']))
        {
            $pageset = $_GET['page'];
            if ($pageset == 1)
            {
                $start = 0;
                $page = $per_page;
            }
            else
            {
                $page = $_GET['page'] * $per_page;
                $start = $page - $per_page;
            }
        }
        else
        {
            $start = 0;
            $page = $per_page;
        }
        
        if(isset($_GET['Axl3j4g6t']) && $_GET['Axl3j4g6t'] !== "")
        {
            $querystring=$_GET['Axl3j4g6t'];
            $enc_str2=$admin->encrypt_decrypt("decrypt",$querystring);
            $val=explode("=",$enc_str2);
            $story_id=$val[1];
            if (isset($_GET['search']))
            {
                $search = $_GET['search'];
                $qutotal = $admin->gethomebanner($search, "searchtotal", "none", "none",$story_id,"yes");
                $query = $admin->gethomebanner($search, "search", $start, $per_page,$story_id,"yes");
            }
            else
            {
                $query = $admin->gethomebanner("none", "none", $start, $per_page,$story_id,"yes");
                $qutotal = $admin->gethomebanner("none", "total", "none", "none",$story_id,"yes");
            }
        }
        else
        {
            if (isset($_GET['search']))
            {
                $search = $_GET['search'];
                $qutotal = $admin->gethomebanner($search, "searchtotal", "none", "none","","no");
                $query = $admin->gethomebanner($search, "search", $start, $per_page,"","no");
            }
            else
            {
                $query = $admin->gethomebanner("none", "none", $start, $per_page,"","no");
                $qutotal = $admin->gethomebanner("none", "total", "none", "none","","no");
            }

        }

        ?>

            <div class="row">
                <div class="col-md-2">
                    <a href="addhomebanner.php" class="btn btn-sm btn-success" >Add New Home Banner</a>
                </div>
                <div class="col-md-2">
                    <select class="form-control m-b-2" name="story_id" onchange="selectcatid(this.value)">
                        <option value="" readonly="">Select Story</option>
                        <?php
                        foreach ($story as $val)
                        {
                            $qstring1="storyid=".$val['story_id'];
                            $enc_str1=$admin->encrypt_decrypt("encrypt",$qstring1);
                            if($_GET['Axl3j4g6t']==$enc_str1)
                            { ?>
                                <option value="<?php echo $enc_str1;?>" selected><?php echo $val['story_title'];?></option>
                            <?php }
                            else
                            { ?>
                                <option value="<?php echo $enc_str1;?>"><?php echo $val['story_title'];?></option>
                            <?php }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <a href="homebanner.php" class="btn btn-sm btn-success" >Reset</a>
                </div>
            </div>

       <!-- begin row -->
            <div class="row">
                <!-- begin col-6 -->
                <div class="col-md-12">
                    
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Home Banner</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="4%">#</th>
                                        <th width="10%" >Image</th>
                                        <th width="39%">Story</th>
                                        <th width="39%">Banner Title</th>
                                        <th width="8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($query) 
                                        {
                                            foreach ($query as $res)
                                            {
                                                $qstring="homebannerid=".$res['homebanner_id'];
                                                $enc_str=$admin->encrypt_decrypt("encrypt",$qstring);
                                                ?>
                                                <tr>
                                                    <td><?php echo $res['homebanner_id'];?></td>
                                                    <td><img src="uploads/<?php echo $res['image'];?>" style="height: 100px"></td>
                                                    <td><?php 
                                                        foreach ($story as $val)
                                                        {
                                                            if($res['story_id'] == $val['story_id']) {
                                                                echo $val['story_title'];
                                                            }
                                                        }
                                                    ?></td>
                                                    <td><?php echo $res['banner_title'];?></td>
                                                    <td>
                                                        <?php
                                                            if($getuser->rights == 1)
                                                            {
                                                                ?>
                                                                <a href="edithomebanner.php?Axl3j4g6t=<?php echo $enc_str ?>" > <span class="fa fa-edit" style="font-size: 18px;color: #00acac;"> Edit</span></a> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a href="#" onclick="deletehomebanner('<?php echo $enc_str; ?>')"><span class="fa fa-trash-o" style="font-size: 18px;color: #761c19"> Delete</span></a>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <a  onclick="demo()"><span class="fa fa-edit" style="font-size: 18px;color: #00acac;"> Edit</span></a> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <a  onclick="demo()"><span class="fa fa-trash-o" style="font-size: 18px;color: #761c19"> Delete</span></a>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else 
                                        { ?>
                                            <td colspan="5">
                                                <p align="center">Data Not Found</p>
                                            </td>
                                        <?php
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end panel -->
                    
                </div>
                <!-- end col-6 -->

                <div class="row pull-right">
                    <div class="col-md-12" >
                        <?php
                        if(isset($_GET['page']))
                        {
                            $select=$_GET['page'];
                        }
                        else
                        {
                            $select=1;
                        }
                       
                        if(isset($_GET['Axl3j4g6t']) && $_GET['Axl3j4g6t'] != "" &&
                            isset($_GET['perpage']) && $_GET['perpage'] != "" )
                        {
                            $pagename="story.php?Axl3j4g6t=".$_GET['Axl3j4g6t']."&perpage=".$_GET['perpage']."&";
                        }
                        elseif(isset($_GET['Axl3j4g6t']) && $_GET['Axl3j4g6t'] != "")
                        {
                            $pagename="story.php?Axl3j4g6t=".$_GET['Axl3j4g6t']."&";
                        }
                        elseif(isset($_GET['perpage']) && $_GET['perpage'] != "")
                        {
                            $pagename="story.php?perpage=".$_GET['perpage']."&";
                        }
                        else
                        {
                            $pagename="story.php?";
                        }
                        if(isset($_GET['search']))
                        {
                            $url=$pagename."search=".$_GET['search']."&";
                        }
                        else
                        {
                            $url=$pagename;

                        }
                        echo pagination($qutotal,$per_page,$select,$url);
                        ?>
                    </div>
                </div>
            </div>
            <!-- end row -->


        </div>


        
    </div>
    <!-- end #content -->

    
<!-- #modal-dialog -->
    <div class="modal fade" id="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add New Question</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Category: </label>
                            <div class="col-md-9">
                                <select class="form-control" name="category">
                                    <?php
                                        foreach ($category as $val)
                                        {
                                            ?>
                                                <option value="<?php echo $val['category_id']; ?>"><?php echo $val['name'];?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        


                        <div class="form-group">
                            <label class="col-md-3 control-label">Category Name: </label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category Name: </label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category Name: </label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category Name: </label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category Name: </label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" />
                            </div>
                        </div>
                        
                        <!--<div class="form-group">
                            <label class="col-md-3 control-label">Select</label>
                            <div class="col-md-9">
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>-->
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                    <input type="submit" name="addcategory" value="Add Category" class="btn btn-sm btn-success">
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editcategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div  id="showcategory" >


                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-3 control-label">Select</label>
                            <div class="col-md-9">
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>-->
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                    <input type="submit" name="editcategory" value="Edit Category" class="btn btn-sm btn-success">
                </div>
                </form>
            </div>
        </div>
    </div>

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

<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>

<script src="assets/js/gallery.demo.min.js"></script>
<script src="assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="assets/plugins/lightbox/js/lightbox-2.6.min.js"></script>
<script src="assets/plugins/switchery/switchery.min.js"></script>
<script src="assets/plugins/powerange/powerange.min.js"></script>
<script src="assets/js/form-slider-switcher.demo.min.js"></script>

<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    function demo() {
        alert("You Are Demo User");
    }
    function selectcatid(id)
    {
        <?php
        if(isset($_GET['page']) && isset($_GET['DYlN1b0Jn']))
        { ?>
        window.location="homebanner.php?Axl3j4g6t="+id +"&DYlN1b0Jn=<?php echo $_GET['DYlN1b0Jn'];?>&page=<?php echo $_GET['page'];?>";
        <?php }
        elseif(isset($_GET['page']))
        { ?>
        window.location="homebanner.php?Axl3j4g6t="+id +"&page=<?php echo $_GET['page'];?>";
        <?php }
        elseif(isset($_GET['DYlN1b0Jn']))
        { ?>
        window.location="homebanner.php?Axl3j4g6t="+id +"&DYlN1b0Jn=<?php echo $_GET['DYlN1b0Jn'];?>";
        <?php }
        else
        { ?>
        window.location="homebanner.php?Axl3j4g6t="+id;
        <?php }
        ?>
    }
    function selectsubcatid(id)
    {
        <?php
        if(isset($_GET['page']) && isset($_GET['Axl3j4g6t']))
        { ?>
        window.location="questions.php?DYlN1b0Jn="+id +"&Axl3j4g6t=<?php echo $_GET['Axl3j4g6t'];?>&page=<?php echo $_GET['page'];?>";
        <?php }
        elseif(isset($_GET['page']))
        { ?>
        window.location="questions.php?DYlN1b0Jn="+id +"&page=<?php echo $_GET['page'];?>";
        <?php }
        elseif(isset($_GET['Axl3j4g6t']))
        { ?>
        window.location="questions.php?DYlN1b0Jn="+id +"&Axl3j4g6t=<?php echo $_GET['Axl3j4g6t'];?>";
        <?php }
        else
        { ?>
        window.location="questions.php?DYlN1b0Jn="+id;
        <?php }
        ?>
    }
    
    function deletehomebanner(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/deletehomebanner.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        <?php
                        if(isset($_GET['page']) && isset($_GET['Axl3j4g6t']))
                        { ?>
                        window.location="homebanner.php?Axl3j4g6t="+id +"&page=<?php echo $_GET['page'];?>";
                        <?php }
                        elseif(isset($_GET['Axl3j4g6t']))
                        { ?>
                        window.location="homebanner.php?Axl3j4g6t=<?php echo $_GET['Axl3j4g6t'];?>";
                        <?php }
                        elseif(isset($_GET['page']))
                        { ?>
                        window.location="homebanner.php?page=<?php echo $_GET['page'];?>";
                        <?php }
                        else
                        { ?>
                        window.location="homebanner.php";
                        <?php }
                        ?>
                    }
                    else
                    {
                        alert("Please Try Again Latter..");
                    }
                }
            });
        }
        else{
            return false;
        }
    }

    
</script>

<script>
    $(document).ready(function() {
        App.init();
        Gallery.init();
    });
</script>
<script>
    $(document).ready(function() {
        App.init();
        FormSliderSwitcher.init();
    });
</script>
<script>
    $(document).ready(function() {
        App.init();
        Notification.init();
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
