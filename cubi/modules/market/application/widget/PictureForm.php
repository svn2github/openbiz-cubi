<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.application.widget
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

require_once(dirname(dirname(__FILE__)).'/form/AppListForm.php');
class PictureForm extends AppListForm
{
	public function fetchDataSet()
	{
		$resultSet = array();
		$app_id = (int)$_GET['fld:Id'];
		$repo_uri = $this->getDefaultRepoURI();
		
		$svc = BizSystem::getService("market.lib.PackageService");
		$resultRecords = $svc->discoverAppPics($repo_uri,$app_id);
		foreach($resultRecords as $record)
       	{
       		$record['url'] = $repo_uri.$record['url'];
       		$resultSet[] = $record;
       	}		
		return $resultSet;
	}
}
?>