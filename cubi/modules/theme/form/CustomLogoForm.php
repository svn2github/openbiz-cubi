<?php 
class CustomLogoForm extends EasyForm
{
	public function UpdateLogo()
	{
		$recArr = $this->readInputRecord();
		$imgfile = $recArr['custom_logo'];
		$imgfile = APP_HOME.DIRECTORY_SEPARATOR.$imgfile;
		
		$logofile = APP_HOME.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'cubi_logo_large.png';
		@copy($imgfile,$logofile);
		
        $this->processPostAction();
	}
}
?>