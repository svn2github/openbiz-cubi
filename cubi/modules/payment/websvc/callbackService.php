<?php 
require_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
class callbackService extends  WebsvcService
{
	protected  $svc = "payment.lib.PaymentService";
	 
	public function verify()
	{
		return BizSystem::getObject($this->svc)->ValidateNotification($_REQUEST['type']);
	}
}
?>