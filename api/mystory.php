<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();

$story=$apicontroller->getuserstory();
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

echo json_encode($result);
?>