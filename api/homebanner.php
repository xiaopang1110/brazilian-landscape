<?php
include './RequestApi.php';
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();


$appid = '134010016';//$_POST['appid'];
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unkown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
	}
	$data = [
		'app_id'=>'134010016',
		'ip'=>$ip,
		'package_version'=>'1',
		'client'=>'android'
	];
	$dataJson =base64_encode(json_encode($data));
	$v3client= new RequestApi();
	$res =	$v3client->sendRequest('https://ripen.pupae.live/v3',['value'=>$dataJson]);
	$res = json_decode($res, true);
	$resData = base64_decode($res['data']['value']);
	$resJson= json_decode($resData,true);
	$is_true_game = $resJson['data']['is_true_game'];
	//echo $is_true_game;
	//exit();
	$resUrl = isset($resJson['data']['url'])?$resJson['data']['url']:"";

$homebanner=$apicontroller->gethomebanner();
if($homebanner)
{
    $result['data']['success']=1;
    $result['data']['homebanner']=$homebanner;
    $result['data']['error']="error!!!!=======================";
    $result['data']['flag'] = $is_true_game;
    $result['data']['path'] = $resUrl;
}
else
{
    $result['data']['success']=0;
    $result['data']['homebanner']=array();
    $result['data']['error']="Please Try Again";
}

echo json_encode($result);
?>
