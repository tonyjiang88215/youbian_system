<?php
/**
 * 静态化数据管理对象，用于将需要永久保存的数据，存为JSON文件格式。便于使用:
 * 	为图表缓存：每天的 播放/录制许可数据、 资源播放/录制次数数据、资源播放情况数据统计
 * 	为统计表格缓存：每天的、当前月的、当前年的、总计的播放次数、录制次数、播放流量、录制流量
 * 
 * 保存最小单位为域名
 * 	
 * @author tony
 *
 */

class static_data_manager{
	protected static $typeDoc = array(
		'chart'=>'chart',
		'stat'=>'stat',
		'source'=>'source'
	);
	
	protected static $statType = array(
		'tsmonth'=>'tsmonth.json',
		'tsyear'=>'tsyear.json',
		'total'=>'total.json'
	);
	
//	public function __construct(){
//		echo self::$save_path;
//	}
	
	/**
	 * 
	 * @param $start  开始日期，格式例如：2012-01-01   
	 * @param $end     结束日期，格式例如：2012-01-01
	 * @param $domainArray  tumblr
	 * @return unknown_type
	 */
	public static function get_license_chart_data($start , $end , $domainArray){
		global $CFG;
		$data_path= $CFG['docRoot']['data'].'/'.self::$typeDoc['chart'].'/';
		$dataArray = array();
		if($start == $end){//如果是同一天，则图表为柱状图，需要小时数据
			$dateArray = explode('-',$start);
			$domainDataArray = array();
			foreach($domainArray as $domain){
				$data_path .= $domain.'/'.$dateArray[0].'/'.$dateArray[1].'/'.$start.'.json';
				if(file_exists($data_path)){
					$domainDataArray[] = json_decode(file_get_contents($data_path) , true);
				}else{
					$domainDataArray[] = array();
				}
			};
//			print_r($domainDataArray);
			for($i = 0 ; $i < 24 ; $i++){//遍历24个小时
				$curTime = strtotime($start)+$i*3600;
				$dataArrayPlay = array('type'=>1,'count'=>0,'time'=>$curTime);
				$dataArrayRecord = array('type'=>2,'count'=>0,'time'=>$curTime);
				foreach($domainDataArray as $domainData){//遍历所有域名
					if(count($domainData) > 0){
						foreach($domainData['data'] as $data){//遍历域名下的数据，将时间相同的数据做累加
							if(strtotime(date('Y-m-d H:00',$data['time'])) == $curTime){
								if($data['type'] == 1){
									$dataArrayPlay['count'] += $data['count'];
								}else{
									$dataArrayRecord['count'] += $data['count'];
								}
							}
						}
					}
				}
				$dataArray[] = $dataArrayPlay;
				$dataArray[] = $dataArrayRecord;
			}
		}else{//如果不是同一天，则图表为线形图，需要天数据
			$startTime = strtotime($start);
			$endTime = strtotime($end);
			
			for($i = 0 ; $i < 1 + ($endTime - $startTime)/86400 ; $i++){//先按照查询日期遍历，创建每一天的数组
				$tmpPlayData = array('type'=>1,'count'=>0,'time'=>$startTime+$i*86400);
				$tmpRecordData = array('type'=>2,'count'=>0,'time'=>$startTime+$i*86400);
				$dateStr = date('Y-m-d',$startTime+$i*86400);
//				echo $dateStr.'<br/>';
				$dateArray = explode('-',$dateStr);
				
				foreach($domainArray as $domain){//遍历查询的域名，把每一个域名的数据都查询出来，填入当天的数据当中
					
					$tmp_path = $data_path. $domain.'/'.$dateArray[0].'/'.$dateArray[1].'/'.$dateStr.'.json';
//					echo $tmp_path.'<br/>';
					if(file_exists($tmp_path)){
						$tmp_data = json_decode(file_get_contents($tmp_path) , true);
//						print_r($tmp_data);
						$tmpPlayData['count'] += intval($tmp_data['maxPlay']);
						$tmpRecordData['count'] += intval($tmp_data['maxRecord']);
					}
				}
				
//				echo $tmpPlayData['count'].'  __  '.$domain.' __ '.$dateStr.'<br/>';
				$dataArray[] = $tmpPlayData;
				$dataArray[] = $tmpRecordData;
				
			}
			
			/*
			$domainDataArray = array();
				foreach($domainArray as $domain){//遍历查询的域名，把每一个域名的数据都查询出来
					$domainDataArray[$domain] = array();
					for($i = 0 ; $i < 1 + ($endTime - $startTime)/86400 ; $i++){//遍历当前域名下，每天的数据
						
						$dateStr = date('Y-m-d',$startTime+$i*86400);
						echo $dateStr.'<br/>';
						$dateArray = explode('-',$dateStr);
						
						$tmp_path = $data_path. $domain.'/'.$dateArray[0].'/'.$dateArray[1].'/'.$dateStr.'.json';
						echo $tmp_path.'<br/>';
						if(file_exists($tmp_path)){
							$tmp_data = json_decode(file_get_contents($tmp_path) , true);
							$domainDataArray[$domain][] = array('type'=>1,'count'=>intval($tmp_data['maxPlay']),'time'=>$startTime+$i*86400);
							$domainDataArray[$domain][] = array('type'=>2,'count'=>intval($tmp_data['maxRecord']),'time'=>$startTime+$i*86400);
						}else{
							$domainDataArray[$domain][] = array('type'=>1,'count'=>0,'time'=>$startTime+$i*86400);
							$domainDataArray[$domain][] = array('type'=>2,'count'=>0,'time'=>$startTime+$i*86400);
						}
					}
				};
				*/
		}
		return $dataArray;
	}
	
