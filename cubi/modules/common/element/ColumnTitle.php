<?php 
class ColumnTitle extends ColumnText
{
	public function getIDPrefix()
	{
		$rec = $this->getFormObj()->getActiveRecord();
		$id = $rec["Id"];
		$id_display = "<span style='color:#aaaaaa; padding-right:5px;width:10px;height:20px;margin-right:5px;' >$id</span>";
		return $id_display;
	}
	
	public function render(){
		$sHTML = parent::render();
		$sHTML = $this->getIDPrefix().$sHTML;
		return $sHTML;
	}
}
?>