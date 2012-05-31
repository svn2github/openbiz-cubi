<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.changelog.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once dirname(__FILE__).'/ChangeLogForm.php';
class ChangeLogNoCommentForm extends ChangeLogForm
{	
	protected function readMetadata(&$xmlArr)
    {    						
    	//load message file
    	$this->m_ChangeLogMessages = Resource::loadMessage("changelog.ini" , "changelog");		
    	parent::readMetaData($xmlArr);
    }      
}
?>