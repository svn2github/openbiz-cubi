<?php 
interface iSMS
{	
    public function send($mobile,$content,$schedule=null);

    public function getMsgBalance();    
    
    public function HitMessageCounter();
    
    public function getMessageCounter();
    
    public function activeService();
}
?>