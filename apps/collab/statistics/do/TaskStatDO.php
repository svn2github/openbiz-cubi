<?php 
class TaskStatDO extends BizDataObj
{
	public function fetch()
	{

		if($this->m_SearchRule){
			$this->m_SearchRule = str_replace("[chart_type]  = :_v1", "", $this->m_SearchRule);		
		}
		$cond_list = BizSystem::getService(LOV_SERVICE)->getDictionary("collab.task.lov.TaskLOV(Severity)");
		$resultSet = array();
		foreach($cond_list as $value=>$name)
		{			
			if($this->m_SearchRule)
			{
				$searchRule = $this->m_SearchRule."[severity]='$value'";
			}else{
				$searchRule = "[severity]='$value'";
			}
			$rows = parent::directFetch($searchRule);
			$record = array();
			$record['Id']		=$value;
			$record['condition']=$value;
			$record['cond_name']=$name;
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
	

	
}
?>