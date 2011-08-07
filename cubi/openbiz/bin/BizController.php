<?PHP
/**
 * PHPOpenBiz Framework
 *
 * This file contain BizController class, the C from MVC of phpOpenBiz framework,
 * and execute it. So bootstrap script simply include this file. For sample of
 * bootstrap script please see controller.php under baseapp/bin
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: BizController.php 2731 2010-12-01 07:32:03Z jixian2003 $
 */

// run controller
//
//session_cache_limiter('public');
ob_start();
header('Content-Type: text/html; charset=utf-8');
include_once("sysheader_inc.php");

// start session context object
BizSystem::sessionContext();

$bizCtrller = new BizController();
if($bizCtrller->processSecurityFilters()===true){
	$bizCtrller->dispatchRequest();
}

/**
 * BizController is the class that dispatches client requests to proper objects
 *
 * @package   openbiz.bin
 * @author    Rocky Swen <rocky@phpopenbiz.org>
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @access    public
 */
class BizController
{                  
    private $_userTimeoutView = USER_TIMEOUT_VIEW;
    private $_accessDeniedView = ACCESS_DENIED_VIEW;
    private $_securityDeniedView = SECURITY_DENIED_VIEW;

    /**
     * Process Security Filters
     *
     * @return boolean true if success, and false if have error
     */
    public function processSecurityFilters()
    {
        $securityObj = BizSystem::getService(SECURITY_SERVICE);
        $securityObj->processFilters();
        if($err_msg = $securityObj->getErrorMessage())
        {
        	if($this->_securityDeniedView){
        		$view = $this->_securityDeniedView;
        	}else{
        		$view = $this->_accessDeniedView;        	
        	}
            $this->renderView($view);
            return false;            
        }
        return true;
    }

    /**
     * Dispatches client requests to proper objects, print the returned html text.
     *
     * @return void
     */
    public function dispatchRequest()
    {
        if ($this->_checkSessionTimeout())  // show timeout view
        {
            BizSystem::sessionContext()->destroy();
            return $this->renderView($this->_userTimeoutView);
        }

        // ?view=...&form=...&rule=...&mode=...&...
        //$getKeys = array_keys($_GET);
        //if ($getKeys[0] == "view")
        if (isset($_GET['view']))
        {
            $form = isset($_GET['form']) ? $_GET['form'] : "";
            $rule = isset($_GET['rule']) ? $_GET['rule'] : "";
            $hist = isset($_GET['hist']) ? $_GET['hist'] : "";
            $viewName = $_GET['view'];
            $params = $this->_getParameters();
            
            if(defined('NOTFOUND_VIEW'))
            {
            	if(!RESOURCE::getXmlFileWithPath($viewName)){
            		return $this->renderView(NOTFOUND_VIEW, $form, $rule, $params, $hist);            		
            		exit;
            	}            
            }
            
            if (!$this->_checkViewAccess($viewName))  //access denied error
                return $this->renderView($this->_accessDeniedView);
            
			return $this->renderView($viewName, $form, $rule, $params, $hist);
        }
        else if (isset($_REQUEST['_thisView']) && !empty($_REQUEST['_thisView'])) {
            BizSystem::instance()->setCurrentViewName($_REQUEST['_thisView']);
        }

        $retval = $this->invoke();

        print($retval." ");
        exit();
    }

    /**
     * Get the parameter from the url
     *
     * @return array parameter array
     */
    private function _getParameters()
    {
        $getKeys = array_keys($_GET);
        $params = null;
        // read parameters "param:name=value"
        foreach ($getKeys as $key)
        {
            if (substr($key, 0, 6) == "param:")
            {
                $paramName = substr($key, 6);
                $paramValue = $_GET[$key];
                $params[$paramName] = $paramValue;
            }
        }
        return $params;
    }

    /**
     * Get user profile array. Profile is provided by profileService
     *
     * @return array profile array
     */
    private function _getUserProfile()
    {
        return BizSystem::getUserProfile();
    }

    /**
     * Check if session timed out.
     *
     * @return boolean true - session timed out, false - session alive
     */
    private function _checkSessionTimeout()
    {
        return BizSystem::sessionContext()->isTimeout();
    }

    /**
     * Check if the view can be accessed by current user. Call accessService to do the check
     *
     * @param string $viewName view name
     * @return boolean true= allow, false not allow
     */
    private function _checkViewAccess($viewName)
    {
		// load accessService
		$svcobj = BizSystem::getService(ACCESS_SERVICE);    
		return $svcobj->allowViewAccess($viewName);
    }

    /**
     * Render a bizview
     *
     * @param string $viewName name of bizview
     * @param string $rule the search rule of a bizform who is not depent on (a subctrl of) another bizform
     * @return void
     */
    public function renderView($viewName, $form="", $rule="", $params=null, $hist="")
    {
        $bizSystem = BizSystem::instance();       

        /* @var $viewObj EasyView */
        if ($viewName == "__DynPopup")
        {
            $viewObj = BizSystem::getObject($viewName);
            $viewObj->render();
            return;
        }

        // if previous view is different with the to-be-loaded view, clear the previous session objects
        $prevViewName = $bizSystem->getCurrentViewName();
        $prevViewSet = $bizSystem->getCurrentViewSet();

        // need to set current view before get view object
        $bizSystem->setCurrentViewName($viewName);

        $viewObj = BizSystem::getObject($viewName);
        if(!$viewObj)
            return;
        $viewSet = $viewObj->getViewSet();
        $bizSystem->setCurrentViewSet($viewSet);

        /*
        if ($prevViewSet && $viewSet && $prevViewSet == $viewSet)   // keep prev view session objects if they have same viewset
            BizSystem::sessionContext()->clearSessionObjects(true);
        else
            BizSystem::sessionContext()->clearSessionObjects(false);
		*/
		BizSystem::sessionContext()->clearSessionObjects(true);
            
        if ($hist == "N") // clean view history
            $viewObj->CleanViewHistory();

        if ($form != "" && $rule != "")
            $viewObj->processRule($form, $rule, TRUE);

        if ($params)
            $viewObj->setParameters($params);

        if (isset($_GET['mode']))   // can specify mode of form
            $viewObj->SetFormMode($form, $_GET['mode']);

        $viewObj->render();
    //BizController::hidePageLoading();
    }

