<?php 
class ResetPasswordView extends EasyView
{

	protected  $m_ForceResetPassword = false;
	
    public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->m_Name, "ForceResetPassword", $this->m_ForceResetPassword);        
    }

    public function setSessionVars($sessionContext)
    {       
        $sessionContext->setObjVar($this->m_Name, "ForceResetPassword", $this->m_ForceResetPassword);
    }	
    
    public function isForceResetPassword()
    {
    	return $this->m_ForceResetPassword;
    }
    
    public function render()
    {
    	if(isset($_GET['force']))
    	{
    		$this->m_ForceResetPassword = true;
    	}else{
    		$this->m_ForceResetPassword = false;
    	}
    	return parent::render();
    }
}
?>