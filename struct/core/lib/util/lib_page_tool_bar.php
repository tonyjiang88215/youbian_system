<?php
class pager_tool_bar
{
	public $offsetCount = null;
	
	public function __construct($totalItemCount,$offset = 0,$step = 20)
	{
		$this->offset = (int)$offset;
		$this->step   = (int)$step;
		$this->totalItemCount=(int)$totalItemCount;
		$this->set_param_name('offset');
		global $CFG;
		$this->CFG = $CFG;
	}
	public function set_param_name($paramName)
	{
		$this->pagerParamName = $paramName;
	}
	public function get_total_item_count()
	{
		return $this->totalItemCount;
	}
	public function get_offset_count()
	{
		if(! $this->offsetCount)
		{
			$this->offsetCount = ceil($this->get_total_item_count() / $this->step);
		}
		return $this->offsetCount;
	}

	public function get_previous_offset()
	{
		$previousOffset = $this->offset - $this->step;
		if($previousOffset >= 0)
		{
			return $previousOffset;
		}
		else
		{
			return false;
		}
	}

	public function get_next_offset()
	{
		$nextOffset = $this->offset + $this->step;
		if($nextOffset < $this->get_total_item_count())
		{
			return $nextOffset;
		}
		else
		{
			return false;
		}
	}

	public function get_first_offset()
	{
		return 0;
	}

	public function get_last_offset()
	{
		return (int)($this->get_offset_count() - 1) * $this->step;
	}

