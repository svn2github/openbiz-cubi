<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.email.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: SmsQueueForm.php 3358 2012-08-15 fsliit@gmail.com $
 */


class QueueForm extends EasyForm
{
	public function SendAllPendingSms()
	{
		BizSystem::getService('sms.lib.SmsService')->SendSmsFromQueue();
		if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();
		$this->runEventLog();
        $this->processPostAction();
		return true;
	}
	
	public function sendSms()
	{
		$Record=$this->getActiveRecord();
		if(is_array($Record) && $Record['status']!='sent')
		{
			$arr[0]=$Record;
			BizSystem::getService('sms.lib.SmsService')->SendSmsFromQueue($arr);
		} 
	 if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
		return true;
	}

	public function DeleteAllSms()
	{
       if ($this->m_Resource != "" && !$this->allowAccess("sms.Manage"))
           return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        try
        {
          $this->getDataObj()->deleteRecords();
        } 
        catch (BDOException $e)
        {
           $this->processBDOException($e);
           return;
        }
       
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
		return true;
	}

	
	public function DeleteSentSms()
	{ 
       if ($this->m_Resource != "" && !$this->allowAccess("sms.Manage"))
            return BizSystem::clientProxy()->redirectView(ACCESS_DENIED_VIEW);

        try
        {
          $this->getDataObj()->deleteRecords("[status]='sent'");
        } 
        catch (BDOException $e)
        {
           $this->processBDOException($e);
           return;
        }
		
       
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        $this->processPostAction();
		return true;
	}
	
}
?>