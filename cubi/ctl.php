<?PHP
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   \
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

//$start = (float) array_sum(explode(' ',microtime())); 
define("USE_CUSTOM_SESSION_HANDLER",true);     
include_once("bin/app_init.php");

include_once(OPENBIZ_BIN."BizController.php");
/*
$end = (float) array_sum(explode(' ',microtime()));
echo "Processing time: ". sprintf("%.4f", ($end-$start))." seconds"; 
*/

