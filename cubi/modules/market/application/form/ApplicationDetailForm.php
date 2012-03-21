<?php 
require_once 'AppListForm.php';
class ApplicationDetailForm extends AppListForm
{
	public function fetchData()
	{
		$app_id = $_GET['fld:Id'];
		$repo_uri = $this->getDefaultRepoURI();
		
		var_dump($app_id);
		var_dump($repo_uri);exit;
		
		$result = array();
		return $result;
	}
}
?>