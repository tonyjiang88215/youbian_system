<?php
include_once $CFG ['path'] ['core'] ['lib'] . DIRECTORY_SEPARATOR . 'mail' . DIRECTORY_SEPARATOR . 'class.phpmailer.php';
class mailer {
	public static $MAIL_OBJECT = false;
	public static function getMailHandler() {
		if (! self::$MAIL_OBJECT instanceof PHPMailer) {
			self::$MAIL_OBJECT = new PHPMailer ();
		}
		return self::$MAIL_OBJECT;
	}
	
/**
 * 
 * 利用PHPMailer发送邮件 扩展sendMailer方法:
 * 										 $userInfo  用户信息数组 array();
 * @param unknown_type $mailhost   发送邮件的主机 例如：smtp.sina.com.cn
 * @param unknown_type $frompwd   发送邮件邮箱的密码
 * @param unknown_type $fromaddress  发送邮件邮件的地址
 * @param unknown_type $fromname  发送邮件的名字
 * @param unknown_type $rplyto	回复邮件的地址
 * @param unknown_type $toaddress  目标邮件的地址
 * @param unknown_type $subject	邮件主题
 * @param unknown_type $urlHref	链接href
 * 										  $msg         邮件内容
 */	
	public static function sendMail($userInfo,$mailhost, $frompwd, $fromaddress,$fromname, $rplyto, $toaddress, $subject,$urlHref,$msg) {
		$currentDate = date ( "Y-m-d H:i:s" );
		$head = "亲爱的" . $toaddress . '，您好：</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您在' . $currentDate.$msg;
		$body = '(如果您无法点击链接，请将此链接复制到浏览器地址栏后访问)</br>请勿回复该邮件，感谢您使用s8s！';
		$mailerHandler = self::getMailHandler ();
		$encrypt = factory::getEncrypt();
		$strUserInfo = serialize ($userInfo);
		$encryptRs= $encrypt->appEncode ($strUserInfo);
		$resultStr = urlencode ($encryptRs);
		
		$url = '<a href='.$urlHref.urlencode($resultStr).'>'.$urlHref.$resultStr.'</a>';
		$msgbody = $head . "<br>" . $url . "<br>" . $body;
		$mailerHandler->IsSMTP ();
		$mailerHandler->Host = $mailhost;
		$mailerHandler->SMTPAuth = true;
		$mailerHandler->Username = $fromaddress;
		$mailerHandler->Password = $frompwd;
		$mailerHandler->From = $fromaddress;
		$mailerHandler->FromName = $fromname;
		$mailerHandler->CharSet = 'utf-8';
		$mailerHandler->Encoding = 'base64';
		$mailerHandler->AddReplyTo ( $rplyto );
		$mailerHandler->AddAddress ( $toaddress );
		$mailerHandler->IsHTML ( true );
		$mailerHandler->Subject = $subject;
		$mailerHandler->Body = $msgbody;
		if (! $mailerHandler->Send ()) {
			return false;
		}else{
			return true;
		}
	}
} 