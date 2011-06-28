<?php 
class WidgetPickForm extends PickerForm
{
	public function PicktoParent()
	{
	 	if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
                    
        foreach ($selIds as $id)
        {
            $rec = $this->getDataObj()->fetchById($id);           
			$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
			$parentDo = $parentForm->getDataObj();
			$user_id = BizSystem::getUserProfile("Id");
			
			$newRec = array(
				"user_id" => $user_id,
				"widget" => $rec['name'],
				"ordering" => 10,
				"status" => 1
			);
			$parentDo->insertRecord($newRec);
        }
        
		
		
		$this->close();
        $parentForm->rerender();
	}
}
?>