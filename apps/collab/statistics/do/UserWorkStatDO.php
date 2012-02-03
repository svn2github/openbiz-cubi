<?php 
class UserWorkStatDO extends BizDataObj
{
	public function fetch()
	{
		
		$params = QueryStringParam::getBindValues();
		if(preg_match("/\[group_id\]/si",$this->m_SearchRule) || is_numeric($params[':_v1'])){
			//$this->m_SearchRule = str_replace("AND [year] = :_v2 AND [month] = :_v3 AND [chart_type] = :_v4", "", $this->m_SearchRule);
			$this->m_SearchRule = "[group_id] = :_v1";		
		}
		
		
		foreach($params as $key=>$value)
		{
			if($key == ":_v4")
			{
				unset($params[':_v4']);
			}
			if($key == ":_v3")
			{
				$month=$params[':_v3'];
				unset($params[':_v3']);
			}
			if($key == ":_v2")
			{
				$year=$params[':_v2'];
				unset($params[':_v2']);
			}
		}						
		QueryStringParam::setBindValues($params);
		
		
		if($this->m_SearchRule && $year && $month){
			$start_time = $year.'-'.$month.'-01 00:00:00';
			$end_time =  $year.'-'.$month.'-'.date('t',strtotime($start_time)).' 23:59:59';
			$this->m_SearchRule .= " AND ([create_time]>'$start_time' AND [create_time]<'$end_time')";
		}
		$resultSet = parent::fetch();
		$newResultSet = array();
		foreach ($resultSet as $key=>$record)
		{
			$record["creator"] = BizSystem::getProfileName($record["Id"],'short');
			$newResultSet[] = $record;
		}
		return $newResultSet;
	}
}
?>