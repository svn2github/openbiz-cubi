<?php 
interface iSMS
{	
    public function send($mobile,$content);

    public function getSentCount();
}
?>