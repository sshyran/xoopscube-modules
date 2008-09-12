<?php

class PageNavi
{
    var $total;
    var $offset;
    var $limit;
    
    function PageNavi($total, $offset, $limit) {
	$this->total = $total;
	$this->offset = $offset;
	$this->limit = $limit;
	
	if ($this->total <= $this->offset) {
	    $this->offset = 0;
	}
	if ($this->total <= $this->limit) {
	    $this->offset = 0;
	}
    }
    
    function need_prev_link()
    {
	if ($this->offset == 0) {
	    return false;
	} else {
	    return true;
	}
    }
    
    function need_next_link()
    {
	if ($this->total <= $this->offset + $this->limit) {
	    return false;
	} else {
	    return true;
	}
    }
    
    function get_prev()
    {
	if ($this->offset - $this->limit < 0) {
	    return 0;
	} else {
	    return $this->offset - $this->limit;
	}
    }
    
    function get_next()
    {
	if ($this->total < $this->offset + $this->limit) {
	    return $this->total - $this->limit;
	} else {
	    return $this->offset + $this->limit;
	}
    }
    
    function get_top()
    {
	return 0;
    }
    
    function get_last()
    {
	return $this->total - $this->limit;
    }
    
    function get_page_list()
    {
	if ($this->total <= $this->limit) {
	    return array();
	}
	
	$num_of_page = intval($this->total / $this->limit);
	if ($this->total % $this->limit) {
	    $num_of_page++;
	}
	$now_page = intval($this->offset / $this->limit) + 1;
	$list = array();
        
	for ($i=1; $i <= $num_of_page; $i++) {
	    if ($now_page == $i) {
		$list[$i] = '--';
	    } else {
		$list[$i] = $this->limit * ($i - 1);
	    }
	}
	
	return $list;
    }
}
