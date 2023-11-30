<?php
include "../application/db_config.php";
class Apicontrollers
{
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function getcategory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM " . TBL_CATEGORY . " ORDER BY category_id DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $array[] = $data;
            }
            return $array;
        } else {
            return false;
        }
    }

    public function getsearchcategory($search)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM " . TBL_CATEGORY . " WHERE `name` LIKE '%".$search."%' ORDER BY category_id DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $array[] = $data;
            }
            return $array;
        } else {
            return false;
        }
    }

    public function addstory($story_title,$story,$image,$time)
    {

        $db = getDB();
        $is_active = 0;
        $stmt = $db->prepare("INSERT INTO ".TBL_USER_STORY."(`story_title`,`story`,`image`,`is_active`,`created_at`,`updated_at`) VALUES (:story_title,:story,:image,:is_active,:created_at,:updated_at)");
        $stmt->bindParam("story_title", $story_title,PDO::PARAM_STR);
        $stmt->bindParam("story", $story,PDO::PARAM_STR);
        $stmt->bindParam("image", $image,PDO::PARAM_STR);
        $stmt->bindParam("is_active", $is_active,PDO::PARAM_STR);
        $stmt->bindParam("created_at", $time,PDO::PARAM_STR);
        $stmt->bindParam("updated_at", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getuserstory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_USER_STORY." WHERE (`is_active`=1)  ORDER BY `story_id` DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $story_desc=htmlspecialchars($data->story, ENT_QUOTES);
                //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
                $array[] = array('story_id'=>$data->story_id,'story_title'=>$data->story_title,'story'=>$story_desc,'image'=>$data->image,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at);
            }
            return $array;
        } else {
            return false;
        }
    }

    public function getstory($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE (`category_id`=:id AND `is_active`=1)  ORDER BY `story_id` DESC");
        $stmt->bindParam('id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $story_desc=htmlspecialchars($data->story, ENT_QUOTES);
                //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
                $array[] = array('story_id'=>$data->story_id,'category_id'=>$data->category_id,'story_title'=>$data->story_title,'story'=>$story_desc,'image'=>$data->image,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at);
            }
            return $array;
        } else {
            return false;
        }
    }

    public function getsearchstory($id,$search)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE (`category_id`=:id AND `is_active`=1) AND `story_title` LIKE '%".$search."%' ORDER BY `story_id` DESC");
        $stmt->bindParam('id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $story_desc=htmlspecialchars($data->story, ENT_QUOTES);
                //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
                $array[] = array('story_id'=>$data->story_id,'category_id'=>$data->category_id,'story_title'=>$data->story_title,'story'=>$story_desc,'image'=>$data->image,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at);
            }
            return $array;
        } else {
            return false;
        }
    }

    public function getallstory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1  ORDER BY `story_id` DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $story_desc=htmlspecialchars($data->story, ENT_QUOTES);
                //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
                $array[] = array('story_id'=>$data->story_id,'category_id'=>$data->category_id,'story_title'=>$data->story_title,'story'=>$story_desc,'image'=>$data->image,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at);
            }
            return $array;
        } else {
            return false;
        }
    }

    public function getstorybyid($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `story_id`=:story_id");
        $stmt->bindParam('story_id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if ($count) 
        {
            $story_desc=htmlspecialchars($data->story, ENT_QUOTES);
            //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
            $array= array('story_id'=>$data->story_id,'category_id'=>$data->category_id,'story_title'=>$data->story_title,'story'=>$story_desc,'image'=>$data->image,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at);
            return $array;
        }
        else 
        {
            return false;
        }
    }

    public function gethomebanner()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." ORDER BY `homebanner_id` DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) 
            {
                $storydetail=$this->getstorybyid($data->story_id);
                //$story_desc=htmlspecialchars($storydetail->story, ENT_QUOTES);
                //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
                $array[] = array('homebanner_id'=>$data->homebanner_id,'story_id'=>$data->story_id,'banner_title'=>$data->banner_title,'image'=>$data->image,'story'=>$storydetail);
                //$array[] = $data;
            }
            return $array;
        } else {
            return false;
        }
    }

    public function getrandomstory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 ORDER BY RAND() LIMIT 1");
        $stmt->bindParam('id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {
            while ($data = $stmt->fetch(PDO::FETCH_OBJ)) {
                $story_desc=htmlspecialchars($data->story, ENT_QUOTES);
                //$story_desc=htmlspecialchars_decode($data->story_desc, ENT_NOQUOTES);
                $array[] = array('story_id'=>$data->story_id,'category_id'=>$data->category_id,'story_title'=>$data->story_title,'story'=>$story_desc,'image'=>$data->image,'created_at'=>$data->created_at,'updated_at'=>$data->updated_at);
            }
            return $array;
        } else {
            return false;
        }
    }
   
    
   

}
?>