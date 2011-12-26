<?php 
class HelpReadForm extends EasyForm
{
	public function fetchData(){
		$data = parent::fetchData();
		$data['content'] = str_replace("/cubi/", APP_URL.'/', $data['content']);
		return $data;
	}
}
?>