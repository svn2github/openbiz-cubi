<?php 
class CustomHeaderForm extends EasyForm
{
	public function UpdateLogo()
	{
		$recArr = $this->readInputRecord();
		$imgfile = $recArr['custom_header'];
		$imgfile = APP_HOME.DIRECTORY_SEPARATOR.$imgfile;
		
		$logofile = APP_HOME.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'cubi_top_header.png';
		@copy($imgfile,$logofile);
		
        $this->processPostAction();
	}
	
	public function Restore()
	{
		$logofile = APP_HOME.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'cubi_top_header.png';
		@unlink($logofile);
		$this->processPostAction();
	}
}
?>