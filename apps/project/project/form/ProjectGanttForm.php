<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class ProjectGanttForm extends ChangeLogForm
{
	public $m_ViewMode=0;
	public $m_print = 0;
	
	protected $m_outputIds = array();
	public function switchMode()
	{
	    $this->m_ViewMode = (int)BizSystem::clientProxy()->getFormInputs("fld_viewmode");
	    $this->rerender();
	}
	
	public function getSessionVars($sessionContext)
    {
        parent::getSessionVars($sessionContext);
    	$sessionContext->getObjVar($this->m_Name, "ViewMode", $this->m_ViewMode);
    }

    public function setSessionVars($sessionContext)
    {
    	parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar($this->m_Name, "ViewMode", $this->m_ViewMode);
    }	

    public function UpdateTaskTime(){
    	$id = BizSystem::clientProxy()->getFormInputs('_selectedId');
    	$start_time 	= BizSystem::clientProxy()->getFormInputs('start_time');
    	$duration 		= BizSystem::clientProxy()->getFormInputs('duration');
    	$move_child		= BizSystem::clientProxy()->getFormInputs('move_child');
    	
    	
    	$do = $this->getDataObj();
    	$currentRec = $do->FetchById($id);
        $currentRec = $currentRec->toArray();
    
       	//$recArr['Id'] = $currentRec['Id'];
        $recArr['start_time'] = date('Y-m-d H:i:s',$start_time);
       	$recArr['total_workhour'] = (int)$duration; 
		
       	//compute new finish_time
       	$svcObj = BizSystem::getObject("project.task.lib.TaskService");
       	
		$recArr['finish_time'] =  	$svcObj->genFinishTime($recArr['start_time'],$duration); 
		        	
        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;
        
        if($move_child == 'true'){
        	$time_diff = strtotime($recArr['start_time']) - strtotime($currentRec['start_time'])  ;
        	$this->updateDependTaskStartTime($id,$time_diff);
        	//$this->updateForm();
        }
        //$this->updateDependTaskStartTime($start_time);

        //$this->updateForm(); 
    }
    
    public function  updateDependTaskStartTime($task_id, $time_diff)
    {
    	$do = BizSystem::getObject("project.task.do.TaskSystemDO",1);
    	$baseSearchRule = $do->m_BaseSearchRule; 
    	$do->m_BaseSearchRule = null;
    	$tasklist = $do->directFetch("[dependency_task_id]=$task_id");
    	foreach($tasklist as $task){    		
    		$id = $task['Id'];
    		$sub_list = $do->directFetch("[dependency_task_id]=$id");    		    		            		
    		if($sub_list){
    			$this->updateDependTaskStartTime($id,$time_diff);
    		}
    			$old_start_time =  strtotime($task['start_time']);    			
    			$duration = $task['total_workhour'];
    			if($duration>=8){
		       		$date_add = (int)($duration/8) * 86400; 
		       	}
		       	$hour_add = fmod($duration,8) * 3600 + 8*3600;
				
    			$newRec['Id'] = $task['Id'];
    			$newRec['start_time'] = date('Y-m-d H:i:s', $old_start_time + $time_diff);
    			$newRec['finish_time'] = date('Y-m-d H:i:s',($old_start_time + $date_add + $hour_add)) ;
    			$do->updateRecord($newRec,$task);   
    	}
    	$do->m_BaseSearchRule = $baseSearchRule;
    	return ;
    }
    
	public function renderGantt()
	{
		
		header('Content-type: text/xml');		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<projects>";
		
		$projectDo = BizSystem::getObject("project.project.do.ProjectDO");

		$parentForm = BizSystem::getObject("project.project.form.ProjectFilterForm");
		$DefaultProject = $parentForm->m_RecordId;
		
		
		if($DefaultProject==null){
    		$parentForm = BizSystem::getObject("project.project.form.ProjectDetailBriefForm");
			$DefaultProject = $parentForm->m_RecordId;								
    	}
		$projectRecs = $projectDo->directfetch("[Id]='$DefaultProject'");
		
		$do = $this->getDataObj();
		$this->m_outputIds = array();
		foreach($projectRecs as $projectRec)
		{						
			
			$project_id = $projectRec['Id'];
			$projectRec['project_id'] =  $projectRec['Id'];
			$projectRec['project_name'] = $projectRec['name'];		
			$projectRec['project_color'] = $projectRec['type_color'];	
			$projectRec['project_start_time'] = date('Y,n,j',strtotime($projectRec['start_time']));				
 			
			
			if($this->m_ViewMode == 1) // show tree
			{
		        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
				
		        if ($this->m_FixSearchRule)
		        {
		            if ($this->m_SearchRule)
		                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
		            else
		                $searchRule = $this->m_FixSearchRule;
		        }
		        else
		            $searchRule = $this->m_SearchRule;
		
		        if($searchRule){
		        	$searchRule .= " AND [project_id]='".$project_id."' AND [PId]='0'";
		        }else{
		        	$searchRule = " [project_id]='".$project_id."'  AND [PId]='0'";
		        }				
		        
				$recTree = $do->fetchTree($searchRule, 5);
				foreach($recTree as $rec)
				{
					$this->prepareTaskNode($rec);
				}
				
				$tasks = $this->renderTaskTree($recTree);
				$recList = array();
				foreach($recTree as $rec)
				{
					$nodeRec = $rec->m_Record;
					$recList[]	= $nodeRec;
				}
				
				QueryStringParam::ReSet();
			}
			else
			{
				$recList = $this->fetchDataSet($project_id);	
				foreach($recList as $rec){
					$this->m_outputIds[] = $rec['Id'];	
				}				 		
				$tasks = $this->renderTaskList($recList);
			}
			
		 				
			echo "<project id = \"".$projectRec['project_id']."\" name = \"".$projectRec['project_name']."\" startdate = \"".$projectRec['project_start_time']."\" color=\"".$projectRec['project_color']."\">";	
			echo $tasks;
			echo "</project>";	
		}

		echo "</projects>";		
		exit;
		
	}
	
	public function getProjectStartTime($tasks){
		$start_time_arr = array();
		foreach($tasks as $task){
			$start_time_arr[] = strtotime($task['start_time']);
		}
		sort($start_time_arr,SORT_NUMERIC);				
		$start_time = date('Y,n,j',$start_time_arr[0]);
		return  $start_time;
	}
	
	public function renderTaskList($recList)
	{
		$output = "";
		foreach ($recList as $rec){
			$nodeRec = new stdClass();
			$nodeRec->m_Record = $rec;
			$output .= $this->renderTaskNode($nodeRec);
		}
		return $output;
	}
	
	public function renderTaskTree($recTree){
		$output = "";
		foreach($recTree as $rec)
		{
			$output .= $this->renderTaskNode($rec);
		}
		return $output;
	}
	
	public function prepareTaskNode($rec){
			if($rec->m_ChildNodes){				
				foreach($rec->m_ChildNodes as $childRec)
				{
					 $this->prepareTaskNode($childRec);
				}
			}		
			$taskRec = $rec->m_Record;
			$this->m_outputIds[] = $taskRec['Id'];	
	}
	
	public function renderTaskNode($rec){
			if($rec->m_ChildNodes){				
				foreach($rec->m_ChildNodes as $childRec)
				{
					$task_children .= $this->renderTaskNode($childRec);
				}
			}
		
			$taskRec = $rec->m_Record;			
			$task_id = $taskRec['Id'];
			$task_name = $taskRec['title'];
			$task_start_time = date('Y,n,j',strtotime($taskRec['start_time']));
			$task_time_budget = $taskRec['total_workhour'];
			$task_progress = $taskRec['progress'];
			$task_color = $taskRec['type_color'];
			if($taskRec['dependency_task_id']){
				if($this->checkTaskVisiable($taskRec['dependency_task_id'])){
					$task_dependency_id = $taskRec['dependency_task_id'];
				}else{
					$task_dependency_id = "";
				}
			}else{
				$task_dependency_id = "";
			}
			$taskXML = "
				<task id=\"$task_id\">
                    <name>$task_name</name>
              		<est>$task_start_time</est>
        	    	<duration>$task_time_budget</duration>
    	        	<percentcompleted>$task_progress</percentcompleted>
    	        	<color>$task_color</color>
        	    	<predecessortasks>$task_dependency_id</predecessortasks>
                    <childtasks>
						$task_children
                    </childtasks>
        	      </task>
        	";
			return $taskXML;
	}
	
	
	public function checkTaskVisiable($task_id){
		if(in_array($task_id, $this->m_outputIds)){
			return true;
		}else{
			return false;
		}	
	}
	
	public function fetchDataSet($project_id=null)
    {
    	if($project_id==null){
    		$parentForm = BizSystem::getObject("project.project.form.ProjectFilterForm");
			$project_id = $parentForm->m_RecordId;								
    	}
    	if($project_id==null){
    		$parentForm = BizSystem::getObject("project.project.form.ProjectDetailBriefForm");
			$project_id = $parentForm->m_RecordId;								
    	}
    	
    	
        $dataObj = $this->getDataObj();
        if (!$dataObj) return null;
        
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

        if($searchRule){
        	$searchRule .= " AND [project_id]='$project_id'";
        }else{
        	$searchRule = " [project_id]='$project_id'";
        }
        
        $dataObj->setSearchRule($searchRule);
        if($this->m_StartItem>1)
        {
            $dataObj->setLimit($this->m_Range, $this->m_StartItem);
        }
        else
        {
            $dataObj->setLimit($this->m_Range, ($this->m_CurrentPage-1)*$this->m_Range);
        }                
        $resultRecords = $dataObj->fetch();
        
        $this->m_TotalRecords = $dataObj->count();
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
        $selectedIndex = 0;
        
        //if current page is large than total pages ,then reset current page to last page
        if($this->m_CurrentPage>$this->m_TotalPages && $this->m_TotalPages>0)
        {
        	$this->m_CurrentPage = $this->m_TotalPages;
        	$dataObj->setLimit($this->m_Range, ($this->m_CurrentPage-1)*$this->m_Range);
        	$resultRecords = $dataObj->fetch();
        }
        
        $this->getDataObj()->setActiveRecord($resultRecords[$selectedIndex]);

        QueryStringParam::ReSet();

        return $resultRecords;
    }	
}
?>