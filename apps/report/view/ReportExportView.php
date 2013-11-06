<?php
include_once "ReportView.php";
include_once MODULE_PATH."/common/lib/MetaObjExport.php";

// include pear archive class for tar files
set_include_path(get_include_path() . PATH_SEPARATOR . APP_HOME.'/bin/phing/classes');
include_once "Archive/Tar.php";

class ReportExportView extends ReportView
{
	protected $reportViewClass = "EasyView";
	protected $reportFormClassMap = array("ReportListForm"=>"report.form.DataForm","ReportFilterForm"=>"report.form.DataForm","ReportChartForm"=>"report.form.ChartForm");
	protected $reportFormTplMap = array("ReportListForm"=>"system_right_listform.tpl.html","ReportFilterForm"=>"system_right_detailform.tpl.html","ReportChartForm"=>"system_right_chartform.tpl.html");
	protected $reportViewTpl = "view.tpl";	// TODO: use view tpl with chart enabled
	
	protected $viewPackage = "myproj.view.";
	protected $formPackage = "myproj.form.";
	protected $dataPackage = "myproj.do.";
	protected $dbObject = "common.do.FlexDbDO";
	protected $reportDbDO = "report.do.ReportDbDO";
	
	protected $filesToTar = array();
	protected $exportFileName = "temp";
	
	protected function _render()
	{
		//print "Start expport ...\n";
		
		// hack the view name to use title by removing whitespace
		$this->m_Name = $this->viewPackage.str_replace(' ','', $this->m_Title);
		if (strripos($this->m_Name, 'View') < strlen($this->m_Name)-strlen('View')) {
			$this->m_Name = $this->m_Name."View";
		}
		$this->m_Class = $this->reportViewClass;
		$this->m_TemplateFile = $this->reportViewTpl;
		
		$this->exportFileName = str_replace(' ','', $this->m_Title).".tar";
		
		// hack the form name to use form title by removing whitespace
		$formList = array();
		foreach ($this->m_FormRefs as $formName=>$formRef) {
			$formObj = BizSystem::getObject($formRef->m_Name);
			$formList[] = $formObj;
			$formRef->m_Name = $this->formPackage.str_replace(' ','', $formObj->m_Title);
			//echo "the new form name is ".$formRef->m_Name;
		}
		
		// print view object xml
		$metaObjExp = new MetaObjExport($this);
		$this->save_contents($this->m_Name, $metaObjExp->MetaObj2XML());
		unset($metaObjExp);
		
		// print form objects xml
		foreach ($formList as $formObj) {
			$formObj->m_Name = $this->formPackage.str_replace(' ','', $formObj->m_Title);
			if ($formObj->m_Class == "ReportChartForm") {
				$formObj->m_ChartType = $formObj->m_SubType;
				$formObj->m_ChartAttrs = $formObj->m_Attrs;
				$formObj->m_SubType = $formObj->m_Attrs = "";
			}
			$formObj->m_TemplateFile = $this->reportFormTplMap[$formObj->m_Class];
			$formObj->m_Class = $this->reportFormClassMap[$formObj->m_Class];
			list($clz, $doName) = explode(":",$formObj->m_DataObjName);
			$formObj->m_DataObjName = $this->dataPackage.str_replace(' ','', $doName);
			
			// use field name as element name
			foreach ($formObj->m_DataPanel as $elemName=>$elemObj) {
				$elemObj->m_Name = isset($elemObj->fieldName) ? 'fld_'.$elemObj->fieldName : 'fld_'.$elemObj->m_FieldName;
			}
			$metaObjExp = new MetaObjExport($formObj);
			$this->save_contents($formObj->m_Name, $metaObjExp->MetaObj2XML());
			unset($metaObjExp);
		}
		
		// print data objects xml
		$dataObjList = array();
		foreach ($formList as $formObj) {
			$dataObj = $formObj->getDataObj();
			if (isset($dataObjList[$dataObj->m_Name])) continue;
			$dataObjList[$dataObj->m_Name] = $formObj;
			list($clz, $name) = explode(":",$dataObj->m_Name);
			$dataObj->m_Name = $this->dataPackage.str_replace(' ','', $name);
			$dataObj->m_Class = $this->dbObject;
			$dataObj->m_DBName = $dataObj->m_Database;
			$dataObj->m_DBObject = $this->reportDbDO;
			$dataObj->m_Id = $dataObj->m_Database = $dataObj->m_DbId = "";	// reset some unused attributes
			$metaObjExp = new MetaObjExport($dataObj);
			$this->save_contents($dataObj->m_Name, $metaObjExp->MetaObj2XML());
			unset($metaObjExp);
		}
		
		//print "\nEnd export.";
		$this->tarFiles();
	}
	
	// tar files under myproj dir
	protected function tarFiles()
	{
		chdir(TEMPFILE_PATH);
		$obj = new Archive_Tar($this->exportFileName);
		//print_r($this->filesToTar);
		if ($obj->create($this->filesToTar)) {
			//echo 'Created successfully!';
			$this->outputTarFile();
		} else {
			echo 'Error in file creation';
		}
	}
	
	protected function outputTarFile()
	{
		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$this->exportFileName.'"');
		readfile(TEMPFILE_PATH."/".$this->exportFileName);
		exit;
	}
	
	protected function save_contents($objectName, $contents)
	{
		$fileName = TEMPFILE_PATH."/".str_replace(".","/",$objectName).".xml";
		$dir = str_replace(".","/",$objectName);
		$this->filesToTar[] = str_replace(".","/",$objectName).".xml";
		$parts = explode('/', $dir);
		$file = array_pop($parts);
		$_dir = TEMPFILE_PATH;
		foreach($parts as $part) {
			$_dir .= "/$part";
			if(!is_dir($_dir)) {
				echo "mkdir $_dir \n";
				mkdir($_dir);
			}
		}
		file_put_contents($fileName, $contents);
	}
}



?>