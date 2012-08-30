<?php 
interface iSMS
{	
    public function send($mobile,$content,$delay=null);

    public function getSentCount();
}
?>