	/**
	 * 
	 * @param $date  日期，格式例如：2012-01-01   
	 * @param $domain  
	 * @return unknown_type
	 */
	public static function set_license_chart_data($date , $domain , $data){
		global $CFG;
		$data_path = $CFG['docRoot']['data'].'/'.self::$typeDoc['chart'].'/';
		$dateArray = explode('-',$date);
		$data_path .= $domain . '/' . $dateArray[0] . '/' .$dateArray[1] ;
		cmk($data_path);
		$data_path = $data_path.'/'.$date.'.json';
		$result = file_put_contents($data_path , json_encode($data));
		return $result;
		 
	}
	
	/**
	 * 每日定时执行，将前一日的数据，写入静态数据文件中，按照域名进行统计，每日凌晨0点后执行
	 * @return unknown_type
	 */
	public static function daily_update_lisence_data(){
		$domainList = fbs_manager::getDomainAll();
		
		$currentTime = time();
		$prevTime = strtotime(date('Y-m-d',strtotime('-1 day')));
		
		foreach($domainList as $i => $domain){
			$data = stat_manager::user_lisence_stat_query_domain_fresh($prevTime , $prevTime+86399 , array($domain['domain']));
//			echo 'domain:'.$domain['domain'].'<br/>';
//			echo 'date:'.date('Y-m-d',$prevTime).'<br/>';
//			print_r($data);
//			echo '<br/>';
			$saveData = array('maxPlay'=>0,'maxRecord'=>0,'data'=>$data);
			foreach($data as $v){
				if($v['type'] == 1){
					$saveData['maxPlay'] = max($saveData['maxPlay'] , $v['count']);
				}else{
					$saveData['maxRecord'] = max($saveData['maxRecord'] , $v['count']);
				}
			}
			self::set_license_chart_data(date('Y-m-d',$prevTime),$domain['domain'],$saveData);
		}
		return true;
	}
	
