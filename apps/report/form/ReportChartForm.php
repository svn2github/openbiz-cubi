<?php

//include_once MODULE_PATH."/chart/form/ChartForm.php";
include_once "ReportForm.php";

class ReportChartForm extends ReportForm
{
	public $chartCategory;
	public $chartDataset;
	protected $colorList = array();	

	public function outputAttrs()
    {
        $output['name'] = $this->m_Name;
        $output['title'] = $this->m_Title;
        $output['description'] = str_replace('\n', "<br />", $this->m_Description);
        $output['data'] = $this->draw();
        return $output;
    }
    
    public function validateRequest($methodName)
    {
    	$methodName = strtolower($methodName);
        if ($methodName == "draw" || $methodName == "invoke") 
            return true;
        return parent::validateRequest($methodName);
    }
    
    public function fetchDataSet()
    {
    }
    
    protected function fetchDatasetByColumn()
    {
    	$this->chartDataset = array();
    	$this->chartCategory = array();
    	
    	// query recordset first
		$dataObj = $this->getDataObj();

		if ($this->m_FixSearchRule)
        {
            if ($this->m_SearchRule)
                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }
        else
            $searchRule = $this->m_SearchRule;
        $dataObj->setSearchRule($searchRule);

        $dataObj->setLimit("");
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        $resultRecords = $dataObj->fetch();
		//$resultRecords = $dataObj->directFetch($searchRule);
		$counter = 0;
        while (true)
        {
            $arr = $resultRecords[$counter];
            if (!$arr) break;
            foreach ($this->m_DataPanel as $element)
            {
            	if ($element->fieldName) // && isset($arr[$element->fieldName]))
            	{
            		if ($element->m_Class == "report.lib.ChartData" || strpos($element->m_Class,"ChartData") !==false )
            		    $this->chartDataset[$element->key][] = $arr[$element->fieldName];
            		if ($element->m_Class == "report.lib.ChartCategory" || strpos($element->m_Class,"ChartCategory") !==false )
            		    $this->chartCategory[] = $arr[$element->fieldName];
            	}
            }
            $counter++;
        }    
    }
    
    public function draw()
    {
    	$path = MODULE_PATH.'/report/lib';
    	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
    	if(strtolower(FusionChartVersion)=="pro"){
    		require_once('fusionpro/FusionCharts_Gen.php'); 		
    	}
    	else
    	{
        	require_once('fusion/FusionCharts_Gen.php');
    	} 
 
    	return $this->drawChart();
    }
    
    //TODO: for different type of chart, use template? or render class?
    protected function drawChart()
    {
        $this->fetchDatasetByColumn();
        
        if ($this->checkChartType($this->m_SubType) == false) {
            $errmsg = "Unsupported chart type $this->m_SubType.";
            trigger_error($errmsg, E_USER_ERROR);
            return;
        }
                
        if (count($this->chartDataset) > 1)
            return $this->drawMultiSeries();
        else if (count($this->chartDataset) == 1)
            return $this->drawSingleSeries();
        else {
            //$errmsg = "Cannot draw chart due to empty data set.";
            //trigger_error($errmsg, E_USER_ERROR);
            return;
        }
        return "";
    }

	protected function getReportColors()
	{
		$this->colorList = BizSystem::sessionContext()->getVar("ReportColors");
		if (empty($this->colorList)) {
			$colorObj = BizSystem::getObject("report.do.ReportColorDO");
			$colorList = $colorObj->directFetch("");
			$i = 0;
			foreach ($colorList as $color) {
				$this->colorList[$i]["color_code"] = $color["color_code"];
				$i++;
			}
			BizSystem::sessionContext()->setVar("ReportColors", $this->colorList);
		}
		return $this->colorList;
	}
    
    protected function drawSingleSeries()
    {
    	//load color styles
        $colorList = $this->getReportColors();
    	
        $FC = new FusionCharts($this->m_SubType, $this->m_Width, $this->m_Height); 
        $this->seChartParams($FC);
        if(is_array($this->chartDataset)){
	        foreach ($this->chartDataset as $key=>$ds) {
	            for ($i=0; $i<count($ds); $i++) {
                    $colorString = "";
                    if ($colorList[$i]["color_code"])
                        $colorString = ";color=".$colorList[$i]["color_code"];
	                $FC->addChartData($ds[$i], "name=".$this->chartCategory[$i].$colorString);
                    }
	        }
        }
        
        return $FC->renderChart(false, false);
    }
    
    protected function drawMultiSeries()
    {
    	if (empty($this->chartCategory)) {
            $errmsg = "Please set category for multi series chart.";
            trigger_error($errmsg, E_USER_ERROR);
            return;
        }
        //load color styles
        $colorList = $this->getReportColors();
    	    	
        $FC = new FusionCharts($this->m_SubType, $this->m_Width, $this->m_Height); 
        $this->seChartParams($FC);
        # category names
        foreach ($this->chartCategory as $cat) {
            $FC->addCategory($cat);
        }
        $colorI=0;
        foreach ($this->chartDataset as $key=>$ds) {
            $colorString = "";
            if ($colorList[$colorI]["color_code"])
                $colorString = "color=".$colorList[$colorI]["color_code"];
            $FC->addDataset($key,$colorString);
            for ($i=0; $i<count($ds); $i++){
                $FC->addChartData($ds[$i],$colorString);                 
            }
            $colorI++;
        }
        
        return $FC->renderChart(false, false);
    }
   
    protected function seChartParams($FC)
    {
        if(strtolower(FusionChartVersion)=="pro"){
    		$FC->setSWFPath(RESOURCE_URL."/report/js/FusionChartsPro/");    		
    	}
    	else
    	{
        	$FC->setSWFPath(RESOURCE_URL."/report/js/FusionCharts/");
    	}
        
        # Set chart attributes
        //$FC->setChartParam('caption',$this->m_Title);
        $FC->setChartParam('formatNumberScale',1);
        $FC->setChartParam('decimalPrecision',0);
        if(strtolower(FusionChartVersion)=="pro"){
	        $FC->setChartParam('exportEnabled',1);
	        $FC->setChartParam('exportAtClient',0);
	        $FC->setChartParam('exportShowMenuItem',1);
	        $FC->setChartParam('exportAction',"save");
	        $FC->setChartParam('exportHandler',RESOURCE_URL."/report/js/FusionChartsPro/FCExporter.php");
	        $FC->setChartParam('exportFileName',$this->m_Name);
        }        
        //$strParam="xAxisName=Week;yAxisName=Revenue;numberPrefix=$;decimalPrecision=0;formatNumberScale=1";
        $strParam = "canvasBorderColor=CECECE;baseFontSize=12;".$this->m_Attrs;
        $FC->setChartParams($strParam);
    }
    
    protected function checkChartType($type)
    {
        switch ($this->m_SubType) {
            case "Column2D" : 
            case "Column3D" : 
            case "Bar2D" : 
            case "Area2D" :
            case "Line" : 
            case "Pie2D" : 
            case "Pie3D" :
            case "MSColumn2D" :
            case "MSColumn3D" :
            case "MSBar2D" :
            case "MSArea2D" :
            case "MSLine" :
            case "StackedBar2D" : 
            case "StackedColumn2D" : 
            case "StackedColumn3D" : 
            case "StackedArea2D" :
                return true;
        }
        return false;
    }
}
?>
