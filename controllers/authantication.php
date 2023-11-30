<?php 
	include "application/db_config.php";
	class Admin
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
		public function check_login($username, $passwords)
		{
			$db = getDB();
            $password=$this->encrypt_decrypt('encrypt',$passwords);
			$stmt = $db->prepare("SELECT admin_id FROM ".TBL_ADMIN." WHERE  (username=:username or email=:username) AND  password=:password");
			$stmt->bindParam("username", $username,PDO::PARAM_STR);
			$stmt->bindParam("password", $password,PDO::PARAM_STR);
			$stmt->execute();
			$count=$stmt->rowCount();
			$data=$stmt->fetch(PDO::FETCH_OBJ);
			$db = null;
			if($count)
			{
				$_SESSION['login'] = true;
				$_SESSION['uid']=$data->admin_id;
				return true;
			}
			else
			{
				return false;
			}
		}


    	/*** starting the session ***/
	    public function get_session()
		{
	        return $_SESSION['login'];
	    }

	    public function user_logout()
		{
	        $_SESSION['login'] = FALSE;
	        session_destroy();
	    }

	}
?>