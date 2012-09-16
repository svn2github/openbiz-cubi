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


class LogForm extends EasyForm
{
	 public function ClearLog()	
	{
       if ($this->m_Resource != "" && !$this->allowAccess("payment.Manage"))
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
	
	public function ExportCSV()
	{
		$excelSvc = BizSystem::getService(EXCEL_SERVICE);	
		$excelSvc->renderCSV($this->m_Name);
		$this->runEventLog();
		return true;
	}	
	
}
?>