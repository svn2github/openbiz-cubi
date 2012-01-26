<?php 
class ChangeLogWidgetForm extends EasyForm
{

	public function fetchDataSet()
	{
		$result = parent::fetchDataSet();
		$resultSet = array();
		$messageFile_loaded = false;
		foreach ($result as $record)
		{
			$form = unserialize($record['form']);
			$data = unserialize($record['data']);
			
			if(!$messageFile_loaded)
			{
				$this->m_Messages = Resource::loadMessage($form['message_file'] , $form['package']);
				
				$messageFile_loaded = true;
			}
			
			foreach ($data as $key=>$value)
			{
				$elemObjMeta = $data[$key]['element'];
				$elemObjMeta = $this->replaceElementClass($elemObjMeta);
				$objName = $elemObjMeta["ATTRIBUTES"]['CLASS'];
				
				$formObj = BizSystem::getObject($this->m_ParentFormName);
				$elemObj = new $objName($elemObjMeta,$formObj);
				
				$data[$key]['label'] = $elemObj->renderLabel(); 
				
				$elemObj->setValue($data[$key]['old']);
				$data[$key]['old'] = $elemObj->render();
				
				$elemObj->setValue($data[$key]['new']);
				$data[$key]['new'] = $elemObj->render();
				
				unset($data[$key]['element']);
			}
			$record['data'] = $data;
			unset($record['form']);
			$resultSet[] = $record;
		}
		return $resultSet;
	}
	
	protected function replaceElementClass($metaArr)
	{
		
		
		$className = $metaArr["ATTRIBUTES"]['CLASS'];
		
		switch($className)
		{
			case "Listbox":
			case "DropDownList":
				$newClass = "LabelList";
				break;
				
			case "Checkbox":
				$newClass = "LabelBool";
				break;
				
			case "InputText":
			case "Textarea":
			case "InputDate":
			case "InputDatetime":							
				$newClass = "LabelText";				
				break;
			default:				
				$newClass = "LabelText";
				if(preg_match('/Selector/si',$className)){
					$newClass = "LabelList";
				}
				break;
		}		
		
		
		
		$metaArr["ATTRIBUTES"]['CLASS'] = $newClass;
		$metaArr["ATTRIBUTES"]['CSSCLASS']="";
		return $metaArr;
	}
}
?>