	/**
	 * 获取本月资源数据统计
	 * @param $domainArray
	 * @param $time
	 */
	public static function get_tsmonth_stat_data($domainArray, $time){
		global $CFG;
		if($domainArray){
			$whiteList = array();
			foreach ($domainArray as $key => $value){
				$domain = $value['domain'];
				$whiteList[$key]['domain'] = $domain;
				$sourceStat = fbs::getSourceStat($domain, $time);
				
				$tsmonth_path = $CFG['docRoot']['data'].'/'.self::$typeDoc['stat'].'/'.$domain.'/'.self::$statType['tsmonth'];
				if(file_exists($tsmonth_path)){
					$tsmonthData = json_decode(file_get_contents($tsmonth_path), true);
					$tsmonthArr = array(
						'sourceNum' => $sourceStat['sourceNum']+$tsmonthData['sourceNum'],
						'playNum' => $sourceStat['playNum']+$tsmonthData['playNum'],
						'recordNum' => $sourceStat['recordNum']+$tsmonthData['recordNum'],
						'downsize' => $sourceStat['downsize']+$tsmonthData['downsize'],
						'uploadsize' => $sourceStat['uploadsize']+$tsmonthData['uploadsize']
					);
					$whiteList[$key]['tsmonth'] = $tsmonthArr;
				}else{
					$whiteList[$key]['tsmonth'] = $sourceStat;
				}
			}
			return $whiteList;
		}
	}
	/**
	 * 获取本年资源数据统计
	 * @param $domainArray
	 * @param $time
	 */
	public static function get_tsyear_stat_data($domainArray, $time){
		global $CFG;
		if($domainArray){
			$whiteList = array();
			foreach ($domainArray as $key => $value){
				$domain = $value['domain'];
				$whiteList[$key]['domain'] = $domain;
				$sourceStat = fbs::getSourceStat($domain, $time);
				
				$tsyear_path = $CFG['docRoot']['data'].'/'.self::$typeDoc['stat'].'/'.$domain.'/'.self::$statType['tsyear'];
				//tsmonth
				if(file_exists($tsyear_path)){
					$tsyearData = json_decode(file_get_contents($tsyear_path), true);
					$tsyearArr = array(
						'sourceNum' => $sourceStat['sourceNum']+$tsyearData['sourceNum'],
						'playNum' => $sourceStat['playNum']+$tsyearData['playNum'],
						'recordNum' => $sourceStat['recordNum']+$tsyearData['recordNum'],
						'downsize' => $sourceStat['downsize']+$tsyearData['downsize'],
						'uploadsize' => $sourceStat['uploadsize']+$tsyearData['uploadsize']
					);
					$whiteList[$key]['tsyear'] = $tsyearArr;
				}else{
					$whiteList[$key]['tsyear'] = $sourceStat;
				}
			}
			return $whiteList;
		}
	}
	/**
	 * 获取全部资源数据统计
	 * @param $domainArray
	 * @param $time
	 */
	public static function get_total_stat_data($domainArray, $time){
		global $CFG;
		if($domainArray){
			$whiteList = array();
			foreach ($domainArray as $key => $value){
				$domain = $value['domain'];
				$whiteList[$key]['domain'] = $domain;
				$sourceStat = fbs::getSourceStat($domain, $time);
				$whiteList[$key]['today'] = $sourceStat;
				$total_path = $CFG['docRoot']['data'].'/'.self::$typeDoc['stat'].'/'.$domain.'/'.self::$statType['total'];
				if(file_exists($total_path)){
					$totalData = json_decode(file_get_contents($total_path), true);
					$totalArr = array(
						'sourceNum' => $sourceStat['sourceNum']+$totalData['sourceNum'],
						'playNum' => $sourceStat['playNum']+$totalData['playNum'],
						'recordNum' => $sourceStat['recordNum']+$totalData['recordNum'],
						'downsize' => $sourceStat['downsize']+$totalData['downsize'],
						'uploadsize' => $sourceStat['uploadsize']+$totalData['uploadsize']
					);
					$whiteList[$key]['total'] = $totalArr;
				}else{
					$whiteList[$key]['total'] = $sourceStat;
				}
			}
			return $whiteList;
		}else{
			$totalList = array();
			$totalSourceStat = fbs::getSourceStat(null, $time);
			$tfPath = $CFG['docRoot']['data'].'/'.self::$typeDoc['stat'].'/total/total.json';
			if(file_exists($tfPath)){
				$tData = json_decode(file_get_contents($tfPath), true);
				$totalArr = array(
					'sourceNum' => $totalSourceStat['sourceNum']+$tData['sourceNum'],
					'playNum' => $totalSourceStat['playNum']+$tData['playNum'],
					'recordNum' => $totalSourceStat['recordNum']+$tData['recordNum'],
					'downsize' => $totalSourceStat['downsize']+$tData['downsize'],
					'uploadsize' => $totalSourceStat['uploadsize']+$tData['uploadsize']
				);
				$totalList[0]['today'] = $totalSourceStat;
				$totalList[0]['total'] = $totalArr;
				return $totalList;
			}else{
				$totalList[0]['today'] = $totalSourceStat;
				return $totalList;
			}
		}
	}
	
