<?php
/**
 * FusionCharts PHP Wrapper 
 *
 * This page contains functions that can be used to render FusionCharts.
 *
 * @author     FusionCharts 
 * @version    3.2        
 * @since		4 September 2010
 *
 */

/**
 * ---------------------------------------------------------------------------------------
 * initialize wrapper
 * ---------------------------------------------------------------------------------------
 */ 
$__FC__CONFIG__ = array() ;
__FC_INITIALIZE__();
__FC_INITSTATIC__();

/**
 * ---------------------------------------------------------------------------------------
 * function declarations
 * ---------------------------------------------------------------------------------------
 */ 

/**
 * ---------------------------------------------------------------------------------------
 * Public functions
 * ---------------------------------------------------------------------------------------
 */ 
 
/** 
 * renderChart renders FusionCharts with JavaScript + HTML code required to embed a chart.
 *
 * This function returns an HTML with a DIV and a SCRIPT tag. The DIV contains an ID which 
 * is set in this format $chartId + "DIV". Thd DIV is followed by a JavaScript snippet
 * that contains FusionCharts JavaScript class' constructor function - new FusionCharts(),
 *
 * @param	chartSWF				String  - SWF File Name (and Path) of the chart which you intend to plot
 * @param	dataUrl				String  - If you intend to use dataUrl method (XML or JSON as Url), pass the URL 
 *											as this parameter. Otherwise, set it to "" (in case of dataStr method)
 * @param	dataStr				String  - If you intend to use dataStr method (embedded XML or JSON), pass the 
 *											XML/JSON data as this parameter. Otherwise, set it to "" (in case of dataUrl method)
 * @param	chartId				String  - Id for the chart, using which it will be recognized in the HTML page. 
 *														Each chart on the page needs to have a unique Id.
 * @param	chartWidth			String  - Intended width for the chart  (in pixels WITHOUT px suffix or in percent)
 * @param	chartHeight			String  - Intended height for the chart (in pixels WITHOUT px suffix or in percent)
 * @param	debugMode			Boolean - Whether to start the chart in debug mode
 * @param	registerWithJS		Boolean - Whether to ask chart to register itself with JavaScript
 * @param	allowTransparent	Boolean - Whether to allow the chart to have transparent background. Additionally this set the chart to get rendered in opaque mode
 *
 * @return	Chart HTML + JavaScript code to be added into web page as String
 */

function renderChart( $chartSWF, $dataUrl, $dataStr, $chartId, $chartWidth, $chartHeight, $debugMode=false, $registerWithJS=true, $allowTransparent=false )
{

	$dataFormat = ( FC_GetConfiguration ("dataFormat")=="" ? "xml" : FC_GetConfiguration ("dataFormat") ) . ($dataStr=="" ? "url" : "");
	if (FC_GetConfiguration ("renderAt")=="") FC_SetConfiguration("renderAt", "{$chartId}Div" );

	FC_SetConfiguration("swfUrl" , $chartSWF); 
	FC_SetConfiguration("dataFormat" , $dataFormat);
	FC_SetConfiguration("id", $chartId); 
	FC_SetConfiguration("width", $chartWidth); 
	FC_SetConfiguration("height", $chartHeight);

	if ($debugMode) FC_SetConfiguration("debugMode", boolToNum($debugMode) );

	$wmode = FC_GetConfiguration("forcedwmode" , "constants"); 
	if ( $wmode == "" ) $wmode = $allowTransparent ? "transparent" : "opaque";
	if ( $wmode != "" ) FC_SetConfiguration("wmode", $wmode);

	$dataSource =  @(preg_replace("/[\n\r]/","",($dataStr == "" ? $dataUrl : $dataStr )));
   $datasource_json  =  " \"dataSource\" : "  . ( $dataFormat == "json" ? $dataSource : "\"$dataSource\"" );

	$chart_config_json = "{ " .fc_encode_json( FC_GetConfiguration("params") ) . ", $datasource_json }";
		
	//First we create a new DIV for each chart. We specify the id of DIV as "chartId" + Div.			
	//DIV names are case-sensitive.

    // The Steps in the script block below are:
    //
    //  1) In the DIV the text "Chart" is shown to users before the chart has started loading
    //    (if there is a lag in relaying SWF from server). This text is also shown to users
    //    who do not have Flash Player installed. You can configure it as per your needs.
    //
    //  2) The chart is rendered using FusionCharts Class. Each chart's instance (JavaScript) Id 
    //     is named as chart_"chartId".		
    //
    //  3) Check whether we've to provide data using dataStr method or dataUrl method
    //     save the data for usage below 
	
	
	// generate js code for data provider

	
	// build FusionCharts HTML + JS
	$chart_HTML_JS = <<<HTML_JS
<!-- START Code Block for Chart {$chartId} -->
<div id="{$chartId}Div"> Chart </div>
<script type="text/javascript" ><!--
	// Instantiate the Chart 
	var chart_{$chartId} = new FusionCharts( {$chart_config_json} ).render();
// --></script>
<!-- END Script Block for Chart {$chartId} -->

HTML_JS;


	__FC_INITIALIZE__();
	// return HTML + JS
  	return $chart_HTML_JS;
}



