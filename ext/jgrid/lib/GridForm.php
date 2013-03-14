<?php
/**
 * GridForm class
 *
 * @package cubi.jgrid.lib
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class GridForm extends ListForm
{
	protected $m_DirectMethodList = array('getdata','editrecord','copyrecord','deleterecord','removerecord','runsearch','switchform','loaddialog'); 

	public function getData()
	{
		$page = $_GET['page']; // get the requested page 
		$limit = $_GET['rows']; // get how many rows we want to have into the grid 
		$sidx = $_GET['sidx']; // get index row - i.e. user click to sort 
		$sord = $_GET['sord']; // get the direction
		if(!$sidx) $sidx =1;
		
		$dataObj = $this->getDataObj();
        if (!$dataObj) return;
   
		if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();
			
		$dataObj->setLimit($limit, ($page-1)*$limit);
		
		$sortRule = "[$sidx] $sord";
        if($sortRule && $sortRule != $this->getDataObj()->m_SortRule)
        {
			$dataObj->setSortRule($sortRule);
        }          
        $resultRecords = $dataObj->fetch();
        $this->m_TotalRecords = $dataObj->count();
        if ($limit && $limit > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$limit);
        
        //if current page is large than total pages ,then reset current page to last page
        if($page>$this->m_TotalPages && $this->m_TotalPages>0)
        {
        	$page = $this->m_TotalPages;
        	$dataObj->setLimit($limit, ($page-1)*$limit);
        	$resultRecords = $dataObj->fetch();
        }
		//print_r($resultRecords->toArray());
		$this->m_RecordId = $resultRecords[0]["Id"];
		
		$responce->page = $page; 
		$responce->total = $this->m_TotalPages; 
		$responce->records = $this->m_TotalRecords; 
		$i=0; 
		foreach ($resultRecords as $rec) { 
			$responce->rows[$i]['id'] = $rec['Id']; 
			$responce->rows[$i]['cell'] = array($rec['Id'],$rec['title'],strip_tags($rec['description'])); 
			$i++; 
		} 
		echo json_encode($responce);
	}
	
	public function fetchDataSet() {}
	
	public function fetchData() {}
}
?>
