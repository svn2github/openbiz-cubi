<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.license.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: LicenseUtil.php 3361 2012-05-31 06:01:42Z rockyswen@gmail.com $
 */


class LicenseUtil
{
    /* linux make_license configuration
	const make_license = "/src/license/make_license";
	const licensePath = "/src/license/make_license";
	const serverDataPath = "/src/license/make_license";
	*/
	// windows make_license configuration
	const make_license = "c:/ioncube/make_license";
    const licensePath = 'c:/ioncube/tmp/license';
    const serverDataPath = 'c:/ioncube/tmp/serverdata';
    
    static public function getPassPhrase($package)
    {
        return strrev($package);
    }

    static public function getLicenseFilename($package)
    {
        return "license_$package";
    }
    
    static public function getTrialDays()
    {
        return "30";
    }
    
    static public function getTrialKey()
    {
        return "TRIAL";
    }
    
    // generate license
    // throw exception in case of error
    public static function generateLicense($pass, $expireDates, $serverDataFile, $licenseFile)
    {
        // invoke make_license command
        $expireIn = $expireDates."d";
		if (!$serverDataFile) {
			$cmd = self::make_license." --passphrase $pass --expire-in $expireIn -o $licenseFile";
		}
		else {
			$cmd = self::make_license." --passphrase $pass --expire-in $expireIn --use-server-file $serverDataFile --select-adapters '*' -o $licenseFile";
		}
        exec($cmd);
    }
    
    public static function decodeServerData($serverDataFile)
    {
        $cmd = self::make_license." --decode-server-file $serverDataFile";
        exec($cmd, $output);
        $outputText = implode("\n", $output);
        return $outputText;
    }
    
    public static function getAdapterMACs($clearServerData)
    {
        $dataArray = explode("\n", $clearServerData);
        $MACs = array();
        foreach ($dataArray as $line) {
            if (strpos($line, 'MAC:')===0) {
                $mac = str_replace('MAC: ','',$line);
                $MACs[] = $mac;
            }
        }
        return $MACs;
    }
}
?>