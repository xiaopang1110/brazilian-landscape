<?php
define('DB_SERVER', '10.148.0.11');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'mysql_ime');
define('DB_DATABASE', 'brazilian-landscape');
define('SECRET_KEY', 'This is my story book');
define('SECRET_IV', 'This is my story book');
define('IMAGEPATH', 'http://templatevictory.com/storybook/uploads/');



define('TBL_ADMIN', 'storybook_admin');
define('TBL_CATEGORY', 'storybook_category');
define('TBL_STORY', 'storybook_story');
define('TBL_HOME_BANNER', 'storybook_homebanner');
define('TBL_USER_STORY', 'storybook_userstory');




function getDB()
{
    $dbhost=DB_SERVER;
    $dbuser=DB_USERNAME;
    $dbpass=DB_PASSWORD;
    $dbname=DB_DATABASE;
    try
    {
        @ini_set('max_execution_time', 300);
        $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbConnection->exec("set names utf8");
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
    catch (PDOException $e)
    {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}
?>
