<?php
include_once dirname(__FILE__).'/php-ofc-library/open-flash-chart.php';
class chart_maker {
	protected $unitTimeCount = 3;
	public function __construct(){
		
	}
	
	//线形图用于显示多天的信息
	public function make_line_chart($startTime , $endTime , $dataRecord , $dataPlay){
		
		$colorBlue = '#0000FF';
		$colorRed = '#FF0000';
		
		//定义时间区间，用于对数据进行分组
		$barTimeArray = array();
		for($i = 0 ;$i <= ($endTime - $startTime)/86400 ; $i=$i+1){
		//	$XLabels[] = date('Y-m-d',$startTime + $i*86400);
			$barTimeArray[] = array('start'=>$startTime+$i*86400 , 'end'=>$startTime+($i+1)*86400 );
		//	$XLabels[] = date('H:i',$start + $i*3600);//.'-'.date('H:i',$start + ($i+1)*3600);
		}
		
		$pointStep = max(1 , intval(count($barTimeArray)/8));
		
		//X轴相关
		$x = new x_axis();
		$x->set_range($startTime , $startTime+(count($barTimeArray)-1)*86400);
		$x->set_steps(86400);
		$x->set_stroke(0);
		$x->grid_colour('#E5E5E5');
		$labels = new x_axis_labels();
		// tell the labels to render the number as a date:
		$labels->text('#date:Y-m-d#');
		// generate labels for every day
		$labels->set_steps(86400);
		// only display every other label (every other day)
		$labels->visible_steps($pointStep);
		
		// finally attach the label definition to the x axis
		$x->set_labels($labels);
		
		
		
		$recordLineData = array();
		$playLineData = array();
				
		
		//录制折线图
		$i =0 ;
		
		$yMax = 0;
		
		foreach($barTimeArray as  $k => $record){
			$count = 0;
			foreach($dataRecord as $data){
				if(intval($data['time']) >= $record['start'] && intval($data['time']) < $record['end']){
					$count += intval($data['count']);
				}
			}
			$point = new hollow_dot();
			$point->position($record['start'] , $count);
			if($i%$pointStep == 0){
				$point->size(3);
			}else{
				$point->size(2);
			}
			$recordLineData[] = $point;
			$yMax = max($count , $yMax);
		//	$tagRecords->append_tag(new ofc_tag($i-0.2, $count));
			$i++;
			
		}
		
		
		$i =0 ;
		//播放柱状图
		foreach($barTimeArray as  $k => $record){
			$count = 0;
			foreach($dataPlay as $data){
				if(intval($data['time']) >= $record['start'] && intval($data['time']) < $record['end']){
					$count += intval($data['count']);
				}
			}
			$point = new hollow_dot();
			$point->position($record['start'] , $count);
			if($i%$pointStep == 0){
				$point->size(3);
			}else{
				$point->size(2);
			}
			$playLineData[] = $point;
			$yMax = max($count , $yMax);
		//			if($count == 0){
		//		$tagPlays->append_tag(new ofc_tag($i+0.2, $count));
		//			}
			$i++;
		}
		
		
		$def = new hollow_dot();
		$def->size(3)->halo_size(1)->tooltip('播放许可: #val#<br>#date:Y-m-d H:i#');
		
		$def2 = new hollow_dot();
		$def2->size(3)->halo_size(1)->tooltip('录制许可: #val#<br>#date:Y-m-d H:i#');
		
		$line = new line(); 
//		$line->set_colour('#FF0000');
		$line->set_values($playLineData);
		$line->set_colour($colorBlue);
		$line->set_key('播放',12);
		$line->set_default_dot_style( $def );
		$line->on_show(new line_on_show('mid-slide',0,0));
		
		$line2 = new line();
		$line2->set_colour($colorRed);
		$line2->set_key('录制',12);
		$line2->set_values($recordLineData);
		$line2->set_default_dot_style( $def2 );
		$line2->on_show(new line_on_show('mid-slide',0,0.5));
		
		$yMax =  ceil($yMax*1.2/10)*10;
		
		$yMax = max($yMax , 10);
		
		$y = new y_axis();
		$y->set_stroke(0);
		$y->set_grid_colour('#E5E5E5');
		$y->set_range( 0, $yMax , intval($yMax/5) ); 
		
		$chart = new open_flash_chart();
		$chart->set_bg_colour( '#FFFFFF' );
		//$title = new title( '资源走势图');
		//$chart->set_title( $title );
		$chart->add_element( $line );
		$chart->add_element( $line2 );
		$chart->set_x_axis( $x );
		$chart->set_y_axis( $y );
		
		return $chart->toPrettyString();
		
				
	}
	
