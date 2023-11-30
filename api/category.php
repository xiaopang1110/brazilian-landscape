<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();

$category=$apicontroller->getcategory();
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
echo json_encode($result);
?>