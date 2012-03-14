<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php     BSD
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: Configuration.php 4179 2011-05-26 07:40:53Z rockys $
 */

/**
 * DBUtil class
 *
 * @package   openbiz.bin
 * @author    Rocky Swen <rocky@phpopenbiz.org>
 * @copyright Copyright (c) 2005-2009, Rocky Swen
 * @access    public
 */
class DBUtil
{
	static public function getDBConnection($dbRecord)
    {
        require_once 'Zend/Db.php';

        $params = array (
                'host'     => $dbRecord["server"],
                'username' => $dbRecord["username"],
                'password' => $dbRecord["password"],
                'dbname'   => $dbRecord["db_name"],
                'port'     => $dbRecord["port"],
                'charset'  => $dbRecord["charset"]
        );

        $db = Zend_Db::factory($dbRecord["driver"], $params);

        $db->setFetchMode(PDO::FETCH_NUM);

        if(strtoupper($dbInfo["Driver"])=="PDO_MYSQL" &&
                $dbInfo["Charset"]!="")
        {
            $db->query("SET NAMES '".$params['charset']."'");
        }

        return $db;
    }
}