/** 
 * renderChartHTML renders FusionCharts using HTML embedding method.
 *
 * This function does NOT embed the chart using JavaScript class. Instead, it uses
 * direct HTML embedding using OBJECT/EMBED HTML tags.
 *
 * @param	chartSWF				String  - SWF File Name (and Path) of the chart which you intend to plot
 * @param	dataUrl				String  - If you intend to use dataUrl method (XML as Url only, JSON not supported), pass the URL 
 *												as this parameter. Otherwise, set it to "" (in case of dataStr method)
 * @param	dataStr				String  - If you intend to use dataStr method (embedded XML), pass the XML (JSON not supported) 
 *														data as this parameter. Otherwise, set it to "" (in case of dataUrl method)
 * @param	chartId				String  - Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.
 * @param	chartWidth			String  - Intended width for the chart  (in pixels WITHOUT px suffix or in percent)
 * @param	chartHeight			String  - Intended height for the chart (in pixels WITHOUT px suffix or in percent)
 * @param	debugMode			Boolean - Whether to start the chart in debug mode
 * @param	registerWithJS		Boolean - Whether to ask chart to register itself with JavaScript
 * @param	allowTransparent	Boolean - Whether to allow the chart to have transparent background. Additionally this set the chart to get rendered in opaque mode
 *
 * @return	Chart HTML code to be added into web page as String
 */
function renderChartHTML($chartSWF, $dataUrl, $dataStr, $chartId, $chartWidth, $chartHeight, $debugMode=false, $registerWithJS=false, $allowTransparent="") 
{
	
	// detect ssl and rename http:// with https:// 
	if (FC_DetectSSL()) 
	{
		FC_SetConfiguration("pluginspage", str_replace("http://", "https://", FC_GetConfiguration("pluginspage")));
		FC_SetConfiguration("codebase", str_replace("http://", "https://", FC_GetConfiguration("codebase")));
	}
	
	
	// set wmode
	$wmode = FC_GetConfiguration("forcedwmode" , "constants"); 
	if ( $wmode == "" ) $wmode = $allowTransparent ? "transparent" : "opaque";

	// refer to global configuration storage
	FC_SetConfigurations( 
		array ( 
			"movie" 				=> $chartSWF, 
			"src"					=> $chartSWF, 
			"dataXML" 			=> $dataStr,
			"dataURL" 			=> $dataUrl,
			"width" 				=> $chartWidth, 
			"height" 			=> $chartHeight, 
			"chartWidth"		=> $chartWidth, 
			"chartHeight" 		=> $chartHeight, 
			"DOMId" 				=> $chartId,
			"id" 					=> $chartId,
			"debugMode" 		=> boolToNum($debugMode),
			"wmode" 				=> $wmode
		)
	);
	
	// Generate the FlashVars string based on whether dataUrl has been provided
	// or dataXML.
	$strFlashVars = FC_Transform(FC_GetConfiguration("fvars"), "&{key}={value}");
	FC_SetConfiguration ("flashvars", $strFlashVars );

	$strObjectNode = "<object " . FC_Transform(FC_GetConfiguration("object"), " {key}=\"{value}\"") . " >\n" ;
	$strObjectParamsNode = FC_Transform(FC_GetConfiguration("objparams"), "\t<param name=\"{key}\" value=\"{value}\">\n") ;
	$strEmbedNode = "<embed " . FC_Transform(FC_GetConfiguration("embed"), " {key}=\"{value}\"") . " />\n" ;
	
	
	 
$HTML_chart = <<<HTMLCHART
<!-- START Code Block for Chart $chartId -->
{$strObjectNode}
{$strObjectParamsNode}
{$strEmbedNode}
</object>
<!-- END Code Block for Chart $chartId -->
HTMLCHART;

  	__FC_INITIALIZE__();
  	return $HTML_chart;
}




