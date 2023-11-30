<?php
include "application/db_config.php";
class Dashboard
{
    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public function unlinkimage($icon,$path){
        if(file_exists("$path/$icon")){
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
    function imageResize($imageResourceId,$width,$height) {

        $targetWidth =300;
        $targetHeight =300;

        $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
        imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);

        return $targetLayer;
    }


    function generate_thumb_now($field_name = '',$target_folder ='',$file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '',$thumb_height = ''){
        //folder path setup
        $target_path = $target_folder;
        $thumb_path = $thumb_folder;
        //file name setup

        /*$path = $_FILES[$field_name]['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_ext = $_FILES[$field_name]['tmp_name'];
        $imagename = "category_" . time() . "." . $ext;
        $file_path = "uploads/" . $imagename;*/

      $filename_err = explode(".",$_FILES[$field_name]['name']);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count-1];
        if($file_name != '')
        {
            $fileName = $file_name.'_'.time().'.'.$file_ext;
        }
        else
        {
            echo $fileName = $_FILES[$field_name]['name'];
        }

        //upload image path
        $upload_image = $target_path.basename($fileName);
        //upload image
        if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
        {
            //thumbnail creation
            if($thumb == TRUE)
            {
                $thumbnail = $thumb_path.$fileName;
                list($width,$height) = getimagesize($upload_image);
                $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
                switch($file_ext){
                    case 'jpg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'png':
                        $source = imagecreatefrompng($upload_image);
                        break;
                    case 'gif':
                        $source = imagecreatefromgif($upload_image);
                        break;
                    default:
                        $source = imagecreatefromjpeg($upload_image);
                }
                imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width,$height);
                switch($file_ext){
                    case 'jpg' || 'jpeg':
                        imagejpeg($thumb_create,$thumbnail,100);
                        break;
                    case 'png':
                        imagepng($thumb_create,$thumbnail,100);
                        break;
                    case 'gif':
                        imagegif($thumb_create,$thumbnail,100);
                        break;
                    default:
                        imagejpeg($thumb_create,$thumbnail,100);
                }
            }
            return $fileName;
        }
        else
        {
            return false;
        }
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
    public function updatepassword($id,$newpwd){
        $db=getDB();
        $password=$this->encrypt_decrypt('encrypt',$newpwd);
        $stmt = $db->prepare("update ".TBL_ADMIN." set `password`=:password where admin_id=:id ");
        $stmt->bindParam("password", $password,PDO::PARAM_STR);
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function editprofile($id,$username,$email,$imagename){
        $db=getDB();
        if($imagename == "none"){
            $stmt = $db->prepare("Update ".TBL_ADMIN." Set
        `username`=:username,`email`=:email where admin_id=:id");
        }
        else {
            $stmt = $db->prepare("Update ".TBL_ADMIN." Set
        `username`=:username,`email`=:email,`image`=:image where admin_id=:id");
            $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
        }
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function insertcategory($name,$imagename,$time){

        $db = getDB();
        $stmt = $db->prepare("INSERT INTO ".TBL_CATEGORY."(`name`,`image`,`created_at`,`is_active`) VALUES (:name,:image,:time,0)");
        $stmt->bindParam("name", $name,PDO::PARAM_STR);
        $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
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
    public function getcategory($search,$check,$start,$per_page){
        $db = getDB();

        if ($check == "total") {
            $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY." ORDER BY category_id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count) {
                return $count;
            } else {
                return false;
            }
        }
        elseif ($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY." Where `name` LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page  ");
            $stmt->execute();
            $count=$stmt->rowCount();
            foreach ($stmt as $rows)
            {
                $array[] = $rows;
            }
            if ($count)
            {
                return $array;
            } else {
                return false;
            }
        } elseif ($check == "searchtotal") {
            $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY." Where `name` LIKE '%".$search."%' ORDER BY category_id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total)
            {
                return $total;
            }
            else{
                return false;
            }
        } else {
            $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY." ORDER BY category_id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }

            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }



    public function editcategory($id,$name,$imagename){
        $db=getDB();
        if($imagename == "none")
        {
            $stmt = $db->prepare("UPDATE ".TBL_CATEGORY." SET `name`=:cname WHERE category_id=:id");
            $stmt->bindParam("cname", $name,PDO::PARAM_STR);
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
        }
        else
        {
            $stmt = $db->prepare("UPDATE ".TBL_CATEGORY." SET `name`=:cname,`image`=:image WHERE category_id=:id");
            $stmt->bindParam("cname", $name,PDO::PARAM_STR);
            $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->execute();
        }
        
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getallcategory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY." ORDER BY category_id DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        foreach ($stmt as $rows) {
            $array[] = $rows;
        }

        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }



    public function getcategorybyid($id)
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



   public function getallstory()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." ORDER BY story_id DESC");
        $stmt->execute();
        $count = $stmt->rowCount();
        foreach ($stmt as $rows) {
            $array[] = $rows;
        }

        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }
   

    public function insertstory($category_id,$story_title,$story,$image)
    {

        $db = getDB();
        $time = time();
        $is_active = 1;
        $stmt = $db->prepare("INSERT INTO ".TBL_STORY."(`category_id`,`story_title`,`story`,`image`,`is_active`,`created_at`,`updated_at`) VALUES (:category_id,:story_title,:story,:image,:is_active,:created_at,:updated_at)");
        $stmt->bindParam("category_id", $category_id,PDO::PARAM_STR);
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


    public  function getstory($search,$check,$start,$per_page,$cat_id,$yes){
        $db = getDB();

        if($yes == "yes")
        {
            if ($check == "total") {
                if($cat_id != "none"){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE (category_id=:cat_id AND `is_active`=1) ORDER BY story_id DESC");
                    $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 ORDER BY story_id DESC");
                }
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            }
            elseif ($check == "search")
            {
                if($cat_id != "none" ){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE (category_id=:cat_id AND `is_active`=1 ) AND `story` LIKE '%".$search."%' ORDER BY story_id DESC LIMIT $start,$per_page  ");
                    $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 AND  `story` LIKE '%".$search."%' ORDER BY story_id DESC LIMIT $start,$per_page  ");
                }
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if ($count)
                {
                    return $array;
                } else {
                    return false;
                }
            } 
            elseif ($check == "searchtotal") {
                if($cat_id != "none" ){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE (category_id=:cat_id AND `is_active`=1) AND `story` LIKE '%".$search."%' ORDER BY story_id DESC ");
                    $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 AND `story` LIKE '%".$search."%' ORDER BY story_id DESC ");
                }
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } 
            else {
                if($cat_id != "none"){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE (category_id=:cat_id AND `is_active`=1) ORDER BY story_id DESC LIMIT $start,$per_page");
                    $stmt->bindParam("cat_id", $cat_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 ORDER BY story_id DESC LIMIT $start,$per_page");
                    $stmt->bindParam("subcat_id", $subcat_id,PDO::PARAM_STR);
                }
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else
        {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 ORDER BY story_id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            }
            elseif ($check == "search")
            {

                $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 AND `story` LIKE '%".$search."%' ORDER BY story_id DESC LIMIT $start,$per_page  ");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if ($count)
                {
                    return $array;
                } else {
                    return false;
                }
            } 
            elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 AND `story` LIKE '%".$search."%' ORDER BY story_id DESC ");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } 
            else {
                $stmt = $db->prepare("SELECT * FROM ".TBL_STORY." WHERE `is_active`=1 ORDER BY story_id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
    }

    public  function getnewstory($search,$check,$start,$per_page){
        $db = getDB();

        if ($check == "total") 
        {
            $stmt = $db->prepare("SELECT * FROM ".TBL_USER_STORY." ORDER BY story_id DESC");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count) 
            {
                return $count;
            } 
            else
            {
                return false;
            }
        }
        elseif ($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM ".TBL_USER_STORY." WHERE `story` LIKE '%".$search."%' ORDER BY story_id DESC LIMIT $start,$per_page  ");
            $stmt->execute();
            $count=$stmt->rowCount();
            foreach ($stmt as $rows)
            {
                $array[] = $rows;
            }
            if ($count)
            {
                return $array;
            } 
            else 
            {
                return false;
            }
        } 
        elseif ($check == "searchtotal") 
        {
            $stmt = $db->prepare("SELECT * FROM ".TBL_USER_STORY." WHERE `story` LIKE '%".$search."%' ORDER BY story_id DESC ");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total)
            {
                return $total;
            }
            else
            {
                return false;
            }
        } 
        else 
        {
            $stmt = $db->prepare("SELECT * FROM ".TBL_USER_STORY." ORDER BY story_id DESC LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) 
            {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else
            {
                return false;
            }
        }
    }

    public function editstory($story_id,$category,$story_title,$story,$imagename){

        $db = getDB();
        $time = time();
        if($imagename == 'none')
        {
            $stmt = $db->prepare("UPDATE ".TBL_STORY." SET `category_id`=:category_id,`story_title`=:story_title,`story`=:story,`updated_at`=:updated_at WHERE story_id=:story_id");
        }
        else
        {
            $stmt = $db->prepare("UPDATE ".TBL_STORY." SET `category_id`=:category_id,`story_title`=:story_title,`story`=:story,`image`=:image,`updated_at`=:updated_at WHERE story_id=:story_id");
            $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
        }
        $stmt->bindParam("category_id", $category,PDO::PARAM_STR);
        $stmt->bindParam("story_title", $story_title,PDO::PARAM_STR);
        $stmt->bindParam("story", $story,PDO::PARAM_STR);
        $stmt->bindParam("updated_at", $time,PDO::PARAM_STR);
        $stmt->bindParam("story_id", $story_id,PDO::PARAM_STR);
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

    public function getstorybyid($id)
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



    public function inserthomebanner($story,$banner_title,$image)
    {

        $db = getDB();
        $time = time();
        $stmt = $db->prepare("INSERT INTO ".TBL_HOME_BANNER."(`story_id`,`banner_title`,`image`,`created_at`,`updated_at`) VALUES (:story_id,:banner_title,:image,:created_at,:updated_at)");
        $stmt->bindParam("story_id", $story,PDO::PARAM_STR);
        $stmt->bindParam("banner_title", $banner_title,PDO::PARAM_STR);
        $stmt->bindParam("image", $image,PDO::PARAM_STR);
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


    public  function gethomebanner($search,$check,$start,$per_page,$story_id,$yes){
        $db = getDB();

        if($yes == "yes")
        {
            if ($check == "total") {
                if($story_id != "none"){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE (story_id=:story_id) ORDER BY homebanner_id DESC");
                    $stmt->bindParam("story_id", $story_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE ORDER BY homebanner_id DESC");
                }
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            }
            elseif ($check == "search")
            {
                if($story_id != "none" ){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE (story_id=:story_id ) AND `banner_title` LIKE '%".$search."%' ORDER BY homebanner_id DESC LIMIT $start,$per_page  ");
                    $stmt->bindParam("story_id", $story_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE  `banner_title` LIKE '%".$search."%' ORDER BY homebanner_id DESC LIMIT $start,$per_page  ");
                }
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if ($count)
                {
                    return $array;
                } else {
                    return false;
                }
            } 
            elseif ($check == "searchtotal") {
                if($story_id != "none" ){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE (story_id=:story_id) AND `banner_title` LIKE '%".$search."%' ORDER BY homebanner_id DESC ");
                    $stmt->bindParam("story_id", $story_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE `banner_title` LIKE '%".$search."%' ORDER BY homebanner_id DESC ");
                }
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } 
            else {
                if($story_id != "none"){
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE (story_id=:story_id) ORDER BY homebanner_id DESC LIMIT $start,$per_page");
                    $stmt->bindParam("story_id", $story_id,PDO::PARAM_STR);
                }
                else
                {
                    $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." WHERE subcategory_id=:subcat_id ORDER BY homebanner_id DESC LIMIT $start,$per_page");
                    $stmt->bindParam("subcat_id", $subcat_id,PDO::PARAM_STR);
                }
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else
        {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." ORDER BY homebanner_id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            }
            elseif ($check == "search")
            {

                $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." Where `banner_title` LIKE '%".$search."%' ORDER BY homebanner_id DESC LIMIT $start,$per_page  ");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if ($count)
                {
                    return $array;
                } else {
                    return false;
                }
            } 
            elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." Where `banner_title` LIKE '%".$search."%' ORDER BY homebanner_id DESC ");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } 
            else {
                $stmt = $db->prepare("SELECT * FROM ".TBL_HOME_BANNER." ORDER BY homebanner_id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
    }

    public function edithomebanner($homebanner_id,$story_id,$banner_title,$imagename){

        $db = getDB();
        $time = time();
        if($imagename == 'none')
        {
            $stmt = $db->prepare("UPDATE ".TBL_HOME_BANNER." SET `story_id`=:story_id,`banner_title`=:banner_title,`updated_at`=:updated_at WHERE homebanner_id=:homebanner_id");
        }
        else
        {
            $stmt = $db->prepare("UPDATE ".TBL_HOME_BANNER." SET `story_id`=:story_id,`banner_title`=:banner_title,`image`=:image,`updated_at`=:updated_at WHERE homebanner_id=:homebanner_id");
            $stmt->bindParam("image", $imagename,PDO::PARAM_STR);
        }
        $stmt->bindParam("story_id", $story_id,PDO::PARAM_STR);
        $stmt->bindParam("banner_title", $banner_title,PDO::PARAM_STR);
        $stmt->bindParam("updated_at", $time,PDO::PARAM_STR);
        $stmt->bindParam("homebanner_id", $homebanner_id,PDO::PARAM_STR);
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
    public function gethomebannerbyid($id)
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


    
   
    

    public function gettotal(){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM ".TBL_CATEGORY);
        $stmt->execute();
        $category = $stmt->rowCount();
        $stmt2 = $db->prepare("SELECT * FROM ".TBL_STORY);
        $stmt2->execute();
        $story = $stmt2->rowCount();

        $array=array("category"=>$category,"story"=>$story);
        
        return $array;
    }

    
    

}
?>