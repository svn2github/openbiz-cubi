<?php 
interface iPayment
{	
    public function GetPaymentURL($amount,$title=null);

    public function ValidateNotification($txn_id);    
    
    public function log();
}
?>