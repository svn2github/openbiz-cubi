<?php 
class LabelDependencyList extends LabelList
{
	public function getIDPrefix()
	{
		$rec = $this->getFormObj()->getActiveRecord();
		$id = $rec[$this->m_FieldName];
		$id_display="";
		if($id){
			$id_display = "<span class=\"title_id\" >$id</span>";
		}
		return $id_display;
	}
	
	public function render(){
		$sHTML = parent::render();
		$sHTML = $this->getIDPrefix().$sHTML;
		return $sHTML;
	}	
}
?>