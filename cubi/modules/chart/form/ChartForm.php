<?php

class ChartForm extends EasyForm
{
	public $chartCategory;
	public $chartDataset;
	public $chartDataAttrset;
	public $chartColorset;
	public $chartDescset;
	public $chartIdset;
    public $m_Attrs;
    public $m_SubType;
    public $m_SelectRecord;
    public $m_CategoryId;
    
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_SubType = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTTYPE"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTTYPE"] : null;
        $this->m_Attrs = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTATTRS"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["CHARTATTRS"] : null;
        $this->m_SelectRecord = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["SELECTRECORD"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["SELECTRECORD"] : null;
    }
    

    public function getSessionVars($sessionContext)
    {    	
    	$sessionContext->getObjVar($this->m_Name, "CategoryId", $this->m_CategoryId);
        $sessionContext->getObjVar($this->m_Name, "SubType", $this->m_SubType);
        return parent::getSessionVars($sessionContext);
    }


    public function setSessionVars($sessionContext)
    {
    	$sessionContext->setObjVar($this->m_Name, "CategoryId", $this->m_CategoryId);
        $sessionContext->setObjVar($this->m_Name, "SubType", $this->m_SubType);
        return parent::setSessionVars($sessionContext);        
    }    
	
	public function outputAttrs()
    {
        $output = parent::outputAttrs();
    	$output['name'] = $this->m_Name;
        $output['title'] = $this->m_Title;
        $output['description'] = str_replace('\n', "<br />", $this->m_Description);
        $output['data'] = $this->draw();
        $output['height'] = $this->m_Height;
        $output['width'] = $this->m_Width;
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
		$this->chartCategory = array();
		$this->chartDataAttrset = array();
		$this->chartDataset = array();
		$this->chartDataDescset = array();
		$this->chartDataIdset = array();
		$this->chartColorset = array();
    	// query recordset first
		$dataObj = $this->getDataObj();

        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);

        if ($this->m_RefreshData)
            $dataObj->resetRules();
        else
            $dataObj->clearSearchRule();
         		
		//echo "search rule is $this->m_SearchRule"; exit;
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
        if($this->m_StartItem>1)
        {
            $dataObj->setLimit($this->m_Range, $this->m_StartItem);
        }
        else
        {
            $dataObj->setLimit($this->m_Range, ($this->m_CurrentPage-1)*$this->m_Range);
        }
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        $resultRecords = $dataObj->fetch();
        $this->m_TotalRecords = $dataObj->count();
        if ($this->m_Range && $this->m_Range > 0)
            $this->m_TotalPages = ceil($this->m_TotalRecords/$this->m_Range);
		//$resultRecords = $dataObj->directFetch($searchRule);
		$counter = 0;
        while (true)
        {
            $arr = $resultRecords[$counter];
            if (!$arr) break;
            foreach ($this->m_DataPanel as $element)
            {            	
            	if ($element->fieldName && isset($arr[$element->fieldName]))
            	{	            	            			            		
            		switch($element->m_Class)
            		{
            			case "chart.lib.ChartColor":
            				$this->chartColorset[] = $arr[$element->fieldName];            				
            				break;
            			case "chart.lib.ChartDataId":
            				$this->chartIdset[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartDescription":
            				$this->chartDescset[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartColor":
            				$this->chartColorset[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartCategory":
            				$this->chartCategory[] = $arr[$element->fieldName];
            				break;
            			case "chart.lib.ChartData":
            				$this->chartDataset[$element->key][] 	 = $arr[$element->fieldName];
            		    	$this->chartDataAttrset[$element->key] = $element->attrs;
            				break;
            		}
            	}
            }
            $counter++;
        }      
    }
    
    public function draw()
    {
    	$path = MODULE_PATH.'/chart/lib';
    	set_include_path(get_include_path() . PATH_SEPARATOR . $path);    	
        if(strtolower(FusionChartVersion)=="pro"){
    		require_once(dirname(dirname(__FILE__)).'/lib/fusionpro/FusionCharts_Gen.php'); 		
    	}
    	else
    	{
        	require_once(dirname(dirname(__FILE__)).'/lib/fusion/FusionCharts_Gen.php');
    	} 
    	return $this->drawChart();
    }
    
    public function redrawChart(){
    	return $this->updateForm();
    }
    
    public function updateForm()
    {        
    	$data = $this->readInputRecord();
    	if($data['chart_type'])
    	{
    		$this->m_SubType = $data['chart_type'];
    	}
    	return parent::updateForm();
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
            $errmsg = "Cannot draw chart due to empty data set.";
            //trigger_error($errmsg, E_USER_ERROR);
            return;
        }
        return "";
    }
    
    protected function drawSingleSeries()
    {
    	//load color styles
    	$colorObj = BizSystem::getObject("chart.do.ChartColorDO");
    	$colorList = $colorObj->directFetch("");
    	
        $FC = new FusionCharts($this->m_SubType, $this->m_Width, $this->m_Height); 
        $this->seChartParams($FC);
        if(is_array($this->chartDataset)){
	        foreach ($this->chartDataset as $key=>$ds) {
	            for ($i=0; $i<count($ds); $i++){
	            	$elemConfig = "name=".$this->chartCategory[$i].';'.$this->chartDataAttrset[$key].';';	            	
	            	if($this->chartColorset[$i])
	            	{
	            		$elemConfig.="color=".$this->chartColorset[$i].';';
	            		$elemConfig.="anchorBgColor=6bd0fe;";
	            		$elemConfig.="anchorBorderColor=0d78af;";       		
	            	}
	            	elseif($colorList[$i]["color_code"])
	            	{
	            		$elemConfig.="color=".$colorList[$i]["color_code"].';';
	            		$elemConfig.="anchorBgColor=".$colorList[$i]["color_code"].';';
	            		$elemConfig.="anchorBorderColor=".$colorList[$i]["color_code"].';';
	            	}
	            	//select record feature
	            	if($this->m_SelectRecord){
	            		$elemConfig .="link=JavaScript:Openbiz.CallFunction(\\\"".$this->m_Name.".SelectRecord(".addslashes($this->chartIdset[$i]).")\\\");";
	            	}
	            	//desc text feature
	            	if($this->chartDescset[$i])
	            	{
	            		$elemConfig .="toolText=".addslashes($this->chartDescset[$i]).";";
	            	}
	            	//add anchor 
	            	$elemConfig .="anchorRadius=6;";
	                $FC->addChartData($ds[$i], $elemConfig);
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
    	$colorObj = BizSystem::getObject("chart.do.ChartColorDO");
    	$colorList = $colorObj->directFetch("");
    	    	
        $FC = new FusionCharts($this->m_SubType, $this->m_Width, $this->m_Height); 
        $this->seChartParams($FC);
        # category names
        foreach ($this->chartCategory as $cat) {
            $FC->addCategory($cat);
        }
        $colorI=0;
        foreach ($this->chartDataset as $key=>$ds) {
            if(preg_match("/color=/si",$this->chartDataAttrset[$key])){
            	$color = "";
            }           
            elseif($this->chartColorset[$colorI])
            {
            	$color = "color=".$this->chartColorset[$colorI].";";
            }
            elseif($colorList[$colorI]["color_code"])
            {
        		$color = "color=".$colorList[$colorI]["color_code"].";";
            }
        	
            $elemConfig = $color.$this->chartDataAttrset[$key];                        
        	$FC->addDataset($key,$elemConfig);
            for ($i=0; $i<count($ds); $i++){
            	$setConfig ="link=JavaScript:Openbiz.CallFunction(\\\"".$this->m_Name.".SelectRecord(".addslashes($colorI).",".addslashes($i).")\\\");";
                $FC->addChartData($ds[$i],$setConfig);
            }
            $colorI++;
        }
        return $FC->renderChart(false, false);
    }
    public function selectRecord($recId,$catId = null)
    {    	
    	if($catId!=null){
    		$this->m_CategoryId = $catId;
    	}
    	return parent::selectRecord($recId);
    }
    protected function seChartParams($FC)
    {
    	if(strtolower(FusionChartVersion)=="pro"){
    		$FC->setSWFPath(RESOURCE_URL."/chart/js/FusionChartsPro/");    		
    	}
    	else
    	{
        	$FC->setSWFPath(RESOURCE_URL."/chart/js/FusionCharts/");
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
	        $FC->setChartParam('exportHandler',APP_URL."/js/FusionChartsPro/FCExporter.php");
	        $FC->setChartParam('exportFileName',$this->m_Name);
        }
        //$strParam = "caption=".$this->m_Title.";canvasBorderColor=CECECE;baseFontSize=12;".$this->m_Attrs;
        $strParam = "canvasBorderColor=CECECE;baseFontSize=10;".$this->m_Attrs;
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
            case "MSColumn2DLineDY" :
            case "MSColumn3D" :
            case "MSColumn3DLineDY" :
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