<?php 
interface iPayment
{	
    public function GetPaymentURL($amount);

    public function ValidateNotification();    
    
}
?>