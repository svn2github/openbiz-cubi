<?php
include_once MODULE_PATH.'/changelog/form/ChangeLogNoCommentForm.php';
class CalendarForm extends ChangeLogNoCommentForm
{
	public $CalendarDefaultView ;
	public $m_DayRange;
	public $m_DayStart;
	
	protected $_renderedEvents = array();
	
	protected function readMetadata(&$xmlArr)
    {        
        parent::readMetaData($xmlArr);
    	$this->CalendarDefaultView = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CALENDARDEFAULTVIEW"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CALENDARDEFAULTVIEW"] : null;
        if(!$this->m_DayStart)
        {
        	$this->m_DayStart =date('Y-m-d H:i:s');
        }
    }
    
    public function UpdateDateRange($viewMode , $startTime)
    {
    	$start_time = date('Y-m-d',$startTime);
    	if($this->m_DayStart ==  $start_time)
    	{
    		return ;
    	}
    	
    	$this->m_DayStart =  $start_time;
    	$this->updateForm();   	
    }
    
	public function UpdateViewName($name,$dayStart){
		$this->CalendarDefaultView = $name;
		if($dayStart>0){
			$this->m_DayStart = date('Y-m-d H:i:s',$dayStart);		
		}				
		return ;
	}
    
	public function getSessionVars($sessionContext)
    {
    	parent::getSessionVars($sessionContext);
        $sessionContext->getObjVar($this->m_Name, "CalendarDefaultView", $this->CalendarDefaultView);
        $sessionContext->getObjVar($this->m_Name, "DayStart", $this->m_DayStart);
    }

    /**
     * Save object variable to session context
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function setSessionVars($sessionContext)
    {
    	parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar($this->m_Name, "CalendarDefaultView", $this->CalendarDefaultView);
        $sessionContext->setObjVar($this->m_Name, "DayStart", $this->m_DayStart);
    }	
	
    public function outputAttrs()
    {
    	$result = parent::outputAttrs();
    	$result['defaultView'] = $this->CalendarDefaultView;
    	$result['dayRange'] = $this->m_DayRange;
    	$result['dayStart'] = $this->m_DayStart;    
    	$result['calYear'] = date('Y',strtotime($this->m_DayStart));
    	if(date('j',time())>=15){
	    	$result['calMonth'] = (int)date('m',strtotime($this->m_DayStart));	    	
    	}else{
    		$result['calMonth'] = (int)date('m',strtotime($this->m_DayStart))-1;
	    	if($result['calMonth']<1){
	    		$result['calMonth']=1;
	    	}
    	}
    	$result['calDay'] = (int)date('d',strtotime($this->m_DayStart));
    	$result['defaultView'] = $this->CalendarDefaultView;
    	//$result['events'] = $this->renderEvents(false);
    	return $result;
    }
    
    public function processBDOException($e)
    {
        $errorMsg = $e->getMessage();
        BizSystem::log(LOG_ERR, "DATAOBJ", "DataObj error = ".$errorMsg);
        BizSystem::clientProxy()->showClientAlert($errorMsg);
        $this->rerender();;   //showErrorMessage($errorMsg);
    }
        
    public function outputEvents()
    {
		$outputArr=array();
    	$time_range_start = date('Y-m-d H:i:s',$_POST['start']);
    	$time_range_end = date('Y-m-d H:i:s',$_POST['end']);
    	
    	$range = ceil(($_POST['end'] - $_POST['start']) / 86400);
    	$this->m_DayStart = $time_range_start;
    	$this->m_DayRange = $range;
    	
    	$dataObj = $this->getDataObj();        
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        
        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();

        if ($this->m_FixSearchRule)
        {
            if ($this->m_SearchRule)
                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }
        else
            $searchRule = $this->m_SearchRule;
		
    	if($searchRule)
		{
			$searchRule .= " AND ";
		}
        $searchRule .= " [recurrence]='0' AND ([end_time]>'$time_range_start' AND [start_time]<'$time_range_end')";
        //var_dump($searchRule);
        $dataObj->setSearchRule($searchRule);
    	$eventRecs = $dataObj->fetch();

    	
    	$eventCount = $eventRecs->count();    	
    	//process single events
    	
    	foreach ($eventRecs as $eventRec)
    	{    		    		
    		$outputArr[]=$this->renderSingleEventArr($eventRec); 		    		    		
    	}
    	//process repeat events
    	$searchRule = "";
    	$dataObj = $this->getDataObj();        
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        
        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();

        
        $searchRule = $this->m_SearchRule;
		if($searchRule)
		{
			$searchRule .= " AND ";
		}
        $searchRule .= " [recurrence]!='0'";
        $dataObj->setSearchRule($searchRule);
    	$eventRecs = $dataObj->fetch();    	
    	//$eventRecs = $this->getDataObj()->directFetch("[recurrence]!='0'");
    	$eventCount = $eventRecs->count();
    	 
    	foreach ($eventRecs as $eventRec)
    	{     		   
    		$outputRecArr=$this->renderRepeatEventArr($eventRec);
    		$outputArr = array_merge($outputArr,$outputRecArr); 	    		
    	}    	
    	$output = json_encode($outputArr);
    	echo $output;
    	exit;    	
    }
    
    
    public function renderEvents(){
    	$output = "";
    	$time_range_start = date('Y-m-d H:i:s',strtotime($this->m_DayStart) -86400);;
    	$time_range_end = date('Y-m-d H:i:s',strtotime($this->m_DayStart) + (86400 * ($this->m_DayRange+1)));
    	
    	$dataObj = $this->getDataObj();        
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        
        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();

        if ($this->m_FixSearchRule)
        {
            if ($this->m_SearchRule)
                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }
        else
            $searchRule = $this->m_SearchRule;
		
    	if($searchRule)
		{
			$searchRule .= " AND ";
		}
        $searchRule .= " [recurrence]='0' AND ([end_time]>'$time_range_start' AND [start_time]<'$time_range_end')";
        //var_dump($searchRule);
        $dataObj->setSearchRule($searchRule);
    	$eventRecs = $dataObj->fetch();

    	
    	$eventCount = $eventRecs->count();
    	$i=0;
    	//process single events
    	foreach ($eventRecs as $eventRec)
    	{    		
    		$output.= $this->renderSingleEvent($eventRec);   
    		$this->_renderedEvents[$eventRec['Id']]=true;    		
    		if($eventCount>0 && $i!=$eventCount-1){
    			$output.=",\n";
    		}
    		$i++; 		    		    		
    	}
    	//process repeat events
    	$searchRule = "";
    	$dataObj = $this->getDataObj();        
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        
        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();

        
        $searchRule = $this->m_SearchRule;
		if($searchRule)
		{
			$searchRule .= " AND ";
		}
        $searchRule .= " [recurrence]!='0'";
        $dataObj->setSearchRule($searchRule);
    	$eventRecs = $dataObj->fetch();    	
    	//$eventRecs = $this->getDataObj()->directFetch("[recurrence]!='0'");
    	$eventCount = $eventRecs->count();
    	if($eventCount && $output!=''){
    		$output.=",\n";
    	}
    	$i=0;
    	foreach ($eventRecs as $eventRec)
    	{ 
    		$output.= $this->renderRepeatEvent($eventRec);   
    		if($i!=$eventCount-1){
    			$output.=",\n";
    		}
    		$i++;
    	}
    	
    	return $output;
    }

	protected function renderSingleEventArr($eventRec)
    {
    	$eventArr = array();    	    	
    	$eventArr['id'] 	= $eventRec['Id'];
    	$eventArr['ui_id'] 	= 'event_'.$eventRec['Id'];
    	$eventArr['title'] 	= $eventRec['subject'];
    	$eventArr['location'] = $eventRec['location'];
    	$eventArr['description'] = str_replace("\n",'',nl2br($eventRec['description']));
    	$eventArr['start'] = $eventRec['start_time'];
    	$eventArr['end'] = $eventRec['end_time'];
    	$eventArr['borderColor'] = '#DDDDDD';
    	$eventArr['allDay'] = (bool)$eventRec['all_day'];    	
        if($eventRec['type_color']){
    			$eventArr['backgroundColor'] = '#'.$eventRec['type_color'];
    			$eventArr['textColor'] = '#666666';    			
    	}else{   
    			$eventArr['backgroundColor'] = '#0f9acb';
    			$eventArr['textColor'] = '#FFFFFF';    			
    	}        	
    	return $eventArr;
    }    
    
	protected function renderSingleEvent($eventRec)
    {
    	if($eventRec['type_color']){
    			$colorOpt = "
    			backgroundColor: '#".$eventRec['type_color']."',
				textColor: '#666666',
    			";
    	}else{    		
    			$colorOpt = "
    			backgroundColor: '#0f9acb',
				textColor: '#FFFFFF',
    			";
    	}
    	$output =  "
    		{
				id: ".$eventRec['Id'].",
				ui_id: 'event_".$eventRec['Id']."',
				title: '".addslashes($eventRec['subject'])."',
				location: '".addslashes($eventRec['location'])."',
				description: '".addslashes(str_replace("\n",'',nl2br($eventRec['description'])))."',
				start: '".$eventRec['start_time']."',
				end: '".$eventRec['end_time']."',
				$colorOpt
				borderColor: '#DDDDDD',
				allDay: ".$this->Value2Bool($eventRec['all_day'])."
			}";
    	return $output;
    }

 	protected function renderRepeatEventArr($eventRec)
    {    	
    	$eventRecs = $this->generateRepeatEvents($eventRec);
    	$eventRecsArr = array();
    	foreach($eventRecs as $key=>$eventRec){    		
    		$eventRecsArr[] = $this->renderSingleEventArr($eventRec);
    	}    	
    	return $eventRecsArr;
    }
        
    protected function renderRepeatEvent($eventRec)
    {
    	$eventRecs = $this->generateRepeatEvents($eventRec);
    	foreach($eventRecs as $key=>$eventRec){    		
    		$output.= $this->renderSingleEvent($eventRec).",\n";
    	}    	
    	return $output;
    }
    
    public function generateRepeatEvents($eventRec){
		$eventRecs = array();
    	
    	$dayRange = $this->m_DayRange;
    	$dayStart = $this->m_DayStart;
    	
    	switch($this->CalendarDefaultView){
    		case "month":
        	case "week":
        	case "basicWeek":
        	case "agendaWeek":    			
    			$dayRange = $dayRange+20;
    			$dayStart = date('Y-m-d H:i:s',strtotime($dayStart)-86400*10);
    			break;
    		
    	}    	
    	
    	for($i=0;$i<=$dayRange;$i++){
    		$new_date = date('Y-m-d',strtotime($dayStart) + 86400*$i);
    	//var_dump($new_date."<br/>");
	    	switch($eventRec['recurrence'])
	    	{
	    		case "1":	
	    			//Daily
	    			$test_part = '-';		
	    			$part_value = date('Y-m-d',strtotime($new_date));
	    			$new_start_time	= date($part_value." H:i:s",strtotime($eventRec['start_time']));
	    			$new_end_time	= date($part_value." H:i:s",strtotime($eventRec['end_time']));
	    			break;
	    		case "2":	
	    			//Weekly    	
	    			$test_part = 'N';  
	    			$part_value = date('Y-m-d',strtotime($new_date));
	    			$new_start_time	= date($part_value." H:i:s",strtotime($eventRec['start_time']));
	    			$new_end_time	= date($part_value." H:i:s",strtotime($eventRec['end_time'])); 			
	    			break;
	    		case "3":
	    			//Monthly
	    			$test_part = 'd';
	    			$part_value = date('Y-m',strtotime($new_date));
	    			$new_start_time	= date($part_value."-d H:i:s",strtotime($eventRec['start_time']));
	    			$new_end_time	= date($part_value."-d H:i:s",strtotime($eventRec['end_time']));
	    			break;
	    		case "4":
	    			//Annually
					$test_part = 'm-d';	
					$part_value = date('Y',strtotime($new_date));
	    			$new_start_time	= date($part_value.'-m-d'." H:i:s",strtotime($eventRec['start_time']));
	    			$new_end_time	= date($part_value.'-m-d'." H:i:s",strtotime($eventRec['end_time']));    			     			
	    			break;
	    	}
	    	if(  date($test_part,strtotime($new_date)) == date($test_part,strtotime($eventRec['start_time'])) || 
	    		 date($test_part,strtotime($new_date)) == date($test_part,strtotime($eventRec['end_time']))
	    	)
	    	{	    			    		
	    		$newEventRec = $eventRec; 
	    		$newEventRec['start_time'] 	= $new_start_time;
	    		$newEventRec['end_time'] 	= $new_end_time;
	    		$eventRecs[$newEventRec['Id'].'_'.$newEventRec['start_time']] = $newEventRec;
	    		//echo "repeat !!! <br/>";
	    	}
    	}	
    	return $eventRecs;        	
    }
    
    protected function Value2Bool($value)
    {
    	if($value)
    	{
    		return 'true';
    	}
    	else
    	{
    		return 'false';	
    	}
    }
    
    public function UpdateRecord()
    {
    	$id = BizSystem::clientProxy()->getFormInputs('_selectedId');
    	$updateType 	= BizSystem::clientProxy()->getFormInputs('updateType');
    	$dayDelta 		= BizSystem::clientProxy()->getFormInputs('dayDelta');
    	$minuteDelta 	= BizSystem::clientProxy()->getFormInputs('minuteDelta');
    	$allDay			= BizSystem::clientProxy()->getFormInputs('allDay');
        $currentRec = $this->getDataObj()->FetchById($id);
        $currentRec = $currentRec->toArray();
    
       
        switch($updateType)
        {
        	case "eventDrop":
        		if($allDay=='true')
        		{
        			$recArr['all_day']='1';
        		}else{
        			$recArr['all_day']='0';
        		} 
        		$start_time = strtotime($currentRec['start_time']);        		
        		$start_time += ($dayDelta*86400 + $minuteDelta*60);        		
        		$recArr['start_time'] = date('Y-m-d H:i:s',$start_time);
        		
        	case "eventResize":
        		$end_time = strtotime($currentRec['end_time']);
        		$end_time += ($dayDelta*86400 + $minuteDelta*60);
        		$recArr['end_time'] = date('Y-m-d H:i:s',$end_time);
        		break;
        }
	
        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();    	
    }
    
	public function deleteRecord($id=null)
    {


        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {        	
            $dataRec = $this->getDataObj()->fetchById($id);
            
            if(!$this->canDeleteRecord($dataRec))
            {
            	$this->m_ErrorMessage = $this->getMessage("FORM_OPEATION_NOT_PERMITTED",$this->m_Name);         
        		if (strtoupper($this->m_FormType) == "LIST"){
        			BizSystem::log(LOG_ERR, "DATAOBJ", "DataObj error = ".$errorMsg);
        			BizSystem::clientProxy()->showClientAlert($this->m_ErrorMessage);
        			$this->rerender();
        		}else{
        			$this->processFormObjError(array($this->m_ErrorMessage));	
        		}	
        		return;
            }
            
            // take care of exception
            try
            {
                $dataRec->delete();
            } catch (BDOException $e)
            {
                // call $this->processBDOException($e);
                $this->processBDOException($e);
                return;
            }
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
    }
}
?>