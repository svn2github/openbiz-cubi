<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BizClassLoader
 *
 * @author k6
 */
class BizClassLoader {
    
    private static $_classNameCache = array();
    
    public static function loadClass($className, $packageName='')
    {
        //echo __METHOD__ . '-' . $className . '-' . $packageName.PHP_EOL; 
        if (isset(self::$_classNameCache[$packageName.$className])) return true;
        if (strpos($className, 'Zend') === 0) return true;
        $filePath = self::getLibFileWithPath($className, $packageName);
        //echo $filePath;
        if ($filePath)
        {
            include_once($filePath); // auto_load
            self::$_classNameCache[$packageName.$className] = 1;
            return true;
        }
        return false;
    }
    
    
    /**
     * Get core path of class
     *
     * @param string $className class name
     * @return string full file name of class
     */
    public static function getCoreLibFilePath($className)
    {
		//echo "_getCoreLibFilePath($className, $packageName)\n";
        // use class map first
        if (is_array(self::$coreClassMap) && isset($className) && isset( self::$coreClassMap[$className]  )) {
            $classFile = OPENBIZ_HOME . self::$coreClassMap[$className];
            //if (file_exists($classFile)) // core file always exist
            return $classFile;
        } else { // if class not yet collect on class map, scan core path.                 
            $classFile = $className . '.php';
            // TODO: search the file under bin/, bin/data, bin/ui. bin/service, bin/easy, bin/easy/element.
            // guess class type and folder
            $lowClassName = strtolower($className);
            if (strrpos($lowClassName,'service')>0) $corePaths = array('service/');
            else if (strrpos($lowClassName,'form')>0 || strrpos($lowClassName,'form')===0) $corePaths = array('easy/');
            else if (strrpos($lowClassName,'view')>0 || strrpos($lowClassName,'view')===0) $corePaths = array('easy/');
            else if (strrpos($lowClassName,'dataobj')>0) $corePaths = array('data/');
            else $corePaths = array('easy/element/','','data/', 'easy/', 'service/');
            //$corePaths = array('', 'data/', 'easy/', 'easy/element/', 'ui/', 'service/');
            foreach ($corePaths as $path)
            {
                $_classFile = OPENBIZ_BIN . $path . $classFile;
                //echo "file_exists($_classFile)\n";
                if (file_exists($_classFile))
                    return $_classFile;
            }
            return null;
        }
    }
    
    
    /**
     * Get openbiz library php file path by searching modules/package, /bin/package and /bin
     *
     * @param string $className
     * @return string php library file path
     * */
    public static function getLibFileWithPath($className, $packageName="")
    {
        if (!$className)
            return;
        
		//echo "getLibFileWithPath($className, $packageName)\n";
		// search it in cache first
        $cacheKey = $className . "_path";
        if (extension_loaded('0') && ($filePath = apc_fetch($cacheKey)) != null)
            return $filePath;

        if (strpos($className, ".") > 0)
            $className = str_replace(".", "/", $className);

        $filePath = null;
        $classFile = $className . ".php";
        $classFile_0 = $className . ".php";
        // convert package name to path, add it to classfile
        $classFileIsFound = false;
        if ($packageName)
        {
            $path = str_replace(".", "/", $packageName);
            // check the leading char '@'
            $checkExtModule = true;
            if (strpos($path, '@') === 0) {
                $path = substr($path, 1);
                $checkExtModule = false;
            }
            
            // search in apphome/modules directory first, search in apphome/bin directory then
            $classFiles[0] = MODULE_PATH . "/" . $path . "/" . $classFile;
            $classFiles[1] = APP_HOME . "/bin/" . $path . "/" . $classFile;
            if ($checkExtModule && defined('MODULE_EX_PATH')) array_unshift($classFiles, MODULE_EX_PATH . "/" . $path . "/" . $classFile);
            foreach ($classFiles as $classFile)
            {
				//echo "file_exists($classFile)\n";
                if (file_exists($classFile))
                {
                    $filePath = $classFile;
                    $classFileIsFound = true;
                    break;
                }
            }
        }

        if (!$classFileIsFound)
            $filePath = BizClassLoader::getCoreLibFilePath($className);
        // cache it to save file search
        if ($filePath && extension_loaded('apc'))
            apc_store($cacheKey, $filePath);
        /*if (!file_exists($filePath)) {
            trigger_error("Cannot find the library file of $className", E_USER_ERROR);
        }*/
        return $filePath;
    }
    
    
    
