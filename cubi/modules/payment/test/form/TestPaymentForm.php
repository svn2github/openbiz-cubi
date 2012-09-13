<?php 
class TestPaymentForm extends EasyForm
{
	public function MakePayment()
	{
		$rec= $this->readInputRecord();
		return $rec;
	}
}
?>