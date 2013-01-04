<?php 
include_once MODULE_PATH.'/repository/category/form/CategoryTranslateForm.php';

class ApplicationTranslateForm extends CategoryTranslateForm
{
	protected $m_TranslateDO = "repository.application.do.ApplicationTranslateDO";
	protected $m_RecordFKField = "repo_app_id";	
}
?>