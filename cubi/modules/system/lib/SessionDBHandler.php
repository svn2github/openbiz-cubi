<?php
define("SESSION_DBNAME","Session");
define("SESSION_TABLE","session");

class SessionDBHandler {
    protected $lifeTime;
    protected $initSessionData;
    protected $sessionDb;

    function __construct()
    {
        $this->lifeTime = TIMEOUT;
        $this->sessionDO = SESSION_DATAOBJ;
    }

    function open($savePath,$sessionName) {
        //echo "session open".nl;
        // connect to session db
        $this->sessionDb = BizSystem::dbConnection(SESSION_DBNAME);
        /*
        $sessionID = session_id();
        if ($sessionID !== "") {
            $this->initSessionData = $this->read($sessionID);
        }*/
        return true;
    }

    function close() {
        //echo "session close".nl;
        $this->lifeTime = null;
        $this->initSessionData = null;
        return true;
    }
 
    function read($sessionID) {
        //echo "session read".nl; 
        //debug_print_backtrace();
        $sql = "SELECT `data` FROM `session` WHERE `id`=?";
        $data = $this->sessionDb->fetchOne($sql, $sessionID);
        $this->initSessionData = $data;
        return $data;
    }

    function write($sessionID,$data) {
        //echo "session write".nl;
        // This is called upon script termination or when session_write_close() is called, which ever is first.
        $expiration = ($this->lifeTime + time());
        try {
            if ($this->initSessionData == null) {
                //echo "insert session data";
                $this->sessionDb->insert('session', array('id'=>$sessionID, 'data'=>$data, 'expiration'=>$expiration));
            }
            else {
                if ($this->initSessionData == $data) {
                    //echo "update session w/o data change";
                    $this->sessionDb->update('session', array('expiration'=>$expiration), "id = '$sessionID'");
                }
                else {
                    //echo "update session w/ data change";
                    $this->sessionDb->update('session', array('data'=>$data, 'expiration'=>$expiration), "id = '$sessionID'");
                }
            }
        }
        catch (Exception $e) {
            echo "SQL error: ".$e->getMessage();
        }
        return true;
    }

    function destroy($sessionID) {
        //echo "session destroy".nl;
        // Called when a user logs out...
        $this->sessionDb->delete('session', "id='$sessionID'");
        return true;
    }

    function gc($maxlifetime) {
        //echo "session gc";
        // garbage collection to delete expired session entried
        $expireTime = time(); // time() - $this->lifeTime;
        $this->sessionDb->delete('session', "expiration < $expireTime");
        return true;
    }
}

$sessionHandler = new SessionDBHandler();
session_set_save_handler(
    array (&$sessionHandler,"open"),
    array (&$sessionHandler,"close"),
    array (&$sessionHandler,"read"),
    array (&$sessionHandler,"write"),
    array (&$sessionHandler,"destroy"),
    array (&$sessionHandler,"gc"));

/*
CREATE TABLE `session` (
    `id` VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `expiration` INT(10) UNSIGNED NOT NULL,
    `data` TEXT COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    KEY `expiration` (`expiration`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/
?>