/**
 * Enables Print Manager for Mozilla browsers
 * 
 * This function adds a small JavaScript snippet to the page which enables the Managed Print option for Mozilla basec browsers
 * 
 * There is an optional parameter $directWriteToPage which if set to true would write the code directly to page. Otherwise the 
 * code snippet is returned as string 
 * 
 * @param	directWriteToPage	Boolean  - Whether to write the JavaScript code directly to page or return as string
 *
 * @return	A blank string when the code is directly written to page, otherwize, the JavaScript as string.
 */
function FC_EnablePrintManager($directWriteToPage = false )
{
	$strHTML = "<script type=\"text/javascript\"><!--\n if(FusionCharts && FusionCharts.printManager) FusionCharts.printManager.enabled(true);\n// -->\n</script>";
	if ($directWriteToPage==true) { echo $strHTML; return "" ; } else return $strHTML;
}

/**
 * sets the dataformat to be provided to charts (json/xml)
 *
 * @param	format String  - data format. Default is 'xml'. Other format is 'json'
 *
 */
function FC_SetDataFormat($format="xml")
{
	// stores the dataformat in global configuration store
	FC_SetConfiguration ("dataformat", $format);
}

/**
 * sets renderer type (flash/javascript)
 *
 * @param	renderer String  - Name of the renderer. Default is 'flash'. Other possibility is 'javascript'
 *
 */
function FC_SetRenderer( $renderer="flash" )
{
	// stores the renderer name in global configuration store
	FC_SetConfiguration ("renderer", strtolower($renderer));
}

/**
 * explicitely sets window mode (window(detault)/transpatent/opaque)
 *
 * @param	mode String  - Name of the mode. Default is 'window'. Other possibilities are 'transparent'/'opaque'
 *
 */
function FC_SetWindowMode( $mode="window" )
{
	// stores the window mode to configuration store
	FC_SetConfiguration ( "forcedwmode", $mode, "constants" );
}


/**
 * FC_SetConfiguration sets various configurations of FusionCharts
 *
 * It takes configuration names as first parameter and its value a second parameter
 * There are config groups which can contain common configuration names. All config names in all groups gets set with this value
 * unless group is specified explicitely
 *
 * @param	name		String  - name of configuration 
 * @param	value 	String  - value of configuration
 * @param	group	 	String  - Name of the configuration group (params/fvars/object/objparams/embed/constants)
 * @param	addNew 	Boolean - Whether a new configuration can be added
 *	
 *	@return 	true if values is set. False if value is not set. In case of a new configuration it sets and returns true.
 */
function FC_SetConfiguration ( $name="", $value="" , $group = "", $addNew = true )
{
	// get reference to global storage of configurations
	global $__FC__CONFIG__;
	
	$isSet=false;
	
	if ( $group != ""  && isset($__FC__CONFIG__[strtolower($group)]) )
	{
		// set in global configuration store
		foreach ($__FC__CONFIG__[strtolower($group)] as $skey => $svalue)
		{
			if( strtolower($skey) == strtolower($name) ) 
			$__FC__CONFIG__[strtolower($group)][ $skey ] = $value;
									
			$isSet = true;
		}
		
	}
	else
	{
		foreach ( $__FC__CONFIG__ as $ckey => $cvalue)
		{
			foreach ($cvalue as $skey => $svalue)
			{
				if ( strtolower($skey) == strtolower($name) )
				{
					$__FC__CONFIG__[$ckey][$skey] = $value;
					$isSet = true;
				}
			}
		}

	}

	if (!$isSet && $group != "" && $addNew)
	{
			$__FC__CONFIG__[$group][$name] = $value;
			$isSet = true;
	}
	return $isSet;

}


