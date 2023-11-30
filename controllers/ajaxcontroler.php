<?php
include "../application/db_config.php";
class Ajaxcontroler
{
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if( $action == 'encrypt' )
        {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public function unlinkimage($icon,$path)
    {
        if(file_exists("$path/$icon"))
        {
            unlink("$path/$icon");
        }
    }
    public function get_session()
    {
        return $_SESSION['login'];
    }
    public function user_logout()
    {
        $_SESSION['login'] = FALSE;
        session_destroy();
    }
    public function getadmininfo($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_ADMIN." WHERE admin_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

    public function getcategory($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY." WHERE category_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
           return $data;
        }
        else
        {
            return false;
        }
    }
    public function deletecategory($id){
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM ".TBL_CATEGORY." WHERE category_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }

    public function getstory($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE story_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
           return $data;
        }
        else
        {
            return false;
        }
    }
    
    public function deletestory($id){
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM ".TBL_STORY." WHERE story_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }


    public function gethomebanner($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE homebanner_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
           return $data;
        }
        else
        {
            return false;
        }
    }
    
    public function deletehomebanner($id){
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM ".TBL_HOME_BANNER." WHERE homebanner_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }

    public function getuserstory($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_USER_STORY." WHERE story_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
           return $data;
        }
        else
        {
            return false;
        }
    }
    
    public function deleteuserstory($id){
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM ".TBL_USER_STORY." WHERE story_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }

    public function changestorystatus($id,$status){
        $db = getDB();
        $stmt = $db->prepare("UPDATE ".TBL_USER_STORY." SET `is_active`=:status WHERE story_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->bindParam("status", $status,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }

}
?>