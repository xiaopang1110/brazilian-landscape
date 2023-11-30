<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();

$randomstory=$apicontroller->getrandomstory();
if($randomstory)
{
    $result['data']['success']=1;
    $result['data']['randomstory']=$randomstory;
    $result['data']['error']="";
}
else
{
    $result['data']['success']=0;
    $result['data']['randomstory']=array();
    $result['data']['error']="Please Try Again";
}

echo json_encode($result);
?>