/**
 * FC_GetConfiguration retrives the values stored for various FusionCharts Configurations
 * Configuration name is to be pased as parameter. Optional group name can be passed.
 *
 * The Configuration groups are - (params/fvars/object/objparams/embed/constants)
 * 
 * 
 * @param	name	String  	- name of configuration or configuration group (params/fvars/object/objparams/embed/constants)
 * @param	group		String  	- name of configuration group to search for (params/fvars/object/objparams/embed/constants)
 *
 * @return	value of configuration as String or if seeting not defined NULL
 *				If a settig group name is specified it returns	an Array containg all configurations of that group
 *
 */
function FC_GetConfiguration( $name, $group ="" )
{
	// get reference to global configuration store
	global $__FC__CONFIG__;
	
	if ( $group == "" )
	{
		// if the configuration is in store
		foreach ( $__FC__CONFIG__ as $ckey => $cvalue )
		{
			if ( strtolower($name) == strtolower($ckey) )
			{
				return $cvalue;
			}
			else
			{

				foreach ($cvalue as $skey => $svalue)
				{
					if ( strtolower($skey) == strtolower($name) )
					{
						return $svalue;
					}
				}
			}
		}
	}
	else
	{
		if( isset($__FC__CONFIG__[$group]) )
		{
			foreach ($__FC__CONFIG__[$group] as $skey => $svalue)
			{
				if ( strtolower($skey) == strtolower($name) )
				{
					$__FC__CONFIG__[$group][$skey] = $svalue;
				}
			}
		}
		
	}
	
	return NULL;
}


/**
 * Sets a collection of configurations
 * 
 * @param	objConfig	Array  - An Array of configurations with key as configuration name and values as  configuration value
 */
function FC_SetConfigurations( $objConfig )
{
	// iterate through array
	foreach ($objConfig as $skey => $svalue)
	{
		// set config
		FC_SetConfiguration  ( $skey, $svalue );
	}
	
}


/**
 * ---------------------------------------------------------------------------------------
 * Helper functions
 * ---------------------------------------------------------------------------------------
 */ 

/**
 * boolToNum function converts boolean values to numeric (1/0)
 * Converts Boolean true to 1 and false to 0
 *
 * @param	value	Varient  - Can be Boolean true or false or numeric value 
 *
 * @return	1/0. true returns 1. false returns 0.
 */
function boolToNum($bVal) {
    return (($bVal==true || $bVal==1 ||  $bVal=="true" ) ? 1 : 0);
}

/**
 * encodedataUrl function encodes the dataUrl before it's served to FusionCharts.
 * If you've parameters in your dataUrl, you necessarily need to encode it.
 *
 * @param	strdataUrl 		String - dataUrl to be fed to chart
 * @param	addNoCacheStr 	Boolean - Whether to add aditional string to URL to disable caching of data
 *
 * @return	URLEncoded Url
 */
function encodedataUrl($strdataUrl, $addNoCacheStr=false) {
    //Add the no-cache string if required
    if ($addNoCacheStr==true) {
        // We add ?FCCurrTime=xxyyzz
        // If the dataUrl already contains a ?, we add &FCCurrTime=xxyyzz
        // We replace : with _, as FusionCharts cannot handle : in URLs
		if (strpos($strdataUrl,"?")<>0)
			$strdataUrl .= "&FCCurrTime=" . Date("H_i_s");
		else
			$strdataUrl .= "?FCCurrTime=" . Date("H_i_s");
    }
	// URL Encode it
	return urlencode($strdataUrl);
}

/**
 * datePart function converts MySQL date based on requested mask
 *
 * @param	mask			String - what part of the date to return "m' for month,"d" for day, and "y" for year
 * @param	dateTimeStr String - MySQL date/time format (yyyy-mm-dd HH:ii:ss)
 *
 * @return	converted date
 */
function datePart($mask, $dateTimeStr) {
    @list($datePt, $timePt) = explode(" ", $dateTimeStr);
    $arDatePt = explode("-", $datePt);
    $dataStr = "";
    // Ensure we have 3 parameters for the date
    if (count($arDatePt) == 3) {
        list($year, $month, $day) = $arDatePt;
        // determine the request
        switch ($mask) {
        case "m": return $month;
        case "d": return $day;
        case "y": return $year;
        }
        // default to mm/dd/yyyy
        return (trim($month . "/" . $day . "/" . $year));
    }
    return $dataStr;
}