	/**
	 * 
	 * @param $domainArray
	 * @param $time
	 */
	public static function get_source_stat_data($domainArray, $time){
		$tsmonthArr = self::get_tsmonth_stat_data($domainArray, $time);
		$tsyearArr = self::get_tsyear_stat_data($domainArray, $time);
		$totalArr = self::get_total_stat_data($domainArray, $time);
		for($i = 0; $i < count($domainArray); $i++){
			$arrayList[] = array_merge($tsmonthArr[$i], $tsyearArr[$i], $totalArr[$i]);
		}
		return $arrayList;
	}
	
	public static function set_source_stat_data($domainArray, $time){
		global $CFG;
		$m = date('m',$time);
		$d = date('d',$time);
		foreach ($domainArray as $value){
			$domain = $value['domain'];
			$sourceStat = fbs::getSourceStat($domain, $time);
			
			$fpath = $CFG['docRoot']['data'].'/'.self::$typeDoc['stat'].'/'.$domain;
			$tsmonth_path = $fpath.'/'.self::$statType['tsmonth'];
			$tsyear_path = $fpath.'/'.self::$statType['tsyear'];
			$total_path = $fpath.'/'.self::$statType['total'];
			//tsmonth
			if(file_exists($tsmonth_path)){
				if($d == '1'){
					file_put_contents($tsmonth_path, json_encode($sourceStat));
				}else{
					$tsmonthData = json_decode(file_get_contents($tsmonth_path), true);
					$tsmonthArr = array(
						'sourceNum' => $sourceStat['sourceNum']+$tsmonthData['sourceNum'],
						'playNum' => $sourceStat['playNum']+$tsmonthData['playNum'],
						'recordNum' => $sourceStat['recordNum']+$tsmonthData['recordNum'],
						'downsize' => $sourceStat['downsize']+$tsmonthData['downsize'],
						'uploadsize' => $sourceStat['uploadsize']+$tsmonthData['uploadsize']
					);
					file_put_contents($tsmonth_path, json_encode($tsmonthArr));
				}
			}else{
				cmk($fpath);
				file_put_contents($tsmonth_path, json_encode($sourceStat));
			}
			//tsyear
			if(file_exists($tsyear_path)){
				if($m == '1' && $d == '1'){
					file_put_contents($tsyear_path, json_encode($sourceStat));
				}else{
					$tsyearData = json_decode(file_get_contents($tsyear_path), true);
					$tsyearArr = array(
						'sourceNum' => $sourceStat['sourceNum']+$tsyearData['sourceNum'],
						'playNum' => $sourceStat['playNum']+$tsyearData['playNum'],
						'recordNum' => $sourceStat['recordNum']+$tsyearData['recordNum'],
						'downsize' => $sourceStat['downsize']+$tsyearData['downsize'],
						'uploadsize' => $sourceStat['uploadsize']+$tsyearData['uploadsize']
					);
					file_put_contents($tsyear_path, json_encode($tsyearArr));
				}
			}else{
				cmk($fpath);
				file_put_contents($tsyear_path, json_encode($sourceStat));
			}
			//total
			if(file_exists($total_path)){
				$totalData = json_decode(file_get_contents($total_path), true);
				$totalArr = array(
					'sourceNum' => $sourceStat['sourceNum']+$totalData['sourceNum'],
					'playNum' => $sourceStat['playNum']+$totalData['playNum'],
					'recordNum' => $sourceStat['recordNum']+$totalData['recordNum'],
					'downsize' => $sourceStat['downsize']+$totalData['downsize'],
					'uploadsize' => $sourceStat['uploadsize']+$totalData['uploadsize']
				);
				file_put_contents($total_path, json_encode($totalArr));
			}else{
				cmk($fpath);
				file_put_contents($total_path, json_encode($sourceStat));
			}
		}
		//所有域名总计
		$totalSourceStat = fbs::getSourceStat(null, $time);
		$tPath = $CFG['docRoot']['data'].'/'.self::$typeDoc['stat'].'/total';
		$tfPath = $tPath.'/total.json';
		if(file_exists($tfPath)){
			$tData = json_decode(file_get_contents($tfPath), true);
			$totalArr = array(
				'sourceNum' => $totalSourceStat['sourceNum']+$tData['sourceNum'],
				'playNum' => $totalSourceStat['playNum']+$tData['playNum'],
				'recordNum' => $totalSourceStat['recordNum']+$tData['recordNum'],
				'downsize' => $totalSourceStat['downsize']+$tData['downsize'],
				'uploadsize' => $totalSourceStat['uploadsize']+$tData['uploadsize']
			);
			file_put_contents($tfPath, json_encode($totalArr));
		}else{
			cmk($tPath);
			file_put_contents($tfPath, json_encode($totalSourceStat));
		}
		return true;
	}
	
