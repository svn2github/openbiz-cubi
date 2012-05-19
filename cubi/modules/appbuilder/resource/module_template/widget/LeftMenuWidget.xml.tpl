<MenuWidget Name="{$form_name}" 
		Title="{$form_title}" 
		Class="menu.widget.MenuWidget" 
		CssCLass="{$form_css}" 
		BizDataObj="menu.do.MenuTreeDO" 
		SearchRule="[PId]='{$mod_name}'" 
		GlobalSearchRule="[published] = 1" 
		MenuDeep="2" 
		TemplateEngine="Smarty" 
		TemplateFile="left_menu.tpl" 
		CacheLifeTime="0">
</MenuWidget>