/**
 * Converts associative array to To JSON String 
 *
 * @param	mask			String - what part of the date to return "m' for month,"d" for day, and "y" for year
 * @param	dateTimeStr String - MySQL date/time format (yyyy-mm-dd HH:ii:ss)
 *
 * @return	converted date
 */
function fc_encode_json( $json , $enclosed = false)
{

	$strjson = "";
	if($enclosed) $strjson .= "{";
	
	$strjson .= FC_Transform ($json, " \"{key}\" : \"{value}\", ");
	
	$strjson = preg_replace("/, $/","", $strjson );
	
	if($enclosed)$strjson  .= "}";
	
	return $strjson ;
}


/**
 *  Transforms an associaitive array to string
 * 
 *
 * @param	arr			Array - Associative array
 * @param	tFormat 		String - String builder format. The format is a string with placeholder for key and value.
 * 									The function iterated through the array 
 * 									replaces all "{key}" (placeholder for key) in the String with the key name of the array element
 * 									replaces all "{value}"  (placeholder for value) in the String with the value associated with the above key
 *
 * @param	ignoreBlankValues		Boolean - If true it igonores all elements with blank values
 *
 * @return	converted date
 */
function FC_Transform($arr, $tFormat="", $ignoreBlankValues = true)
{
	$converted = "";
	foreach ($arr as $skey => $svalue)
	{

		if($ignoreBlankValues && $svalue== "" ) continue;

		$TFApplied = preg_replace("/{key}/",$skey, $tFormat);
		$TFApplied = preg_replace("/{value}/",$svalue, $TFApplied);
		$converted .= $TFApplied;

	}
	return $converted;
}



/**
 * Initializes FusionCharts generic configurations
 *
 * Prepares the wrapper to load default chart configurations
 *
 */
