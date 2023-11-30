<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();

if(isset($_POST['category_id']) && $_POST['category_id']!="" &&
    isset($_POST['search']) && $_POST['search']!="")
{
    $id=$_POST['category_id'];
    $search=$_POST['search'];
    $story=$apicontroller->getsearchstory($id,$search);
    if($story)
    {
        $result['data']['success']=1;
        $result['data']['story']=$story;
        $result['data']['error']="";
    }
    else
    {
        $result['data']['success']=0;
        $result['data']['story']=array();
        $result['data']['error']="Please Try Again";
    }
}
else
{
    $result['data']['success']=0;
    $result['data']['story']=array();
    $result['data']['error']="All Field Required";
}

echo json_encode($result);
?>