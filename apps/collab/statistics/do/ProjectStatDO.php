<?php 
class ProjectStatDO extends BizDataObj
{
	public function fetch()
	{

		if($this->m_SearchRule){
			$this->m_SearchRule = str_replace("[chart_type]  = :_v1", "", $this->m_SearchRule);		
		}
		$cond_list = BizSystem::getService(LOV_SERVICE)->getDictionary("collab.project.lov.ProjectLOV(ProjectCondition)");
		$resultSet = array();
		foreach($cond_list as $value=>$name)
		{			
			if($this->m_SearchRule)
			{
				$searchRule = $this->m_SearchRule."[condition]='$value'";
			}else{
				$searchRule = "[condition]='$value'";
			}
			$rows = parent::directFetch($searchRule);
			$record = array();
			$record['Id']		=$value;
			$record['condition']=$value;
			$record['cond_name']=$name;
			$record['cond_color']=$this->getCondColor($value);		
			$record['pri_0_count']=0;
			$record['pri_1_count']=0;
			$record['pri_2_count']=0;
				
			foreach($rows as $row)
			{
				$record['pri_'.$row['Id'].'_count']=$row['data_count'];
			}
			$resultSet[] = $record;
		}
		return $resultSet;
	}
	
	public function getCondColor($value)
	{
		switch ($value)
		{
			case "0":
				$code = "f42a36";
				break;
			case "1":
				$code = "ffd24c";
				break;
			case "2":
				$code = "939393";
				break;
		}
		return $code;
	}
	
}
?>