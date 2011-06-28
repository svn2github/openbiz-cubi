<?php 
class HelpWidgetForm extends EasyForm
{
	protected $m_CategoryDO 		= "help.do.HelpCategoryDO";
	protected $m_CategoryMappingDO 	= "help.do.HelpCategoryMappingDO";
	
	protected function GetURL(){
		if($_SERVER["REDIRECT_QUERY_STRING"])
		{
			$url = $_SERVER["REDIRECT_QUERY_STRING"];
		}
		elseif(preg_match("/\?\/?(.*?)(\.html)?$/si", $_SERVER['REQUEST_URI'],$match))
		{
			//supports for http://localhost/?/user/login format
			//supports for http://localhost/index.php?/user/login format
			$url = $match[1];
		}
		elseif(strlen($_SERVER['REQUEST_URI'])>strlen($_SERVER['SCRIPT_NAME']))
		{
			//supports for http://localhost/index.php/user/login format
			$url = str_replace($_SERVER['SCRIPT_NAME'],"",$_SERVER['REQUEST_URI']);
			preg_match("/\/?(.*?)(\.html)?$/si", $url,$match);
			$url=$match[1];
		}else{
			// REQUEST_URI = /cubi/
			// SCRIPT_NAME = /cubi/index.php
			$url="";
		}
		if(preg_match("/^F=RPCInvoke/si",$url)){
			$url = "";
		}
		return $url;	
	}
	
	public function SetSearchRule(){
		$url = $this->GetURL();
		
		if(!$url){
			return ;
		}
		
		//search cat_id from mapping table
		$mappingObj  =  BizSystem::GetObject($this->m_CategoryMappingDO,1);
    	
		//@todo: $url need to be filtered before use in database
    	$records = $mappingObj->directFetch("[url]='$url'");
    	if(count($records)==1){
    		$cat_id = (int)$records[0]['cat_id'];
    	}
    	else
    	{
			//if no matched, generate record from category table url_match
			$categoryObj  =  BizSystem::GetObject($this->m_CategoryDO,1);
			$records = $categoryObj->directFetch();
			foreach($records as $record){  
				$match = $record['url_match'];
				if($match){
					
					$pattern = "/".str_replace('/','\\/',$match)."/si";
					$pattern = "@".$match."@si";
					if(preg_match($pattern,"/".$url)){
						$cat_id = $record['Id'];
						//cache it into database;
						$obj_array =array(	        				
							"cat_id"=>$cat_id,
	        				"url"=>$url,     				
	        				); 
						$mappingObj->insertRecord($obj_array);
						break;
					}
					
				}
				
			}
    	}
    	
    	$this->m_SearchRule="[category_id]='$cat_id'";
	}
	
	public function fetchDataSet(){
		$this->SetSearchRule();
		return parent::fetchDataSet();
	}
	
}
?>
