<?php 
class ColumnTitle extends ColumnText
{
	public function getIDPrefix()
	{
		$rec = $this->getFormObj()->getActiveRecord();
		$id = $rec["Id"];
		$id_display = "<span class=\"title_id\" >$id</span>";
		return $id_display;
	}
	
	public function render(){
		$sHTML = parent::render();
		$sHTML = $this->getIDPrefix().$sHTML;
		return $sHTML;
	}
}
?>