<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.help.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once (MODULE_PATH."/system/lib/ModuleLoadHandler.php");

class HelpLoadHandler implements ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader)
    {
        //echo "--- Test HelpLoadHandler::beforeLoadingModule \n";
    }
    
    public function postLoadingModule($moduelLoader)
    {
        //echo "--- Test HelpLoadHandler::postLoadingModule \n";
    }
}

?>