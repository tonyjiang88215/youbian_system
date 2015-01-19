<?php
// ini_set('display_errors' , 'On');
$callback = $_GET['callback'];

$uploadPath = '/tmp/'.time().'.doc';

if(move_uploaded_file($_FILES['word']['tmp_name'] , $uploadPath)){

	$url = 'http://192.168.1.39/uploadfile.aspx';//接收XML地址
	$header = "Content-type: text/json";//定义content-type为xml
	
	$data = array(
		'file1'=>'@'.$uploadPath
	);
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POST, 1 );
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
// 	curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0");
	$result = curl_exec($curl);
	$error = curl_error($curl);
	
	echo '<script type="text/javascript">';
	echo 'window.top.'.$callback.'('.$result.');';
	echo '</script>';
	
}else{
	
	echo 'xxx';
	
}

unlink($uploadPath);


// echo '<script type="text/javascript">';
// echo 'window.top.'.$callback.'("data:'.$_FILES['image']['type'].';base64,'.base64_encode(file_get_contents($_FILES['image']['tmp_name'])).'");';
// echo '</script>';