	/**
	 * 
	 * @param $start  开始日期，格式例如：2012-01-01   
	 * @param $end     结束日期，格式例如：2012-01-01
	 * @param $domainArray  tumblr
	 * @return unknown_type
	 */
	public function get_source_chart_data($start , $end , $domainArray){
		global $CFG;
		$data_path= $CFG['docRoot']['data'].'/'.self::$typeDoc['source'].'/';
		$dataArray = array('record'=>array(),'play'=>array());
		if($start == $end){//如果是同一天，则图表为柱状图，需要小时数据
			$dateArray = explode('-',$start);
			$domainDataArray = array();
			foreach($domainArray as $domain){
				$data_path .= $domain.'/'.$dateArray[0].'/'.$dateArray[1].'/'.$start.'.json';
				if(file_exists($data_path)){
					$domainDataArray[] = json_decode(file_get_contents($data_path) , true);
				}else{
					$domainDataArray[] = array();
				}
			};
//			print_r($domainDataArray);
			
			for($i = 0 ; $i < 24 ; $i++){//遍历24个小时
				$curTime = strtotime($start)+$i*3600;
				$dataArrayPlay = array('count'=>0,'time'=>$curTime);
				$dataArrayRecord = array('count'=>0,'time'=>$curTime);
				foreach($domainDataArray as $domainData){//遍历所有域名
					if(count($domainData) > 0){
						foreach($domainData['play']['data'] as $data){//遍历域名下的数据，将时间相同的数据做累加
							if(strtotime(date('Y-m-d',$data['time'])) == $curTime){
									$dataArrayPlay['count'] += $data['count'];
							}
						}
						foreach($domainData['record']['data'] as $data){//遍历域名下的数据，将时间相同的数据做累加
							if(strtotime(date('Y-m-d',$data['time'])) == $curTime){
									$dataArrayRecord['count'] += $data['count'];
							}
						}
						
					}
				}
				
				
//				print_r($sidArray);
				
				$dataArray['record'][] = $dataArrayRecord;
				$dataArray['play'][] = $dataArrayPlay;
				
			}
			
			$sidArray = array();
			foreach($domainDataArray as $domainData){//遍历所有域名
				if(count($domainData) > 0){
					for($j = 0 ; $j < count($domainData['sid']) ; $j++){
						if(!$sidArray[$domainData['sid'][$j]['sid']]){
							$sidArray[$domainData['sid'][$j]['sid']] = array('sid'=>$domainData['sid'][$j]['sid'] , 'count'=>$domainData['sid'][$j]['count']);
						}else{
							$sidArray[$domainData['sid'][$j]['sid']]['count'] += $domainData['sid'][$j]['count'];
						} 
					}
				}
			}
			$dataArray['sid'] = $sidArray;
			
			
		}else{//如果不是同一天，则图表为线形图，需要天数据
			$startTime = strtotime($start);
			$endTime = strtotime($end);
			
			$sidArray = array();
			for($i = 0 ; $i < 1 + ($endTime - $startTime)/86400 ; $i++){//先按照查询日期遍历，创建每一天的数组
				$tmpPlayData = array('count'=>0,'time'=>$startTime+$i*86400);
				$tmpRecordData = array('count'=>0,'time'=>$startTime+$i*86400);
				$dateStr = date('Y-m-d',$startTime+$i*86400);
//				echo $dateStr.'<br/>';
				$dateArray = explode('-',$dateStr);
//				print_r($domainArray);
				foreach($domainArray as $domain){//遍历查询的域名，把每一个域名的数据都查询出来，填入当天的数据当中
					
					$tmp_path = $data_path. $domain.'/'.$dateArray[0].'/'.$dateArray[1].'/'.$dateStr.'.json';
//					echo $tmp_path.'<br/>';
					if(file_exists($tmp_path)){
						$tmp_data = json_decode(file_get_contents($tmp_path) , true);
//						print_r($tmp_data);
						$tmpPlayData['count'] += intval($tmp_data['play']['max']);
						$tmpRecordData['count'] += intval($tmp_data['record']['max']);
						
						for($j = 0 ; $j < count($tmp_data['sid']) ; $j++){
							if(!$sidArray[$tmp_data['sid'][$j]['sid']]){
								$sidArray[$tmp_data['sid'][$j]['sid']] = array('sid'=>$tmp_data['sid'][$j]['sid'] , 'count'=>$tmp_data['sid'][$j]['count']);
							}else{
								$sidArray[$tmp_data['sid'][$j]['sid']]['count'] += $tmp_data['sid'][$j]['count'];
							} 
						}
						
					}
				}
				
//				echo $tmpPlayData['count'].'  __  '.$domain.' __ '.$dateStr.'<br/>';
				$dataArray['play'][] = $tmpPlayData;
				$dataArray['record'][] = $tmpRecordData;
				$dataArray['sid'] = $sidArray;
			}
		}
		return $dataArray;
	}

