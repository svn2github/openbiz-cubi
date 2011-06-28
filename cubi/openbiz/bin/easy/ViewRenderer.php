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
 * @version   $Id: ViewRenderer.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

/**
 * ViewRenderer class is view helper for rendering form
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class ViewRenderer
{

    /**
     * Render view object
     *
     * @param EasyView $viewObj
     * @return string result of rendering process
     */
    static public function render($viewObj)
    {
        $tplEngine = $viewObj->m_TemplateEngine;
        $tplFile = BizSystem::getTplFileWithPath($viewObj->m_TemplateFile, $viewObj->m_Package);

        if ($tplEngine == "Smarty" || $tplEngine == null)
            return ViewRenderer::renderSmarty($viewObj, $tplFile);
        else
            return ViewRenderer::renderPHP($viewObj, $tplFile);
    }


    /**
     * Render smarty template for view object
     *
     * @param EasyView $viewObj
     * @param string $tplFile
     * @return string result of rendering process
     */
    static protected function renderSmarty($viewObj, $tplFile)
    {
        $smarty = BizSystem::getSmartyTemplate();
        $newClntObjs = '';

        // render the viewobj attributes
        $smarty->assign("view", $viewObj->outputAttrs());
        $smarty->assign("module", $viewObj->getModuleName($viewObj->m_Name));

        if ($viewObj->m_Tiles)
        {
        	foreach ($viewObj->m_Tiles as $tname=>$tile)
        	{
        		foreach ($tile as $formRef)
        		{
        			if ($formRef->m_Display == false)
		                continue;
	
		            $tiles[$tname][$formRef->m_Name] = BizSystem::getObject($formRef->m_Name)->render();
		            $tiletabs[$tname][$formRef->m_Name] = $formRef->m_Description;
        		}
        	}
        }
        else 
        {
	        foreach ($viewObj->m_FormRefs as $formRef)
	        {
	            if ($formRef->m_Display == false)
	                continue;
	
	            $forms[$formRef->m_Name] = BizSystem::getObject($formRef->m_Name)->render();	            
	            $formtabs[$formRef->m_Name] = $formRef->m_Description;
	            
	        }
        }

        // add clientProxy scripts
        $includedScripts = BizSystem::clientProxy()->getAppendedScripts();
        $styles = BizSystem::clientProxy()->getAppendedStyles();

        if ($viewObj->m_IsPopup && $bReRender == false)
        {
            $moveToCenter = "moveToCenter(self, ".$viewObj->m_Width.", ".$viewObj->m_Height.");";
            $scripts = $includedScripts."\n<script>\n" . $newClntObjs . $moveToCenter . "</script>\n";
        }
        else
            $scripts = $includedScripts."\n<script>\n" . $newClntObjs . "</script>\n";

        if ($viewObj->m_Title)
            $title = Expression::evaluateExpression($viewObj->m_Title,$viewObj);
        else
        	$title = $viewObj->m_Description;
        
        $smarty->assign("scripts", $scripts);
        $smarty->assign("style_sheets", $styles);
        $smarty->assign("title", $title);
        $smarty->assign("description", $viewObj->m_Description);
        $smarty->assign("keywords", $viewObj->m_Keywords);
        $smarty->assign("forms", $forms);
        $smarty->assign("formtabs", $formtabs);
        $smarty->assign("tiles", $tiles);
        $smarty->assign("tiletabs", $tiletabs);

        if ($viewObj->m_ConsoleOutput)
            $smarty->display(BizSystem::getTplFileWithPath($viewObj->m_TemplateFile, $viewObj->m_Package));
        else
            return $smarty->fetch(BizSystem::getTplFileWithPath($viewObj->m_TemplateFile, $viewObj->m_Package));
    }

    /**
     * Render PHP template for view object
     *
     * @param EasyForm $formObj
     * @param string $tplFile
     * @return string result of rendering process
     */
    static protected function renderPHP($viewObj, $tplFile)
    {
    }

    /**
     * Set headers of view
     * 
     * @param EasyView $viewObj
     * @return void
     */
    static protected function setHeaders($viewObj)
    {
        // get the cache attribute
        // if cache = browser, set the cache control in headers
        header('Pragma:', true);
        header('Cache-Control: max-age=3600', true);
        $offset = 60 * 60 * 24 * -1;
        $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
        header($ExpStr, true);
    }
}
?>