function __FC_INITIALIZE__()
{

	// access global variable
	global $__FC__CONFIG__;
	
	/** 
	 * Global storage of chart configurations
	 *
	 * debugMode				: Sets debug mode of chart on
	 * RegisterWithJS 		: sets the chart to communicate with JavaScript
	 * wmode 					: sets window mode - possible values "window"/"transparent"/opaque
	 * scaleMode				: 'default value is 'NoScale', other values are 'ExactFit', 'showAll', 'NoBorder'
	 * bgColor 					: set the flash player's background color. This gets shown up if the chart
	 *										background alpha is set less than 100 and wmode is not transparent
	 * lang 						: language, default is english
	 * detectflashversion 	: sets FusionCharts JavaScript class to check version of Flash Player >= 8
	 * AutoInstallRedirect 	: redirects to Flash Player installation page if version is > 8
	 * renderer 				: sets the current FusionCharts renderer. It can be "flash" or "javascript"
	 * dataformat				: sets the data format of FusionCharts. Can be "xml" or "json"
	 */
	
	$__FC__CONFIG__["params"][ "swfUrl" ] = "" ;
	$__FC__CONFIG__["params"][ "width" ] = "" ;
	$__FC__CONFIG__["params"][ "height" ] =  "" ;
	$__FC__CONFIG__["params"][ "renderAt" ] = "" ;
	$__FC__CONFIG__["params"][ "renderer" ] = "" ;
	$__FC__CONFIG__["params"][ "dataSource" ] = "" ;
	$__FC__CONFIG__["params"][ "dataFormat" ] = "" ;
	$__FC__CONFIG__["params"][ "id" ] = "" ;
	$__FC__CONFIG__["params"][ "lang" ] = "" ;
	$__FC__CONFIG__["params"][ "debugMode" ] = "" ; 
	$__FC__CONFIG__["params"][ "registerWithJS" ] = ""  ;
	$__FC__CONFIG__["params"][ "detectFlashVersion" ] = "" ;
	$__FC__CONFIG__["params"][ "autoInstallRedirect" ] = "" ;
	$__FC__CONFIG__["params"][ "wMode" ] = "" ;
	$__FC__CONFIG__["params"][ "scaleMode" ] = ""  ;
	$__FC__CONFIG__["params"][ "menu" ] = "" ;
	$__FC__CONFIG__["params"][ "bgColor" ] = "" ;
	$__FC__CONFIG__["params"][ "quality" ] = "" ;


	$__FC__CONFIG__["fvars"][ "dataURL" ] = "" ;
	$__FC__CONFIG__["fvars"][ "dataXML" ] = "" ;
	$__FC__CONFIG__["fvars"][ "chartWidth" ] = "" ;
	$__FC__CONFIG__["fvars"][ "chartHeight" ] = "" ;
	$__FC__CONFIG__["fvars"][ "DOMId" ] = "" ;
	$__FC__CONFIG__["fvars"][ "registerWithJS" ] = "1" ;
	$__FC__CONFIG__["fvars"][ "debugMode" ] = "0" ;
	$__FC__CONFIG__["fvars"][ "scaleMode" ] = "noScale" ;
	$__FC__CONFIG__["fvars"][ "lang" ] = "EN" ;
	
	$__FC__CONFIG__["object"][ "height" ] = "" ;
	$__FC__CONFIG__["object"][ "width" ] = "" ;
	$__FC__CONFIG__["object"][ "id" ] = "" ;
	$__FC__CONFIG__["object"][ "classid" ] = "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ;
	$__FC__CONFIG__["object"][ "codebase" ] = "http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" ;
	
	$__FC__CONFIG__["objparams"][ "movie" ] = "" ;
	$__FC__CONFIG__["objparams"][ "FlashVars" ] = "" ;
	$__FC__CONFIG__["objparams"][ "scaleMode" ] = "noScale" ;
	$__FC__CONFIG__["objparams"][ "wmode" ] = "opaque" ;
	$__FC__CONFIG__["objparams"][ "bgColor" ] = "" ;
	$__FC__CONFIG__["objparams"][ "quality" ] = "best" ;
	$__FC__CONFIG__["objparams"]["allowScriptAccess"] = "always" ;
	$__FC__CONFIG__["objparams"][ "swLiveConnect" ] = "" ;
	$__FC__CONFIG__["objparams"][ "base" ] = "" ;
	$__FC__CONFIG__["objparams"][ "align" ] = "" ;
	$__FC__CONFIG__["objparams"][ "salign" ] = "" ;
	$__FC__CONFIG__["objparams"][ "scale" ] = "" ;
	$__FC__CONFIG__["objparams"][ "menu" ] = "" ;


	$__FC__CONFIG__["embed"][ "height" ] = "" ;
	$__FC__CONFIG__["embed"][ "width" ] = "" ;
	$__FC__CONFIG__["embed"][ "id" ] = "" ;
	$__FC__CONFIG__["embed"][ "src" ] = "" ;
	$__FC__CONFIG__["embed"][ "flashvars" ] = "" ;
	$__FC__CONFIG__["embed"][ "name" ] = "" ;
	$__FC__CONFIG__["embed"][ "scaleMode" ] = "noScale" ;
	$__FC__CONFIG__["embed"][ "wmode" ] = "opaque" ;
	$__FC__CONFIG__["embed"][ "bgColor" ] = "" ;
	$__FC__CONFIG__["embed"][ "quality" ] = "best" ;
	$__FC__CONFIG__["embed"]["allowScriptAccess"] = "always" ;
	$__FC__CONFIG__["embed"]["type"] = "application/x-shockwave-flash";
	$__FC__CONFIG__["embed"]["pluginspage"]= "http://www.macromedia.com/go/getflashplayer" ;
	$__FC__CONFIG__["embed"][ "swLiveConnect" ] = "" ;
	$__FC__CONFIG__["embed"][ "base" ] = "" ;
	$__FC__CONFIG__["embed"][ "align" ] = "" ;
	$__FC__CONFIG__["embed"][ "salign" ] = "" ;
	$__FC__CONFIG__["embed"][ "scale" ] = "" ;
	$__FC__CONFIG__["embed"][ "menu" ] = "" ;

	$__FC__CONFIG__["constants"][ "forcedwmode" ] = "" ;

}

/**
 * Initializes FusionCharts Static configurations
 *
 * Prepares the wrapper to load default chart configurations
 *
 */
function __FC_INITSTATIC__()
{
	global $__FC__CONFIG__;
	$__FC__CONFIG__["constants"][ "scriptBaseUri" ] = "" ;

}

/**
 * Detects SSL 
 *
 * Returns true if SSL is found
 *
 */
function FC_DetectSSL(){
	if(@$_SERVER["https"] == "on"){
		return true;
	} elseif (@$_SERVER["https"] == 1){
		return true;
	} elseif (@$_SERVER['SERVER_PORT'] == 443) {
		return true;
	} else {
		return true;
	}
} 

?>