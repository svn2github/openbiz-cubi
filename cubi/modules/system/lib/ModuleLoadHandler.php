<?php
include_once (MODULE_PATH."/system/lib/ModuleLoader.php");

interface ModuleLoadHandler
{
    public function beforeLoadingModule($moduelLoader);
    
    public function postLoadingModule($moduelLoader);
}

?>