        /**
     * class map for openbiz core class
     * @author agus suhartono
     * @var array
     */
    public static $coreClassMap = array(
            "BizController" => "/bin/BizController.php",
            "BizSystem" => "/bin/BizSystem.php",
            "ClientProxy" => "/bin/ClientProxy.php",
            "Configuration" => "/bin/Configuration.php",
            "OB_ErrorHandler" => "/bin/ErrorHandler",
            "Expression" => "/bin/Expression.php",
            "I18n" => "/bin/I18n.php",
            "ObjectFactory" => "/bin/ObjectFactory.php",
            "Resource" => "/bin/Resource.php",
            "SessionContext" => "/bin/SessionContext.php",
            "TypeManager" => "/bin/TypeManager.php",
            "UserSetting" => "/bin/UserSetting.php",
            "BDOException" => "/bin/sysclass_inc.php",
            "BFMException" => "/bin/sysclass_inc.php",
            "BSVCException" => "/bin/sysclass_inc.php",
            "MetaIterator" => "/bin/sysclass_inc.php",
            "MetaObject" => "/bin/sysclass_inc.php",
            "Parameter" => "/bin/sysclass_inc.php",
            "ValidationException" => "/bin/sysclass_inc.php",
            "iSessionObject" => "/bin/sysclass_inc.php",
            "iUIControl" => "/bin/sysclass_inc.php",
            
            "BizDataObj" => "/bin/data/BizDataObj.php",
            "BizDataObj_Abstract" => "/bin/data/BizDataObj_Abstract.php",
            "BizDataObj_Lite" => "/bin/data/BizDataObj_Lite.php",
            "BizDataSql" => "/bin/data/BizDataSql.php",
            "BizDataTree" => "/bin/data/BizDataTree.php",
            "NodeRecord" => "/bin/data/BizDataTree.php",            
            "BizField" => "/bin/data/BizField.php",
            "DataRecord" => "/bin/data/DataRecord.php",
            "DataSet" => "/bin/data/DataSet.php",
            "BizDataObj_Assoc" => "/bin/data/private/BizDataObj_Assoc.php",
            "BizDataObj_SQLHelper" => "/bin/data/private/BizDataObj_SQLHelper.php",
            "BizRecord" => "/bin/data/private/BizRecord.php",
            "ObjReference" => "/bin/data/private/ObjReference.php",
            "TableJoin" => "/bin/data/private/TableJoin.php",            
            
            "DynaView" => "/bin/easy/DynaView.php",
            "EasyForm" => "/bin/easy/EasyForm.php",
            "EasyFormGrouping" => "/bin/easy/EasyFormGrouping.php",
            "EasyFormTree" => "/bin/easy/EasyFormTree.php",
            "EasyFormWizard" => "/bin/easy/EasyFormWizard.php",
            "EasyView" => "/bin/easy/EasyView.php",
            "EasyViewWizard" => "/bin/easy/EasyViewWizard.php",
            "FormRenderer" => "/bin/easy/FormRenderer.php",
            "HTMLMenus" => "/bin/easy/HTMLMenus.php",
            "HTMLTabs" => "/bin/easy/HTMLTabs.php",
            "TabView" => "/bin/easy/HTMLTabs.php",            
            "HTMLTree" => "/bin/easy/HTMLTree.php",
            "Panel" => "/bin/easy/Panel.php",
            "PickerForm" => "/bin/easy/PickerForm.php",
            "ViewRenderer" => "/bin/easy/ViewRenderer.php",
            
            "AutoSuggest" => "/bin/easy/element/AutoSuggest.php",
            "Button" => "/bin/easy/element/Button.php",
            "CKEditor" => "/bin/easy/element/CKEditor.php",
            "CheckListbox" => "/bin/easy/element/CheckListbox.php",
            "Checkbox" => "/bin/easy/element/Checkbox.php",
            "ColorPicker" => "/bin/easy/element/ColorPicker.php",
            "ColumnBar" => "/bin/easy/element/ColumnBar.php",
            "ColumnBool" => "/bin/easy/element/ColumnBool.php",
            "ColumnHidden" => "/bin/easy/element/ColumnHidden.php",
            "ColumnImage" => "/bin/easy/element/ColumnImage.php",
            "ColumnList" => "/bin/easy/element/ColumnList.php",
            "ColumnPassword" => "/bin/easy/element/ColumnPassword.php",
            "ColumnShare" => "/bin/easy/element/ColumnShare.php",
            "ColumnSorting" => "/bin/easy/element/ColumnSorting.php",
            "ColumnStyle" => "/bin/easy/element/ColumnStyle.php",
            "ColumnText" => "/bin/easy/element/ColumnText.php",
            "ColumnValue" => "/bin/easy/element/ColumnValue.php",
            "DropDownList" => "/bin/easy/element/DropDownList.php",
            "EditCombobox" => "/bin/easy/element/EditCombobox.php",
            "Element" => "/bin/easy/element/Element.php",
            "File" => "/bin/easy/element/File.php",
            "FileUploader" => "/bin/easy/element/FileUploader.php",
            "FormElement" => "/bin/easy/element/FormElement.php",
            "HTMLBlock" => "/bin/easy/element/HTMLBlock.php",
            "HTMLButton" => "/bin/easy/element/HTMLButton.php",
            "Hidden" => "/bin/easy/element/Hidden.php",
            "IDCardReader" => "/bin/easy/element/IDCardReader.php",
            "IFrameBox" => "/bin/easy/element/IFrameBox.php",
            "ImageSelector" => "/bin/easy/element/ImageSelector.php",
            "ImageUploader" => "/bin/easy/element/ImageUploader.php",
            "InputDate" => "/bin/easy/element/InputDate.php",
            "InputDateRangePicker" => "/bin/easy/element/InputDateRangePicker.php",
            "InputDatetime" => "/bin/easy/element/InputDatetime.php",
            "InputElement" => "/bin/easy/element/InputElement.php",
            "InputPassword" => "/bin/easy/element/InputPassword.php",
            "InputPicker" => "/bin/easy/element/InputPicker.php",
            "InputText" => "/bin/easy/element/InputText.php",
            "LabelBar" => "/bin/easy/element/LabelBar.php",
            "LabelBool" => "/bin/easy/element/LabelBool.php",
            "LabelImage" => "/bin/easy/element/LabelImage.php",
            "LabelList" => "/bin/easy/element/LabelList.php",
            "LabelPassword" => "/bin/easy/element/LabelPassword.php",
            "LabelText" => "/bin/easy/element/LabelText.php",
            "LabelTextPaging" => "/bin/easy/element/LabelTextPaging.php",
            "LabelTextarea" => "/bin/easy/element/LabelTextarea.php",
            "Listbox" => "/bin/easy/element/Listbox.php",
            "OptionElement" => "/bin/easy/element/OptionElement.php",
            "PageSelector" => "/bin/easy/element/PageSelector.php",
            "PagesizeSelector" => "/bin/easy/element/PagesizeSelector.php",
            "Password" => "/bin/easy/element/Password.php",
            "Radio" => "/bin/easy/element/Radio.php",
            "RawData" => "/bin/easy/element/RawData.php",
            "ResetButton" => "/bin/easy/element/ResetButton.php",
            "RichText" => "/bin/easy/element/RichText.php",
            "RowCheckbox" => "/bin/easy/element/RowCheckbox.php",
            "Spacer" => "/bin/easy/element/Spacer.php",
            "SubmitButton" => "/bin/easy/element/SubmitButton.php",
            "Textarea" => "/bin/easy/element/Textarea.php",
            "TreeLabelText" => "/bin/easy/element/TreeLabelText.php",
            "TreeListbox" => "/bin/easy/element/TreeListbox.php",
   
            "accessService" => "/bin/service/accessService.php",
            "aclService" => "/bin/service/aclService.php",
            "auditService" => "/bin/service/auditService.php",
            "authService" => "/bin/service/authService.php",
            "cacheService" => "/bin/service/cacheService.php",
            "chartService" => "/bin/service/chartService.php",
            "compileService" => "/bin/service/compileService.php",
            "cryptService" => "/bin/service/cryptService.php",
            "doTriggerService" => "/bin/service/doTriggerService.php",
            "emailService" => "/bin/service/emailService.php",
            "excelService" => "/bin/service/excelService.php",
            "genIdService" => "/bin/service/genIdService.php",
            "ioService" => "/bin/service/ioService.php",
            "localeInfoService" => "/bin/service/localeInfoService.php",
            "logService" => "/bin/service/logService.php",
            "pdfService" => "/bin/service/pdfService.php",
            "profileService" => "/bin/service/profileService.php",
            "queryService" => "/bin/service/queryService.php",
            "reportService" => "/bin/service/reportService.php",
            "securityService" => "/bin/service/securityService.php",
            "validateService" => "/bin/service/validateService.php",

            "QueryStringParam" => "/bin/util/QueryStringParam.php",
            "XMLParser" => "/bin/util/xmltoarray.php",
            
            "Smarty" => "/others/Smarty/libs/Smarty.class.php",
        
        );


    
}

?>
