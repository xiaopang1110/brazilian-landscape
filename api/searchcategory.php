<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();

if(isset($_POST['search']) && $_POST['search']!="")
{
    $search=$_POST['search'];
    $category=$apicontroller->getsearchcategory($search);
    if($category)
    {
        $result['data']['success']=1;
        $result['data']['category']=$category;
        $result['data']['error']="";
    }
    else
    {
        $result['data']['success']=0;
        $result['data']['category']=array();
        $result['data']['error']="Please Try Again";
    }
}
else
{
    $result['data']['success']=0;
    $result['data']['category']=array();
    $result['data']['error']="All Field Required";
}

echo json_encode($result);
?>