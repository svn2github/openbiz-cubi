<?php 
/**
 * Openbiz Cubi 
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   user.form
 * @copyright Copyright (c) 2005-2011, Rocky Swen & Jixian Wang 
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */


/**
 * PreferenceForm class 
 *
 * @package user.form
 * @author Jixian Wang
 * @copyright Copyright (c) 2005-2011
 * @access public
 */
class PreferenceForm extends EasyForm
{    
    
    public function fetchData(){
        $prefRecord = array();
        return $prefRecord;    
    }
    
    public function updateRecord()
    {
        $recArr = $this->readInputRecord();

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
		
        
        foreach ($this->m_DataPanel as $element)
        {
            $value = $recArr[$element->m_FieldName];
            if ($value === null){ 
            	continue;
            } 
            
            if(substr($element->m_FieldName,0,1)=='_'){
	           	$name = substr($element->m_FieldName,1);
	            //update default app_init setting
	            $config_file = APP_HOME.'/bin/app_init.php';
	            switch($name){
	            	case "latitude":	            		
	            		if($value!=DEFAULT_LATITUDE){
	            			
	            			$data = file_get_contents($config_file);	            			
	            			$data = preg_replace("/define\([\'\\\"]{1}DEFAULT_LATITUDE[\'\\\"]{1}.*?\)\;/i","define('DEFAULT_LATITUDE','$value');",$data);	            			
	            			@file_put_contents($config_file,$data);
	            		}
	            		break;
					case "longtitude":
						if($value!=DEFAULT_LONGTITUDE){
            				$data = file_get_contents($config_file);	            			
            				$data = preg_replace("/define\([\'\\\"]{1}DEFAULT_LONGTITUDE[\'\\\"]{1}.*?\)\;/i","define('DEFAULT_LONGTITUDE','$value');",$data);	            			
            				@file_put_contents($config_file,$data);
						}
	            		break;	         		            			            		        		
	            }
            }
        }
       	
	            		            	
        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();
            $this->renderParent();
        }

        $this->processPostAction();

    }

}  
?>