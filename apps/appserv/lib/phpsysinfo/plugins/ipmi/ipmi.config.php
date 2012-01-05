<?php
/**
 * IPMI Plugin Config File
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PSI_Plugin_ipmi
 * @author    Mieczyslaw Nalewaj <namiltd@users.sourceforge.net>
 * @copyright 2009 phpSysInfo
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   SVN: $Id: ipmi.config.php 522 2011-11-08 18:21:09Z jacky672 $
 * @link      http://phpsysinfo.sourceforge.net
 */
/**
 * define how to access the IPMI statistic data
 * - 'command' ipmitool command is run everytime the block gets refreshed or build
 * 	if access error execute first: chmod 666 /dev/ipmi0
 * - 'data' (a file must be available in the data directory of the phpsysinfo installation with the filename "ipmi.txt"; content is the output from "ipmitool sensor")
 */
define('PSI_PLUGIN_IPMI_ACCESS', 'command');
?>
