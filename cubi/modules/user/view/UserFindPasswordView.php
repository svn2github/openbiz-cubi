<?php 
class UserFindPasswordView extends EasyView
{
	public function allowAccess(){
		$result = parent::allowAccess();
        $do = BizSystem::getObject("myaccount.do.PreferenceDO");
        $rs = $do->fetchOne("[user_id]='0' AND  [section]='Register' AND [name]='find_password'");
      
        $value = $rs->value;
        if($value==0 || $value==null){
        	return 0 ;
        }else{
        	return $result;
        }		
	}
    

}
?>