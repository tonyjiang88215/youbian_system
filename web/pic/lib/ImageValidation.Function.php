<?php
//header("Content-type: image/gif");
session_start();
$_SESSION['check_code']='';
ImageValidation();
function ImageValidation()
{   
	global $v;

	$width=60;$height=30;
	$im=imagecreate($width,$height);
	imagecolorallocate($im,248,248,255);

	for($i=0;$i<100;$i++)
    {
	    $pointColor=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
	    imagesetpixel($im,rand(0,100),rand(0,30),$pointColor);
    }

	for($i=0;$i<2;$i++)
    {
	    $c1=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
        $c2=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
        $style=array ($c1,$c2,$c1,$c2,$c1,$c2,$c1,$c2,$c1,$c1,$c2,);
        imagesetstyle($im, $style);
        imageline($im, rand(0,$width), rand(0,$height),rand(0,$width), rand(0,$height), IMG_COLOR_STYLED);
    }

	$valiText="abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
	$valiNum=4;
	$valiColor=array
	(
		0=>array("0","0","139"),
		1=>array("0","139","139"),
		2=>array("139","0","139"),
		3=>array("139","0","0"),
	);
	$c=count($valiColor);
    
	$fontX=rand(5,10);
	$fontY=4;
	$fontM=9;

	for($i=0;$i<$valiNum;$i++)
	{
		$font=substr($valiText,rand(0,strlen($valiText)-1),1);
		$index=rand(0,$c-1);
		$r=$valiColor[$index][0];
		$g=$valiColor[$index][1];
		$b=$valiColor[$index][2];
		$fontColor=imagecolorallocate($im,$r,$g,$b);
		$charIndex=imagechar($im,10,$fontX,rand(1,$fontY),$font,$fontColor);
		$fontX+=(imagefontwidth($charIndex)+$fontM);
		$_SESSION['check_code'] .= strtolower($font);
	}

	imagegif($im,'',100);
	imagedestroy($im);
}
session_
?>