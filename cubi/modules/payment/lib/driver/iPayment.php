<?php 
interface iPayment
{	
    public function GetPaymentURL($orderId, $amount, $title=null);

    public function ValidateNotification($txn_id);    
    
    public function GetReturnData();
    
    public function log();
}
?>