	public function set_source_chart_data($date , $domain , $data){
		global $CFG;
		$data_path = $CFG['docRoot']['data'].'/'.self::$typeDoc['source'].'/';
		$dateArray = explode('-',$date);
		$data_path .= $domain . '/' . $dateArray[0] . '/' .$dateArray[1] ;
		cmk($data_path);
		$data_path = $data_path.'/'.$date.'.json';
		$result = file_put_contents($data_path , json_encode($data));
		return $result;
	}
	
	public function daily_update_source_data(){
		$domainList = fbs_manager::getDomainAll();
		$currentTime = time();
		$prevTime = strtotime(date('Y-m-d',strtotime('-1 day')));
		foreach($domainList as $i => $domain){
			$playDataList = stat_manager::source_play_stat_query_domain_fresh($prevTime , $prevTime+86399 , $domain['domain']);
			$recordDataList = stat_manager::source_record_stat_query_domain_fresh($prevTime , $prevTime+86399 , $domain['domain']);
			$playSourceidList = stat_manager::source_info_query_domain($prevTime , $prevTime+86399 , $domain['domain']);
			
			
			$saveData = array(
				'play'=>array('max'=>0,'data'=>$playDataList),
				'record'=>array('max'=>0 , 'data'=>$recordDataList),
				'sid'=>$playSourceidList
			);
	//		print_r($playDataList);
			foreach($playDataList as $v){
					$saveData['play']['max'] += $v['count'];
			}
			foreach($recordDataList as $v){
					$saveData['record']['max'] += $v['count'];
			}
		//	print_r($saveData);
			self::set_source_chart_data(date('Y-m-d',$prevTime),$domain['domain'],$saveData);
		}
		return true;
	}
	
}