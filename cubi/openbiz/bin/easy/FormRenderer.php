<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: FormRenderer.php 4075 2011-05-02 13:43:39Z jixian2003 $
 */

/**
 * FormRenderer class is form helper for rendering form
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class FormRenderer
{
    /**
     * Render form object
     *
     * @param EasyForm $formObj
     * @return string result of rendering process
     */
    static public function render($formObj)
    {
        $tplEngine = $formObj->m_TemplateEngine;
        $tplFile = BizSystem::getTplFileWithPath($formObj->m_TemplateFile, $formObj->m_Package);
        //echo "template file at $tplFile"; exit;

        if (isset($formObj->m_jsClass))
        {
            $subForms = ($formObj->m_SubForms) ? implode(";",$formObj->m_SubForms) : "";
            if($formObj->m_StaticOutput!=true){
            	$formScript = "\n<script>Openbiz.newFormObject('$formObj->m_Name','$formObj->m_jsClass','$subForms'); </script>\n";
            }
            if($formObj->m_AutoRefresh > 0){
            	$formScript .= "\n<script>setTimeout(\"Openbiz.CallFunction('$formObj->m_Name.UpdateForm()');\",\"".($formObj->m_AutoRefresh*1000)."\") </script>\n";
            }
        }
        if ($tplEngine == "Smarty" || $tplEngine == null)
            return FormRenderer::renderSmarty($formObj, $tplFile) . $formScript;
        else
            return FormRenderer::renderPHP($formObj, $tplFile) . $formScript;
    }

    /**
     * Render smarty template for form object
     *
     * @param EasyForm $formObj
     * @param string $tplFile
     * @return string result of rendering process
     */
    static protected function renderSmarty($formObj, $tplFile)
    {
        $smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("formname", $formObj->m_Name);
        $smarty->assign("module", $formObj->getModuleName($formObj->m_Name));
        $smarty->assign("title", $formObj->m_Title);
        $smarty->assign("errors", $formObj->m_Errors);
        $smarty->assign("notices", $formObj->m_Notices);

        // if the $formobj form type is list render table, otherwise render record
        if ($formObj->m_FormType == 'LIST')
        {
            $recordSet = $formObj->fetchDataSet();
            $smarty->assign("dataPanel", $formObj->m_DataPanel->renderTable($recordSet));
        }
        else
        {
            $record = $formObj->fetchData();
            $smarty->assign("dataPanel", $formObj->m_DataPanel->renderRecord($record));
        }

        // render the formobj attributes
        $smarty->assign("form", $formObj->outputAttrs());

        $smarty->assign("actionPanel", $formObj->m_ActionPanel->render());

        $smarty->assign("navPanel", $formObj->m_NavPanel->render());

        if (isset($formObj->m_SearchPanel))
        {
        	$search_record = $formObj->m_SearchPanelValues;        	
            foreach ($formObj->m_SearchPanel as $elem)
            {
                if (!$elem->m_FieldName)
                    continue;
                $post_value = BizSystem::clientProxy()->getFormInputs($elem->m_Name);
                if($post_value){
                	$search_record[$elem->m_FieldName] = $post_value;
                } 
            }            
            $smarty->assign("searchPanel", $formObj->m_SearchPanel->renderRecord($search_record));
        }
        return $smarty->fetch($tplFile);
    }

    /**
     * Render PHP template for form object
     *
     * @param EasyForm $formObj
     * @param string $tplFile
     * @return string result of rendering process
     */
    static protected function renderPHP($formObj, $tplFile)
    {
        $view = BizSystem::getZendTemplate();
        $view->addScriptPath(dirname($tplFile));
        $view->name = $formObj->m_Name;
        $view->title = $formObj->m_Title;
        $view->errors = $formObj->m_Errors;
        $view->notices = $formObj->m_Notices;

        // if the $formobj form type is list render table, otherwise render record
        if ($formObj->m_FormType == 'LIST')
        {
            $recordSet = $formObj->fetchDataSet();
            $view->dataPanel = $formObj->m_DataPanel->renderTable($recordSet);
        }
        else
        {
            $record = $formObj->fetchData();
            $view->dataPanel = $formObj->m_DataPanel->renderRecord($record);
        }

        // render the formobj attributes
        $view->form = $formObj->outputAttrs();

        $view->actionPanel = $formObj->m_ActionPanel->render();
        $view->searchPanel = $formObj->m_SearchPanel->render();
        $view->navPanel = $formObj->m_NavPanel->render();

        return $view->render($formObj->m_TemplateFile);
    }
}
?>