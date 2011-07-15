<?php 
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
class ElementListbox extends Listbox{
	public $m_SelectFromTable = "report.admin.lov.ElementType(TableElement)";
	public $m_SelectFromChart = "report.admin.lov.ElementType(ChartElement)";
	public $m_SelectFromInput = "report.admin.lov.ElementType(InputElement)";
	
	public function render(){
		$formobj = $this->getFormObj();
        $this->m_SelectFrom = Expression::evaluateExpression($this->m_SelectFrom, $formobj);
		switch($this->m_SelectFrom){
			case "table":
				$this->m_SelectFrom = $this->m_SelectFromTable;
				break;
			case "chart":
				$this->m_SelectFrom = $this->m_SelectFromChart;
				break;
			case "filter":
				$this->m_SelectFrom = $this->m_SelectFromInput;
				break;
		}
    	return parent::render();
	}

}
?>