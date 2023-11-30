<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();

if(isset($_POST['story_title']) && $_POST['story_title']!="" &&
    isset($_POST['story']) && $_POST['story']!="" &&
    isset($_FILES['image']['name']) && $_FILES['image']['name']!="")
{

    $story_title=$_POST['story_title'];
    $story=$_POST['story'];
    
    $path = $_FILES['image']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $tmp_file=$_FILES['image']['tmp_name'];
    $imagename= "story_".time().".".$ext;
    $file_path="../uploads/".$imagename;
    if(move_uploaded_file($tmp_file,$file_path))
    {
        $time = time();
        $addstory=$apicontroller->addstory($story_title,$story,$imagename,$time);
        if($addstory)
        {
            $result['data']['success']=1;
            $result['data']['addstory']="";
            $result['data']['error']="Add your story successfully";
        }
        else
        {
            $result['data']['success']=0;
            $result['data']['addstory']="";
            $result['data']['error']="Please Try Again";
        }
    }
    
}
else
{
    $result['data']['success']=0;
    $result['data']['addstory']="";
    $result['data']['error']="All Field Required";
}

echo json_encode($result);
?>