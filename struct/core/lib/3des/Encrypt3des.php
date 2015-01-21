<?php
Class Encrypt3des {
	protected static $key;
	protected static $iv;

	function __construct(){
		
	}
	
	function randomKeyAndIv(){
		$this->key = $this->genRandomString(48);
		$this->iv = $this->genRandomIv();
	}
	
	function pad($text) {
		$text_add = strlen($text) % 8;

		for($i = $text_add; $i < 8; $i++) {
			$text .= chr(8 - $text_add);
		}
		return $text;
	}
	 
	function unpad($text) {
		 
		$pad = ord($text{strlen($text)-1});
		 
		if ($pad > strlen($text)) {
			return false;
		}
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
			return false;
		}
		return substr($text, 0, -1 * $pad);
	}
	 
	function encrypt($key, $iv, $text) {
		 
		$key_add = 24 - strlen($key);
		$key .= substr($key, 0, $key_add);
		 
		$text = $this -> pad($text);
		$td = mcrypt_module_open (MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
		 
		mcrypt_generic_init ($td, $key, $iv);
		 
		$encrypt_text = mcrypt_generic ($td, $text);
		 
		mcrypt_generic_deinit($td);
		 
		mcrypt_module_close($td);
		 
		return $encrypt_text;
	}
	 
	function decrypt($key, $iv, $text) {
		$key_add = 24 - strlen($key);
		 
		$key .= substr($key, 0, $key_add);
		 
		$td = mcrypt_module_open (MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
		 
		mcrypt_generic_init ($td, $key, $iv);
		 
		$text = mdecrypt_generic ($td, $text);
		 
		mcrypt_generic_deinit($td);
		 
		mcrypt_module_close($td);
		 
		return $this -> unpad($text);
	}
	 
	function encode($text){
		$key = pack('H*',$this->key);
		$iv  = pack('H*',$this->iv);
		return $this->encrypt($key, $iv, $text);
		 
	}
	 
	function decode($text , $key , $iv){
		$key = pack('H*',$key);
		$iv  = pack('H*',$iv);
		return $this->decrypt($key, $iv, $text);
	}
	
	function genRandomString($len){
	    $chars = array("a", "b", "c", "d", "e", "f", "0", "1", "2", 
	        "3", "4", "5", "6", "7", "8", "9");
	    $charsLen = count($chars) - 1;
	 
	    shuffle($chars);    // 将数组打乱
	    
	    $output = "";
	    for ($i=0; $i<$len; $i++)
	    {
	        $output .= $chars[mt_rand(0, $charsLen)];
	    }
	 
	    return $output;
	}
	
	function genRandomIv(){
		$chars = array("0", "1", "2", 
	        "3", "4", "5", "6", "7", "8", "9");
		
		$charsLen = count($chars) - 1;
	 
	    shuffle($chars);    // 将数组打乱
		
		$result = '';
		for($i=0;$i<16;$i++){
			$result .= intval(mt_rand(0,$charsLen));
		}
		return $result;
	}
	
//	function appEncode($data){
//		$this->randomKeyAndIv();
//		$result = $this -> encode($data);
//		$result = base64_encode($result);
//		$insertIndex = rand(0,strlen($result)/2);//随机生成插入位置
//		$md5 = md5($result);//编码后求MD5码
//		for($i = 0 ; $i < strlen($md5) ; $i++){
//			$md5[$i] = ($i%2==0) ? strtoupper($md5[$i]) : strtolower($md5[$i]);
//		}
//		$insertIndexFor16 = dechex($insertIndex);
//		$result = substr_replace($result,$this->key.$this->iv,$insertIndex,0);
//		$result = $insertIndexFor16.'L'.$md5.$result;
//		$this->randomKeyAndIv();
//		return $result;
//	}

//	function appDecode($data){
//		$indexPosition = strpos($data , 'L');
//		$insertIndex = substr($data,0,$indexPosition);
//		$insertIndexForTen = hexdec($insertIndex);
//		$getMd5 = substr($data , $indexPosition+1 , 32);
//		$key = substr($data , $insertIndexForTen + strlen($insertIndex) + 1 + 32 ,48);
//		$iv =  substr($data , $insertIndexForTen + strlen($insertIndex) + 1 + 32 + 48 , 16);
//		$data = str_replace($key.$iv,'',$data);
//		$result = substr($data , $indexPosition + 32 + 1);
//		if(md5($result)==strtolower($getMd5)){
//			$result  = base64_decode($result);
//			$result = $this->decode($result,$key,$iv);
//		}else{
//			$result =  false;
//		}
//		return $result;
//	}
	
	function appEncode($data){
		$this->randomKeyAndIv();
		$result = $this -> encode($data);
		$result = base64_encode($result);
		$md5 = md5($result);
		$insertIndex1 = rand(0,strlen($result)/2);//随机生成插入位置
		$result = substr_replace($result,$this->key,$insertIndex1,0);
		$insertIndex1Str = dechex($insertIndex1);
		$insertIndex2 = rand(strlen($result)/2,strlen($result)-1);
		$result = substr_replace($result,$this->iv,$insertIndex2,0);
		$insertIndex2Str = dechex($insertIndex2);
		for($i = 0 ; $i < strlen($md5) ; $i++){
			$md5[$i] = ($i%2==0) ? strtoupper($md5[$i]) : strtolower($md5[$i]);
		}
		$result = $insertIndex2Str.'K'.$insertIndex1Str.'L'.$md5.'M'.$result;
		$this->randomKeyAndIv();
		return $result;
	}
	
	function appDecode($data){
		$firstK = strpos($data,'K');
		$firstL = strpos($data,'L');
		$insertIndex2Str = substr($data,0,$firstK);
		$insertIndex1Str = substr($data,$firstK + 1,$firstL - $firstK - 1);
		$md5 = substr($data , $firstL+1 , 32);
		$insertIndex1 = hexdec($insertIndex1Str);
		$insertIndex2 = hexdec($insertIndex2Str);
		$data = substr($data,$firstL+32+1+1);
		$iv = substr($data,$insertIndex2,16);
		$data = substr_replace($data,'',$insertIndex2,16);
		$key = substr($data,$insertIndex1,48);
		$data = substr_replace($data,'',$insertIndex1,48);
		$calculateMd5 = md5($data);
		if($calculateMd5==strtolower($md5)){
			$data = base64_decode($data);
			$result = $this->decode($data,$key,$iv);
		}else{
			$result = false;
		}
		return $result;
	}
	

}
?>