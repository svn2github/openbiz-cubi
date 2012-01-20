<?php 
/**
 * Openbiz Cubi 
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   system.form
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

define ('HASH_ALG','sha1');

/**
 * UserForm class - implement the login of login form
 *
 * @package system.form
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class UserForm extends EasyForm
{
    /**
     * Create a user record
     *
     * @return void
     */
	private $m_ProfileDO = "contact.do.ContactDO";
	private $m_ProfileEditForm = "contact.form.ContactEditForm";
	private $m_ProfileDetailForm = "contact.form.ContactDetailForm";
	private $m_UserFormType;
	
	public function GoDetail()
	{		
        $id = BizSystem::clientProxy()->getFormInputs('_selectedId');
		$redirectPage = APP_INDEX."/system/user_detail/".$id;
		BizSystem::clientProxy()->ReDirectPage($redirectPage);
	}
	
    public function CreateUser()
    {
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
       
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
        $password = BizSystem::ClientProxy()->GetFormInputs("fld_password");            
		$recArr['password'] = hash(HASH_ALG, $password);
        $this->_doInsert($recArr);

        // if 'notify email' option is checked, send confirmation email to user email address
        // ...
        
        //$this->m_Notices[] = $this->GetMessage("USER_CREATED");
        
        //assign a default role to new user
        $userArr = $this->getActiveRecord();
        $user_id = $userArr["Id"];
        
        $RoleDOName = "system.do.RoleDO";
        $UserRoleDOName = "system.do.UserRoleDO";
        
        $roleDo = BizSystem::getObject($RoleDOName,1);
        $userRoleDo = BizSystem::getObject($UserRoleDOName,1);
        
        $roleDo->setSearchRule("[default]=1");
        $defaultRoles = $roleDo->fetch();
        foreach($defaultRoles as $role){
        	$role_id = $role['Id'];
        	$userRoleArr = array(
        		"user_id" => $user_id,
        		"role_id" => $role_id
        	);
        	$userRoleDo->insertRecord($userRoleArr);
        }

        //assign a default group to new user
        $GroupDOName = "system.do.GroupDO";
        $UserGroupDOName = "system.do.UserGroupDO";
        
        $groupDo = BizSystem::getObject($GroupDOName,1);
        $userGroupDo = BizSystem::getObject($UserGroupDOName,1);
        
        $groupDo->setSearchRule("[default]=1");
        $defaultGroups = $groupDo->fetch();
        foreach($defaultGroups as $group){
        	$group_id = $group['Id'];
        	$userGroupArr = array(
        		"user_id" => $user_id,
        		"group_id" => $group_id
        	);
        	$userGroupDo->insertRecord($userGroupArr);
        }        
        
       //create a default profile to new user
       $profile_id = BizSystem::getService(PROFILE_SERVICE)->CreateProfile($user_id);
	   $this->switchForm($this->m_ProfileEditForm,$profile_id);   	
       // $this->processPostAction();
    }
    
    public function CreateUserFromArr($data)
    {
        $recArr = $data;
         
        $password = $data['password'];            
		$recArr['password'] = hash(HASH_ALG, $password);
        $user_id = $this->_doInsert($recArr);
		
        $userArr = $this->getActiveRecord();
        $user_id = $userArr["Id"];
        
        $RoleDOName = "system.do.RoleDO";
        $UserRoleDOName = "system.do.UserRoleDO";
        
        $roleDo = BizSystem::getObject($RoleDOName,1);
        $userRoleDo = BizSystem::getObject($UserRoleDOName,1);
        
        $roleDo->setSearchRule("[default]=1");
        $defaultRoles = $roleDo->fetch();
        foreach($defaultRoles as $role){
        	$role_id = $role['Id'];
        	$userRoleArr = array(
        		"user_id" => $user_id,
        		"role_id" => $role_id
        	);
        	$userRoleDo->insertRecord($userRoleArr);
        }

        //assign a default group to new user
        $GroupDOName = "system.do.GroupDO";
        $UserGroupDOName = "system.do.UserGroupDO";
        
        $groupDo = BizSystem::getObject($GroupDOName,1);
        $userGroupDo = BizSystem::getObject($UserGroupDOName,1);
        
        $groupDo->setSearchRule("[default]=1");
        $defaultGroups = $groupDo->fetch();
        foreach($defaultGroups as $group){
        	$group_id = $group['Id'];
        	$userGroupArr = array(
        		"user_id" => $user_id,
        		"group_id" => $group_id
        	);
        	$userGroupDo->insertRecord($userGroupArr);
        }        
        
       //create a default profile to new user
       $profile_id = BizSystem::getService(PROFILE_SERVICE)->CreateProfile($user_id);
       // $this->processPostAction();
    }    
    
    /**
     * Update user record
     *
     * @return void
     */
    public function UpdateUser()
    {
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        
        if($this->SmartCardAuthStatus()){
	        if($this->CheckSmartCard($recArr)){
	        	$this->m_Errors = array("fld_smartcardcodexx"=> $this->getMessage("SMARTCARD_USED"));
	        	$this->setActiveRecord($currentRec);
	        	$this->rerender();
	        	return;
	        }        
        }
        $this->setActiveRecord($recArr);
        
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }


        
        if (count($recArr) == 0)
            return;		        
            
        $password_mask = $this->getElement("fld_password")->m_PasswordMask;        
        $password = BizSystem::ClientProxy()->GetFormInputs("fld_password");
        if($password!=$password_mask){
        	$recArr['password'] = hash(HASH_ALG, $password);
		}
        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;
        
        //also update users profile 
        $profileDO = BizSystem::getObject("contact.do.ContactSystemDO",1);
        $UserProfiles = $profileDO->directFetch("[user_id]='".$currentRec['Id']."'");
        foreach($UserProfiles as $Profile)
        {        	
        	$profileDO->updateRecords("[email]='".$recArr['email']."'","[user_id]='".$currentRec['Id']."'");
        }
            
        // if 'notify email' option is checked, send confirmation email to user email address
        // ...
        
        //$this->m_Notices[] = $this->GetMessage("USER_DATA_UPDATED");
        $this->processPostAction();
    }
    
	public function ClearSmartCard()
    {
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        
		
       	$recArr['smartcard'] = '';
		
        if ($this->_doUpdate($recArr, $currentRec) == false)
            return;
        
        // if 'notify email' option is checked, send confirmation email to user email address
        // ...
        
        //$this->m_Notices[] = $this->GetMessage("USER_DATA_UPDATED");
        $this->processPostAction();
    }
   
    public function CheckSmartCard($rec)    
    {
    	$recId = $this->m_RecordId;
    	$cardcode = $rec['smartcard'];
    	$do = $this->getDataObj();
    	$record = $do->directfetch("[smartcard]='$cardcode' AND [Id]!='$recId'");
    	if($record->count()>0){
    		return true;
    	}else{
    		return false;
    	}
    }
	/**
     * Validate form user inputs
     *
     * @return boolean
     */
    public function validateForm()
    {	
        
        if ($this->_checkDupUsername())
        {
            $errorMessage = $this->GetMessage("USERNAME_USED");
			$this->m_ValidateErrors['fld_username'] = $errorMessage;
			throw new ValidationException($this->m_ValidateErrors);
			return false;
			
        }

        if ($this->_checkDupEmail())
        {
            $errorMessage = $this->GetMessage("EMAIL_USED");
			$this->m_ValidateErrors['fld_email'] = $errorMessage;
			throw new ValidationException($this->m_ValidateErrors);
			return false;
        }              
        
    	// disable password validation if they are empty
    	$password = BizSystem::ClientProxy()->GetFormInputs("fld_password");
		$password_repeat = BizSystem::ClientProxy()->GetFormInputs("fld_password_repeat");
    	if (!$password_repeat)
    	    $this->getElement("fld_password")->m_Validator = null;
    	if (!$password)
    	    $this->getElement("fld_password_repeat")->m_Validator = null;
    	    
    	parent::ValidateForm();

		if($password != "" && ($password != $password_repeat))
		{
			$passRepeatElem = $this->getElement("fld_password_repeat");
			$errorMessage = $this->GetMessage("PASSOWRD_REPEAT_NOTSAME",array($passRepeatElem->m_Label));
			$this->m_ValidateErrors['fld_password_repeat'] = $errorMessage;
			throw new ValidationException($this->m_ValidateErrors);
			return false;
		}
	
        return true;
    }

    /**
     * check duplication of username
     *
     * @return boolean
     */
    protected function _checkDupUsername()
    {    	
        $username = BizSystem::ClientProxy()->GetFormInputs("fld_username");
        $searchTxt = "[username]='$username'";        
        
        // query UserDO by the username
        $userDO = $this->getDataObj();        
        //include optional ID when editing records
        if ($this->m_RecordId > 0 ) {
            $searchTxt .= " AND [Id]<>$this->m_RecordId";  
        }
                       
        $records = $userDO->directFetch($searchTxt,1);
        if (count($records)==1)
            return true;
        return false;
    }

    /**
     * check duplication of email address
     *
     * @return boolean
     */
    protected function _checkDupEmail()
    {
        $email = BizSystem::ClientProxy()->GetFormInputs("fld_email");
        $searchTxt = "[email]='$email'";           
        // query UserDO by the email
        $userDO = $this->getDataObj();        
        
        //include optional ID when editing records
        if ($this->m_RecordId > 0 ) {
            $searchTxt .= " AND [Id]<>$this->m_RecordId";  
        }        
        $records = $userDO->directFetch($searchTxt,1);
        if (count($records)==1)
            return true;
        return false;
    }   

    public function profile($user_id = null){
    	if(!$user_id){    		
   			$user_id = (int)BizSystem::clientProxy()->getFormInputs('_selectedId');
    	}    	
    	if(!$user_id){
    		return ;
    	}
		//looking up profile for this account in ProfileDO
		$recordSet = BizSystem::getObject($this->m_ProfileDO,1)->fetchOne("[user_id]='$user_id'");
		if(!isset($recordSet)){
			//create a new profile connected to current profile
			$profile_id = BizSystem::getService(PROFILE_SERVICE)->CreateProfile($user_id);
			$this->switchForm($this->m_ProfileEditForm,$profile_id);   					
		}else{
			$profile_id = $recordSet->Id;
			$this->switchForm($this->m_ProfileDetailForm,$profile_id);   								
		}
    }
    
	public function SmartCardAuthStatus()
	{
		$do = BizSystem::getObject("myaccount.do.PreferenceDO");
        $rs = $do->directFetch("[user_id]='0' AND ([section]='Login' OR [section]='Register' )");
      
        if ($rs)
        {
	        	foreach ($rs as $item)
	        	{        		
	        		$preference[$item["name"]] = $item["value"];        	
	        	}	
        }  

        return $preference['smartcard_auth'];        		
	}
}  
?>