<?php 
interface iSMS
{	
    public function send($mobile,$content);

    public function getMsgBalance();    
    
    public function HitMessageCounter();
    
    public function getMessageCounter();
    
}
?>