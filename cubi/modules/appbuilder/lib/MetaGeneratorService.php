<?php 
class MetaGeneratorService
{
	
	protected $m_DBName;
	protected $m_DBTable;
	protected $m_DBFields;
	protected $m_ConfigModule;
	protected $m_BuildOptions;
	
	protected $m_MetaTempPath;
	
	/**
	 * 
	 * This files will records generated files
	 * array - DataObjFiles
	 * array - FormObjFiles
	 * array - ViewObjFiles
	 * array - MessageFiles
	 * array - TemplateFiles
	 * string - ModXMLFile
	 * @var array Generated Files list
	 */
	protected $m_GeneratedFiles;
	
	public function setDBName($dbName)
	{
		$this->m_DBName	=	$dbName;
		return $this;
	}
	
	public function setDBTable($dbTable)
	{
		$this->m_DBTable	=	$dbTable;
		return $this;
	}
	
	public function setDBFields($dbFields)
	{
		$this->m_DBFields	=	$dbFields;
		return $this;
	}
	
	public function setConfigModule($configModule)
	{
		$this->m_ConfigModule	=	$configModule;
		return $this;
	}

	public function setBuildOptions($buildOptions)
	{
		$this->m_BuildOptions	=	$buildOptions;
		return $this;
	}	
	
	/**
	 * 	$svc->setDBName($dbName);
	 *  $svc->setDBTable($dbTable);
	 *  $svc->setDBFields($dbFields);
	 *  $svc->setConfigModule($configModule);
	 *  $svc->setBuildOptions($buildOptions);		
	 *  $svc->generate();
	 * Generate MetaObject Files
	 */
	public function generate()
	{
		$this->_genDataObj();
		$this->_genFormObj();
		$this->_genViewObj();
		$this->_genTemplateFiles();
		$this->_genMessageFiles();
		$this->_genModuleFile();
		return $this->m_GeneratedFiles;
	}
	
	protected function _genDataObj()
	{
		$templateFile = $this->__getMetaTempPath().'/do/DataObj.xml.tpl';
		var_dump($templateFile);exit;
	}
	
	protected function _genFormObj()
	{
		
	}
	
	protected function _genViewObj()
	{
		
	}

	protected function _genTemplateFiles()
	{
		
	}	
	
	protected function _genMessageFiles()
	{
		
	}	
	
	protected function _genModuleFile()
	{
		
	}	

	protected function _enableAttachmentFeature()
	{
		
	}	
	
	protected function _enablePictureFeature()
	{
		
	}	
	
	protected function _enableChangeLogFeature()
	{
		
	}

	protected function _enableGeoLocationFeature()
	{
		
	}	

	protected function _enableExtendFieldsFeature()
	{
		
	}	
	
	private function __getMetaTempPath()
	{
		$this->m_MetaTempPath = MODULE_PATH.DIRECTORY_SEPARATOR.'appbuilder'.
											DIRECTORY_SEPARATOR.'resource'.
											DIRECTORY_SEPARATOR.'module_template';
		return $this->m_MetaTempPath; 
	}
	
}
?>