	public function set_unit_time_count($count){
		$this->unitTimeCount = $count;
	}
	
	//柱状图只用于显示一天的信息,以小时为单位
	public function make_bar_chart($startTime , $endTime , $dataRecord , $dataPlay){
		//X轴相关
		$x = new x_axis();
		//根据起始和结束时间，计算X轴显示内容
		$XLabels = array();
		
		$colorBlue = '#0000FF';
		$colorRed = '#FF0000';
		
		//值标签，显示在柱形图上边
		$tagRecords = new ofc_tags();
		$tagPlays = new ofc_tags();
		
		$tagRecords->font("Verdana", 10)->colour($colorRed)->align_x_center()->text('#y#');
		$tagPlays->font("Verdana", 10)->colour($colorBlue)->align_x_center()->text('#y#');
		
		$barTimeArray = array();
		for($i = 0 ;$i < floor(($endTime - $startTime)/3600) ; $i=$i+$this->unitTimeCount){
			$XLabels[] = date('H:i',$startTime + $i*3600).'-'.date('H:i',$startTime + ($i+$this->unitTimeCount)*3600);
			$barTimeArray[] = array('start'=>$startTime+$i*3600 , 'end'=>$startTime+($i+$this->unitTimeCount)*3600 -1 );
		//	$XLabels[] = date('H:i',$start + $i*3600);//.'-'.date('H:i',$start + ($i+1)*3600);
		}
		
		$XLabelsObject = new x_axis_labels();
		$XLabelsObject->set_labels($XLabels);
		$x->set_labels($XLabelsObject);
//		$x->set_offset(true);
		$x->set_stroke(1);
		$x->grid_colour('#E5E5E5');
		$x->set_steps(1);
		
		
		$recordBarData = array();
		$playBarData = array();
		
		//录制柱状图
		$i =0 ;
		foreach($barTimeArray as  $k => $record){
			$count = 0;
			foreach($dataRecord as $data){
				if(intval($data['time']) >= $record['start'] && intval($data['time']) <= $record['end']){
					$count += intval($data['count']);
				}
			}
			$recordBarData[] = $count;
//			if($count == 0){
			$tagRecords->append_tag(new ofc_tag($i+0.2, $count));
//			}
			$i++;
			
		}
		
		$i =0 ;
		//播放柱状图
		foreach($barTimeArray as  $k => $record){
			$count = 0;
			foreach($dataPlay as $data){
				if(intval($data['time']) >= $record['start'] && intval($data['time']) <= $record['end']){
					$count += intval($data['count']);
				}
			}
			$playBarData[] = $count;
//			if($count == 0){
				$tagPlays->append_tag(new ofc_tag($i-0.2, $count));
//			}
			$i++;
		}
		$barPlay = new bar_glass();
		$barPlay->set_key('播放',12);
		$barPlay->set_colour($colorBlue);
		$barPlay->set_values( $playBarData );
		$barPlay->set_tooltip('播放许可使用数量: #val#');
		$barPlay->set_on_show(new bar_on_show('grow-up',0.5,0));
		
		$barRecord = new bar_glass();
		$barRecord->set_key('录制',12);
		$barRecord->set_colour($colorRed);
		$barRecord->set_values( $recordBarData );
		$barRecord->set_tooltip('录制许可使用数量: #val#');
		$barRecord->set_on_show(new bar_on_show('grow-up',0.5,0.5));
	
		//$bar2->colour = '#DB1750';
		
		//Y轴相关
		$y = new y_axis();
		$y->set_stroke(0);
		$y->set_grid_colour('#E5E5E5');
		
		$yMax = 0;
		foreach($recordBarData as $d1){
			$yMax = max($yMax,$d1);
		}
		foreach($playBarData as $d2){
			$yMax = max($yMax,$d2);
		}
		
		$yMax =  ceil($yMax*1.2/10)*10;
		
		$yMax = max($yMax , 10);
		
		$y->set_range( 0, $yMax , intval($yMax/5) ); 
		
		$chart = new open_flash_chart();
		$chart->set_bg_colour('#FFFFFF');
		//$chart->set_title( $title );
		$chart->add_element( $barPlay );
		$chart->add_element( $barRecord );
		$chart->add_element( $tagPlays );
		$chart->add_element( $tagRecords );
		$chart->set_x_axis($x);
		$chart->set_y_axis($y);
		
		return $chart->toPrettyString();
	}
	
}