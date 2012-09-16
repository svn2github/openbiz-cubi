<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.location.widget
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class LocationForm extends EasyForm
{
	protected $geocode_url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false";
	
	// keep canUpdate in session
	public function getSessionVars($sessionContext)
    {
        parent::getSessionVars($sessionContext);
		$sessionContext->getObjVar($this->m_Name, "CanUpdateRecord", $this->m_CanUpdateRecord);
	}
	
	public function setSessionVars($sessionContext)
    {
        parent::setSessionVars($sessionContext);
		$sessionContext->setObjVar($this->m_Name, "CanUpdateRecord", $this->m_CanUpdateRecord);
	}
	
	public function close(){
		return parent::close();
	}
	
	public function InsertRecord()
	{
		parent::InsertRecord();
		$this->close();
	}
	
	public function UpdateRecord()
	{
		parent::UpdateRecord();
		$this->close();
	}
	
	protected function readInputRecord()
	{
		$recArr = parent::readInputRecord();
		$loc = $this->getLatLong($recArr['address']);
		if ($loc) {
			$recArr['latitude'] = $loc['lat'];
			$recArr['longtitude'] = $loc['lng'];
		}
		return $recArr;
	}
	
	protected function getLatLong($address)
	{
		require_once 'Zend/Json.php';
		$jsonValue = file_get_contents($this->geocode_url."&address=".urlencode($address));
		$jsonArray = Zend_Json::decode($jsonValue,true);
		if ($jsonArray['status']!='OK') {
			$errorMessage = "Invalid address"; //$this->getMessage("FORM_ELEMENT_REQUIRED",array($elementName));
			$this->m_ValidateErrors['fld_address'] = $errorMessage;
			return null;
		}
		$location = $jsonArray['results'][0]['geometry']['location'];
		return $location;
	}
	
	protected function validateForm($cleanError = true)
	{
		if (count($this->m_ValidateErrors) > 0)
        {
            throw new ValidationException($this->m_ValidateErrors);
            return false;
        }
		parent::validateForm($cleanError);
	}

	public function deleteLocation($id)
	{
		parent::deleteRecord($id);	
		 $parentForm = BizSystem::getObject($this->m_ParentFormName);
		$parentForm->rerender();
		return parent::close();
	}

	public function UpdateLocation($id,$lat,$lng)
	{
		$location = $this->getDataObj()->fetchById($id);
		$location['latitude'] = $lat;
		$location['longtitude'] = $lng;
		$location->save();
		return ;
	}
	public function addLocation()
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
        
		if (!$this->m_ParentFormElemName)
        {
        	//its only supports 1-m assoc now	        	        
	        $parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
        	//$parentForm->getDataObj()->clearSearchRule();
	        $parentDo = $parentForm->getDataObj();
	        
	        $column = $parentDo->m_Association['Column'];
	    	$field = $parentDo->getFieldNameByColumn($column);	    	    	
	    	$parentRefVal = $parentDo->m_Association["FieldRefVal"];
	    	
			$recArr[$field] = $parentRefVal;
	    	$cond_column = $parentDo->m_Association['CondColumn'];
	    	$cond_value = $parentDo->m_Association['CondValue'];
	    	if($cond_column)
	    	{
	    		$cond_field = $parentDo->getFieldNameByColumn($cond_column);
	    		$recArr[$cond_field] = $cond_value;
	    	}    	
        }                

        if ($this->m_ParentFormElemName && $this->m_PickerMap)
        {
            return ; //not supported yet
        }
        $recId = $parentDo->InsertRecord($recArr);
        
        $parentForm = BizSystem::getObject($this->m_ParentFormName);
		$parentForm->rerender();
		return parent::close();
	}
}
?>