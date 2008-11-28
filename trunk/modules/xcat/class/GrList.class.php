<?php

class Xcat_GrList
{
	var $mGr = array();

	/**
	 * @private
	 * constructor
	 */
	function Xcat_TreeObject($gr_id=0)
	{
		$handler =& xoops_getmodulehandler('gr', 'xcat');
		$this->mGr =& $handler->getObjects();
	}

	/**
	 * @public
	 */
	function getList()
	{
		foreach(array_keys($this->mGr) as $key){
			$list['gr_id'][$key] = $this->mGr[$key]->get('gr_id');
			$list['gr_title'][$key] = $this->mGr[$key]->get('gr_title');
			$list['actions'][$key] = unserialize($this->mGr[$key]->get('actions'));
			return $list;
		}
	}


}
?>