<?php 
interface iPayment
{	
    public function GetPaymentURL($amount);

    public function ValidateNotification($txn_id);    
    
    public function log();
}
?>