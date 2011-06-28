<?php
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   cubi.menu.widget
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

/**
 * FormRenderer class is form helper for rendering form
 *
 * @package cubi.menu.widget
 * @author Rocky Swen, Jixian
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class MenuRenderer
{
    /**
     * Render widget object
     *
     * @param MenuWidget $widgetObj
     * @return string result of rendering process
     */
    static public function render($widgetObj)
    {
        $tplEngine = $widgetObj->m_TemplateEngine;
        $tplFile = BizSystem::getTplFileWithPath($widgetObj->m_TemplateFile, $widgetObj->m_Package);

        if ($tplEngine == "Smarty" || $tplEngine == null)
            return MenuRenderer::renderSmarty($widgetObj, $tplFile);
        else
            return MenuRenderer::renderPHP($widgetObj, $tplFile);
    }

    /**
     * Render smarty template for widget object
     *
     * @param MenuWidget $widgetObj
     * @param string $tplFile
     * @return string result of rendering process
     */
    static protected function renderSmarty($widgetObj, $tplFile)
    {
        $smarty = BizSystem::getSmartyTemplate();        
        $smarty->assign("widget", $widgetObj->outputAttrs());
        return $smarty->fetch($tplFile);
    }

    /**
     * Render PHP template for widget object
     *
     * @param MenuWidget $widgetObj
     * @param string $tplFile
     * @return string result of rendering process
     */
    static protected function renderPHP($widgetObj, $tplFile)
    {
        $view = BizSystem::getZendTemplate();
        $view->addScriptPath(dirname($tplFile));
        $view->widget = $widgetObj->OutputAttrs();
        return $view->render($widgetObj->m_TemplateFile);
    }
}
?>