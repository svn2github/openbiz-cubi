<?php 
interface iPayment
{	
    public function GetPaymentURL($orderId, $amount, $title=null,$body=null,$descURL=SITE_URL);

    public function ValidateNotification($txn_id);    
    
    public function log();
}
?>