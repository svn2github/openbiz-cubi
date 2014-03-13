<?php 
class EventQtipFOrm extends EasyForm
{
    public function outputAttrs()
    {
    	$output = parent::outputAttrs();
        $output['recordId'] = $this->m_RecordId;
        return $output;        
    }
	
    public function rerender($redrawForm=true, $hasRecordChange=true)
    {
        if ($redrawForm)
        {
            BizSystem::clientProxy()->redrawForm($this->m_Name."_".$this->m_RecordId, $this->renderHTML());
            //BizSystem::clientProxy()->redrawForm($this->m_Name, 'xxx');
        }

        if ($hasRecordChange)
        {
            $this->rerenderSubForms();
        }
    }
}
?>