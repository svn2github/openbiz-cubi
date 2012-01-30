<?php
if(!defined('SYS_ERROR_RPCARGS'))
define('SYS_ERROR_RPCARGS', "You pass less than 2 arguments which are object name and method name.");
if(!defined('SYS_ERROR_CLASSNOTFOUND'))
define('SYS_ERROR_CLASSNOTFOUND', "Cannot find the class with name as %s.");
if(!defined('SYS_ERROR_METHODNOTFOUND'))
define('SYS_ERROR_METHODNOTFOUND', "Object %s doesn't have such a method %s.");
if(!defined('SYS_ERROR_NODBINFO'))
define('SYS_ERROR_NODBINFO', "No Database indefine('Formation found in the config file.");
if(!defined('SYS_ERROR_INVALID_THEME'))
define('SYS_ERROR_INVALID_THEME', "Unable to find a valide entry with Name as '%s' in metadata/Config.xml. Please add a Theme entry with Name as '%s' in metadata/Config.xml file");
if(!defined('SYS_ERROR_REQUEST_REJECT'))
define('SYS_ERROR_REQUEST_REJECT', "The client request '%s->%s' is not allowed.");
if(!defined('SYS_ERROR_INVALID_MSGFILE'))
define('SYS_ERROR_INVALID_MSGFILE', "Unable to open the message file %s.");

if(!defined('DATA_UNABLE_CONN_DB'))
define('DATA_UNABLE_CONN_DB', "Unable to connection to database %s.");
if(!defined('DATA_INVALID_DBNAME'))
define('DATA_INVALID_DBNAME', "Unable to find a valide entry with Name as '%s' in metadata/Config.xml. Please add a Database entry with Name as '%s' in metadata/Config.xml file");
if(!defined('DATA_NOT_UNIQUE'))
define('DATA_NOT_UNIQUE', "Unable to save the data because uniqueness check on %s fails.");
if(!defined('DATA_FIELD_REQUIRED'))
define('DATA_FIELD_REQUIRED', "Field %s is required.");
if(!defined('DATA_FIELD_INVALID_INPUT'))
define('DATA_FIELD_INVALID_INPUT', "Unable to validate field [%s] = %s as input value against rule %s.");
if(!defined('DATA_NO_PERMISSION_UPDATE'))
define('DATA_NO_PERMISSION_UPDATE', "You don't have permission to update this record.");
if(!defined('DATA_NO_PERMISSION_DELETE'))
define('DATA_NO_PERMISSION_DELETE', "You don't have permission to delete this record.");
if(!defined('DATA_UNABLE_GET_ID'))
define('DATA_UNABLE_GET_ID', "Unable to get ID for new inserted record: Id column is not Identity type.");
if(!defined('DATA_FIELD_INCORRECT_TYPE'))
define('DATA_FIELD_INCORRECT_TYPE', "The value you input on %s is not a vaild %s.");
if(!defined('DATA_UNABLE_DEL_REC_CASCADE'))
define('DATA_UNABLE_DEL_REC_CASCADE', "Unable to delete the record due to cascade restriction on %s.");
if(!defined('DATA_UNABLE_UPD_REC_CASCADE'))
define('DATA_UNABLE_UPD_REC_CASCADE', "Unable to update the record due to cascade restriction on %s.");
if(!defined('DATA_ERROR_QUERY'))
define('DATA_ERROR_QUERY', "Error in query:");

if(!defined('FORM_ELEMENT_REQUIRED'))
define('FORM_ELEMENT_REQUIRED', "%s is required.");
if(!defined('FORM_ELEMENT_INVALID_INPUT'))
define('FORM_ELEMENT_INVALID_INPUT', "Unable to validate element [%s] = %s as input value against rule %s.");
if(!defined('BFM_ERROR_INVALID_DISPMODE'))
define('BFM_ERROR_INVALID_DISPMODE', "Unable to find a valid display mode for BizForm %s.");
if(!defined('PLEASE_EDIT_A_RECORD'))
define('PLEASE_EDIT_A_RECORD', "Please select a record to edit.");
if(!defined('UNABLE_TO_LOCATE_TEMPLATE_FILE'))
define('UNABLE_TO_LOCATE_TEMPLATE_FILE', "Unable to location template file %s.");

if(!defined('FORM_OPEATION_NOT_PERMITTED'))
define('FORM_OPEATION_NOT_PERMITTED',"You don't have enough permission to do this operation.");

?>