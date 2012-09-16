<?php 
require_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
class callbackService extends  WebsvcService
{
	protected  $svc = "payment.lib.PaymentService";
	 
	public function verify()
	{		
		$type = $_REQUEST['type'];
	}
}
?>