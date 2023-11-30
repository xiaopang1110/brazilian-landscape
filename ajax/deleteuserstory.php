<?php
session_start();
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new Ajaxcontroler();
$getuser=$admin->getadmininfo($_SESSION['uid']);

$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
if($getuser->rights == 1)
{
    $removeimage=$admin->getuserstory($id);
    if($removeimage){
        $image=$removeimage->image;
        $admin->unlinkimage($image,"../uploads");
    }
    
    $removecat=$admin->deleteuserstory($id);
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