    /**
     * Invoke the action passed from browser
     *
     * @return HTML content
     */
    protected function invoke()
    {
		//patched by jixian for fix ajax post data
        if(isset($_POST['__url']))
        {
            $getUrl=parse_url($_POST['__url']);
            $query=$getUrl['query'];
            $parameter=explode('&',$query);
            foreach($parameter as $param)
            {
                $data=explode('=',$param);
                $name=$data[0];
                $value=$data[1];
                $_GET[$name]=$value;
            }
        }

        $func = (isset($_REQUEST['F']) ? $_REQUEST['F'] : "");
        $arg_list = array();
        $i = 0;

        if ($func != "")
        {
            eval("\$P$i = (isset(\$_REQUEST['P$i']) ? \$_REQUEST['P$i']:'');");
            $Ptmp = "P". $i;

            if (strstr($P0, Popup_Suffix))
            {
                $name_len = strlen($P0);
                $suffix_len = strlen(Popup_Suffix);
                $P0 = substr($P0, 0, $name_len - $suffix_len - 1) . "]";
            }

            while ($$Ptmp != "")
            {
                $parm = $$Ptmp;
                $parm = substr($parm, 1, strlen($parm) - 2);
                $arg_list[] = $parm;
                $i++;
                eval("\$P$i = (isset(\$_REQUEST['P$i']) ? \$_REQUEST['P$i']:'');");
                $Ptmp = "P". $i;
            }
        }
        else
            return;
      
        if ($func != "RPCInvoke" && $func != "Invoke")
        {
            trigger_error("$func is not a valid invocation", E_USER_ERROR);
            return;
        }
        if ($func == "RPCInvoke")
            BizSystem::clientProxy()->setRPCFlag(true);

        // invoke the function
        $num_arg = count($arg_list);
        if ($num_arg < 2)
        {
            $errmsg = BizSystem::getMessage("SYS_ERROR_RPCARG", array($class));
            trigger_error($errmsg, E_USER_ERROR);
        }
        else
        {
            $objName = array_shift($arg_list); 
            $methodName = array_shift($arg_list);

            $obj= BizSystem::getObject($objName);

            if ($obj)
            {
                if (method_exists($obj, $methodName))
                {
                    if (!$this->validateRequest($obj, $methodName))
                    {
                        $errmsg = BizSystem::getMessage("SYS_ERROR_REQUEST_REJECT", array($obj->m_Name, $methodName));
                        trigger_error($errmsg, E_USER_ERROR);
                    }
                    switch (count($arg_list)) 
                    {
                        case 0: $rt_val = $obj->$methodName(); break;
                        case 1: $rt_val = $obj->$methodName($arg_list[0]); break;
                        case 2: $rt_val = $obj->$methodName($arg_list[0], $arg_list[1]); break;
                        case 3: $rt_val = $obj->$methodName($arg_list[0], $arg_list[1], $arg_list[2]); break;
                        default: $rt_val = call_user_func_array(array($obj, $methodName), $arg_list);
                    }
                }
                else
                {
                    $errmsg = BizSystem::getMessage("SYS_ERROR_METHODNOTFOUND",array($objName, $methodName));
                    trigger_error($errmsg, E_USER_ERROR);
                }
            }
            else
            {
                $errmsg = BizSystem::getMessage("SYS_ERROR_CLASSNOTFOUND", array($objName));
                trigger_error($errmsg, E_USER_ERROR);
            }

            if ($func == "Invoke")  // no RPC invoke, page reloaded -> rerender view
            {
                if (BizSystem::clientProxy()->hasOutput())
                    BizSystem::clientProxy()->printOutput();
            }
            else if ($func == "RPCInvoke")  // RPC invoke
            {
                if (BizSystem::clientProxy()->hasOutput())
                {
                    if ($_REQUEST['jsrs'] == 1)
                        echo "<html><body><form name=\"jsrs_Form\"><textarea name=\"jsrs_Payload\" id=\"jsrs_Payload\">";
                    BizSystem::clientProxy()->printOutput();
                    if ($_REQUEST['jsrs'] == 1)
                        echo "</textarea></form></body></html>";
                }
                else
                    return $rt_val;
            }
        }
    }

    /**
     * Validate the request from client.
     *
     * @param object $obj the to be called object
     * @param string $methodName the to be called method name
     * @return boolean
     */
    protected function validateRequest($obj, $methodName)
    {
        if (!is_a($obj,"EasyForm") && !is_a($obj,"BizForm"))
        {
            return false;
        }
        if (is_a($obj,"EasyForm"))
        {
            if (!$obj->validateRequest($methodName))
            {
                return false;
            }
        }
        return true;
    }
}
?>
