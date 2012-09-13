<?php 
require_once 'iPayment.php';
class PaymentAdapter implements iPayment
{
    public function GetPaymentURL($amount,$title=null){}

    public function ValidateNotification($txn_id){}    
    
    public function log(){}	
}
?>