	public function get_offset_list()
	{
		$offsetList = array();
		for($i=0,$currentOffset=0,$offsetCount=$this->get_offset_count();
		$i < $offsetCount;
		$i++)
		{
			$offsetList[] = $currentOffset;
			$currentOffset = $currentOffset + $this->step;
		}
		return $offsetList;
	}

public function disp_pager_tool_bar($url,$linkMax = 10)
	{
		$startPage = $this->get_first_offset();
		$previousPage = $this->get_previous_offset();
		$pageList = $this->get_offset_list();
		$nextPage = $this->get_next_offset();
		$endPage = $this->get_last_offset();
		if(strrpos($url,'?') === false)
		{
			$url .='?'.$this->pagerParamName.'=';
		}
		else
		{
			$url .='&amp;'.$this->pagerParamName.'=';
		}
		$output = "\n\n"
		.'<div class="pager_container	">'."\n"
		.'<span class="">'."\n";

		if($previousPage !== false)
		{
			$output .=
			'<a class="page_list_first" href="'.$url.$startPage.'" offset='.$startPage.' >首页</a>&nbsp;'
			.'<a class="page_list_prev" href="'.$url.$previousPage.'" offset='.$previousPage.' >上页</a>'
			;
		}
		else
		{
			$output .=
			'<a class="page_list_first" href="javascript:void(0);" offset='.$startPage.' >首页</a>&nbsp;'
			.'<a class="page_list_prev" href="javascript:void(0);" offset='.$previousPage.' >上页</a>'
			;
		}
		$output .= "\n"
		.'</span>'."\n"
		.'<span class="">'."\n";

		$currentPage = (int)$this->offset / $this->step;

		$pageCount = $this->get_offset_count();

		if($currentPage > $linkMax)
		{
			$firstLink = $currentPage -$linkMax;
		}
		else
		{
			$firstLink = 0;
		}

		if($currentPage + $linkMax < $pageCount)
		{
			$lastLink = $currentPage + $linkMax;
		}
		else
		{
			$lastLink =$pageCount;
		}
		if($firstLink > 0)
		{
			$output .= '<a class="page_list_index" href="'.$url.$pageList[0].'" offset='.$pageList[0].' >'.(0+1).'</a>';
			if($firstLink > 1)
			{
				$output .= '<a>...</a>';
			}
		}

		if( $pageCount > 1)
		{
			for($link=$firstLink;$link<$lastLink;$link++)
			{
				if($currentPage == $link)
				{
					$output .= '<a class="pager_current" href="'.$url.$pageList[$link].'" offset='.$pageList[$link].' >'.($link+1).'</a>';
				}
				else
				{
					$output .= '<a class="page_list_index" href="'.$url.$pageList[$link].'" offset='.$pageList[$link].' >'.($link+1).'</a>';
				}
			}
		}
		if($lastLink < $pageCount)
		{
			if($lastLink + 1 < $pageCount)
			{
				$output .= '<a class="page_orz">...</a>';
			}
			$output .= '<a class="page_list_index" href="'.$url.$pageList[$pageCount-1].'" offset='.$pageList[$pageCount-1].' >'.($pageCount).'</a>';
		}

		$output .= "\n"
		. '</span>'."\n"
		. '<span class="">'."\n";
		if($nextPage !== false)
		{
			$output .=
			  '<a class="page_list_next" href="'.$url.$nextPage.'" offset='.$nextPage.' >下页</a>&nbsp;'
			. '<a class="page_list_last" href="'.$url.$endPage.'" offset='.$endPage.' > 尾页</a>'
			;
		}
		else
		{
			$output .=
			  '<a class="page_list_next" href="javascript:void(0);" offset='.$nextPage.' >下页</a>&nbsp;'
			. '<a class="page_list_last" href="javascript:void(0);" offset='.$endPage.' > 尾页</a>'
			;
		}

		$output .= "\n"
		. '</span>'."\n"
		.'</div>'."\n\n"
		;
		
		return $output;

	}
	public function ajax_pager_tool_bar($url,$linkMax = 10)
	{
		$startPage = $this->get_first_offset();
		$previousPage = $this->get_previous_offset();
		$pageList = $this->get_offset_list();
		$nextPage = $this->get_next_offset();
		$endPage = $this->get_last_offset();
		if(strrpos($url,'?') === false)
		{
			$url .='?'.$this->pagerParamName.'=';
		}
		else
		{
			$url .='&amp;'.$this->pagerParamName.'=';
		}
		$output = "\n\n"
		.'<div id="page_list">'."\n"
		.'<span class="">'."\n";

		if($previousPage !== false)
		{
			$output .='<b>'
			.'<a href="'.$url.$startPage.'" onclick="getFriendList(\''.$url.'\',\''.$startPage.'\');return false;"><img src="'.$CFG['webRoot'].'/pic/page_list/first.png" /></a>&nbsp;'
			.'<a href="'.$url.$previousPage.'" onclick="getFriendList(\''.$url.'\',\''.$previousPage.'\');return false;"><img src="'.$CFG['webRoot'].'/pic/page_list/prev.png" /></a>'
			.'</b>'
			;
		}
		else
		{
			$output .= '&nbsp;';
		}
		$output .= "\n"
		.'</span>'."\n"
		.'<span class="">'."\n";

		$currentPage = (int)$this->offset / $this->step;

		$pageCount = $this->get_offset_count();

		if($currentPage > $linkMax)
		{
			$firstLink = $currentPage -$linkMax;
		}
		else
		{
			$firstLink = 0;
		}

		if($currentPage + $linkMax < $pageCount)
		{
			$lastLink = $currentPage + $linkMax;
		}
		else
		{
			$lastLink =$pageCount;
		}
		if($firstLink > 0)
		{
			$output .= '<a href="'.$url.$pageList[0].'" onclick="getFriendList(\''.$url.'\',\''.$pageList[0].'\');return false;">'.(0+1).'</a>&nbsp;';
			if($firstLink > 1)
			{
				$output .= '...&nbsp;';
			}
		}

		if( $pageCount > 1)
		{
			for($link=$firstLink;$link<$lastLink;$link++)
			{
				if($currentPage == $link)
				{
					$output .= '<b>'.($link + 1).'</b>';
				}
				else
				{
					$output .= '<a href="'.$url.$pageList[$link].'" onclick="getFriendList(\''.$url.'\',\''.$pageList[$link].'\');return false;">'.($link+1).'</a>';
				}
			}
		}
		if($lastLink < $pageCount)
		{
			if($lastLink + 1 < $pageCount)
			{
				$out .= '...';
			}
			$output .= '&nbsp;<a href="'.$url.$pageList[$pageCount-1].'" onclick="getFriendList(\''.$url.'\',\''.$pageList[$pageCount-1].'\');return false;">'.($pageCount).'</a>';
		}

		$output .= "\n"
		. '</span>'."\n"
		. '<span class="">'."\n";

		if($nextPage !== false)
		{
			$output .= '<b>'
			. '<a href="'.$url.$nextPage.'" onclick="getFriendList(\''.$url.'\',\''.$nextPage.'\');return false;"><img src="'.$CFG['rootWeb'].'/pic/page_list/next.png" /></a>&nbsp;'
			. '<a href="'.$url.$endPage.'" onclick="getFriendList(\''.$url.'\',\''.$endPage.'\');return false;"><img src="'.$CFG['rootWeb'].'/pic/page_list/last.png" /></a>'
			. '</b>'
			;
		}
		else
		{
			$output .= '&nbsp;';
		}

		$output .= "\n"
		. '</span>'."\n"
		.'</div>'."\n\n"
		;

		return $output;




	}

}