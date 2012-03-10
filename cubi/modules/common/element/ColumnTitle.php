<?php 
class ColumnTitle extends ColumnText
{
	public function getIDPrefix()
	{
		$rec = $this->getFormObj()->getActiveRecord();
		
		$id = $rec["Id"];
		if(!$id && $this->m_FieldName=='Id'){
			$id = $this->m_Value;
		}
		$id_display = "<span class=\"title_id\" >$id</span>";
		return $id_display;
	}
	
	public function render(){
		$sHTML = parent::render();
		if($this->m_FieldName!='Id'){
			$sHTML = $this->getIDPrefix().$sHTML;
		}
		else{
			$sHTML = $this->getIDPrefix();
		}
		return $sHTML;
	}
}
?>