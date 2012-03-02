<?php 
include_once MODULE_PATH.'/changelog/form/ChangeLogForm.php';
class GanttForm extends ChangeLogForm
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
    	$sessionContext->getObjVar($this->m_Name, "ProjectID", $this->m_ProjectID);
    	$sessionContext->getObjVar($this->m_Name, "ProjectIDs", $this->m_ProjectIDs);
    }

    public function setSessionVars($sessionContext)
    {
    	parent::setSessionVars($sessionContext);
        $sessionContext->setObjVar($this->m_Name, "ViewMode", $this->m_ViewMode);
        $sessionContext->setObjVar($this->m_Name, "ProjectID", $this->m_ProjectID);
        $sessionContext->setObjVar($this->m_Name, "ProjectIDs", $this->m_ProjectIDs);
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
       	$svcObj = BizSystem::getObject("collab.task.lib.TaskService");
       	
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
    	$do = BizSystem::getObject("collab.task.do.TaskSystemDO",1);
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
    
    public function runSearch()
    {
    	if(strpos($_POST['fld_project'],";")){
    		$this->m_ProjectID=$this->earliestProjectId($_POST['fld_project']);
    	}else{
    		$this->m_ProjectID=$_POST['fld_project'];
    	}
    	$this->m_ProjectIDs=$_POST['fld_project'];
    	$result = parent::runSearch();
    }
    
    public function earliestProjectId($ids)
    {
    	$proj_ids = explode(";", $ids);
		$searchRule = " ( TRUE ";
		foreach($proj_ids as $id)
		{
			$searchRule .= " OR [Id] = '$id' ";
		}
		$searchRule .= " ) ";
		
		$projects = BizSystem::getObject("collab.project.do.ProjectDO",1)->directfetch($searchRule,0,0,"[start_time] ASC");
		$project_id = $projects[0]['Id'];
		return $project_id;
    }
    
	public function getProjectName($ids)
    {
    	$proj_ids = explode(";", $ids);
		$searchRule = " ( FALSE ";
		foreach($proj_ids as $id)
		{
			$searchRule .= " OR [Id] = '$id' ";
		}
		$searchRule .= " ) ";
		
		$projects = BizSystem::getObject("collab.project.do.ProjectDO",1)->directfetch($searchRule,0,0,"[start_time] ASC");
		foreach($projects as $project){
			$project_name = $project['name'];
			$project_shortname = substr($project_name,0,strpos($project_name,'-'));
			if($project_shortname)
			{
				$project_name = $project_shortname;
			}
			$proj_name .=$project_name.";";
		}
		return $proj_name;
    }
    
	public function renderGantt()
	{
		
		header('Content-type: text/xml');		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<projects>";
				
		$do=$this->getDataObj();
		if($this->m_ProjectID){
			$default_project_id = $this->m_ProjectID;
		}else{
			$default_project_id=0;		
		}
		$this->m_outputIds = array();
		
		$proj_ids = explode(";", $this->m_ProjectIDs);
		foreach($proj_ids as $default_project_id)
		{
			
			if($default_project_id)
			{
				$projectRec['project_id']=$default_project_id;	
				$projectData = BizSystem::getObject("collab.project.do.ProjectDO",1)->fetchById($projectRec['project_id']); 
				$projectRec['project_name'] = $projectData['name'];	
				
				
				$projectRec['project_color'] = $projectData['type_color'];	
				$projectRec['project_start_time'] = $start_time = date('Y,n,j',strtotime($projectData['start_time']));
			}else{
				$projectRec['project_id']='0';	
				$projectRec['project_name'] = $this->getMessage("DEFAULT_PROJECT");		
				$projectRec['project_color'] = $this->getMessage("DEFAULT_PROJECT_COLOR");	
				
			}
			
			$recList = $this->fetchDataSet($default_project_id);		
			foreach($recList as $rec){
				$this->m_outputIds[] = $rec['Id'];	
			}				 		
			$tasks = $this->renderTaskList($recList);
			
			if($default_project_id=='0')
			{											
				$projectRec['project_start_time'] = $this->getProjectStartTime($recList);
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
	
	public function fetchDataSet($project_id = null)
    {
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
		
        if($project_id){
        	$searchRule .= "AND [project_id]=$project_id";
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