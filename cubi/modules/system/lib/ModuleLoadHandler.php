<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.system.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once (MODULE_PATH."/system/lib/ModuleLoader.php");

interface ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader);
    
    public function postLoadingModule($moduelLoader);
}

?>