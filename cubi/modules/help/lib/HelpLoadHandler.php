<?php
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