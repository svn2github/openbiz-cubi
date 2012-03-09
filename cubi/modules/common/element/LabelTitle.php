<?php 
class LabelTitle extends LabelText
{
	public function getIDPrefix()
	{
		$rec = $this->getFormObj()->getActiveRecord();
		$id = $rec["Id"];
		$id_display = "<span class=\"title_id\" style='margin-left:10px;' >$id</span>";
		return $id_display;
	}
	
	public function render(){
		$sHTML = parent::render();
		$sHTML = $sHTML.$this->getIDPrefix();
		return $sHTML;
	}
}
?>