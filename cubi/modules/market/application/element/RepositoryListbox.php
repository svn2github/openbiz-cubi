<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.application.element
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: CategoryListbox.php 3363 2012-05-31 06:04:56Z rockyswen@gmail.com $
 */

class RepositoryListbox extends Listbox
{
	public function getFromList(&$list, $selectFrom=null)
    {
    	parent::getFromList($list,$selectFrom);
    	$svc = BizSystem::getService("market.lib.PackageService");
    	foreach($list as $key=>$record)
    	{    		
    		$repo_uri = $record['pic']; 
    		unset($record['pic']); 
    		$repoInfo = $svc->discoverRepository($repo_uri);
    		$record['txt'] = $repoInfo['_repo_name'];
    		$list[$key] = $record;
    	}
        return;
    }	
}
?>