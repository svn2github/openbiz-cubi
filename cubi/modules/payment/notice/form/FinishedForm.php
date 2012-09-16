<?php 
class FinishedForm extends EasyForm
{
	public function fetchData()
	{
		$result = BizSystem::getService("payment.lib.PaymentService")->getReturnData($_GET['type']);
		$txn_id = $result['txn_id'];
		$verify = BizSystem::getService("payment.lib.PaymentService")->validateNotification($_GET['type'],$txn_id);
		return $result;
	}
}
?>