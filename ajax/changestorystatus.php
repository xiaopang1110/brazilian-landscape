<?php
session_start();
$querystring=$_POST['querystring'];
$status=$_POST['status'];
include '../controllers/ajaxcontroler.php';
$admin = new Ajaxcontroler();
$getuser=$admin->getadmininfo($_SESSION['uid']);

$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
if($getuser->rights == 1)
{
    $removecat=$admin->changestorystatus($id,$status);
    if($removecat)
    {
        echo "True";
    }
    else
    {
        echo "False";
    }
}
else
{
    echo "False";
}

?>