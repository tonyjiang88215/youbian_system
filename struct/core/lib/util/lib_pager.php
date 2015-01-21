<?php
class pager{
	//资源列表的模版
	public static  $sourceListTemplate=array(
		'head'=>'
		<div id="table1">
			<table width="480px" >
				<tr>
					<th style=\" width:230px;\">资源名称 </th><th style=\" width:80px;\">作者 </th>
					<th style=\" width:80px;\">上传时间</th>
				</tr>',
		'body'=>'
				<tr>
				<td style=\" width:230px;\" class=\"source_name\"  id=\"\" class=\"\"   >
					<a href=\"/source/source_sourceDetail.php?storeid=1\" target=\"_blank\" >$value[sourcename]</a>
				</td>
				<td style=\"width:80px;\">$value[account] </td>
				<td style=\"width:80px;\">$value[uploadtime]</td>
				</tr>',
		'tail'=>'
			</table>
		</div>');
	
	
	
	function getTemplateContents($listID){}
		
	
	
	
	/**
	 * 模版循环体的结合方法
	 * @param $var
	 * @param $content
	 * @return unknown_type
	 */
	function pageListElements($value,$content){
		eval("\$content =\"$content \";");
		return $content;
	}
	
	/**
	 * 列表制作的基本方法
	 * @param $elements	列表变量所组成的数组
	 * @param $contents	模版所组成的数组 
	 * 					$content['head']=循环体前的模版内容
	 * 					$content['body']=循环体的内容
	 * 					$content['tail']=循环体结束后的内容
	 * @return 列表的HTML代码
	 */
	function pageList($elements,$contents){
		$resultContent = $contents['head'];
		foreach($elements as $key => $value){
			$resultContent.=$this->pageListElements($value,$contents['body']);
		}
		$resultContent .= $contents['tail'];
		return $resultContent;
	}
}

