<?php 
require_once(OPENBIZ_BIN."easy/element/Listbox.php");
class TemplateListbox extends EditCombobox{
	public function getFromList(&$list)
    {    			
		$i = 0;
		foreach (glob(MODULE_PATH.DIRECTORY_SEPARATOR."report".DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."report_table_*") as $file){
				$template = basename($file);
				$list[$i]['txt'] = $template;
				$list[$i]['val'] = $template;
				$i++;
		}
		return $list;
    }
}
?>