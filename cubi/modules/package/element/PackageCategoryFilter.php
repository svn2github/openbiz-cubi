<?php
class PackageCategoryFilter extends DropDownList
{
    protected function getList(){
    	$packageService = "package.lib.PackageService";
    	$pkgsvc = BizSystem::GetObject($packageService);
		$categories = $pkgsvc->discoverCategories();     
		$list = array();
		foreach($categories as $cat){
			$catArr = array("txt"=>$cat['name'], "val"=>$cat['name']);
			array_push($list,$catArr);
		}
    	return $list;
    }
}
?>