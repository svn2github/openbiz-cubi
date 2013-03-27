<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.eventmgr.sample
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class EventLogger
{
	public function observe($event)
	{
  		$triggerObj = $event->getTarget();
		$triggerEvent = $event->getName();
		$params = $event->getParams();
		// get eventlog service
		$eventLog = BizSystem::getService(EVENTLOG_SERVICE);
		// log message
		$eventLog->Log($triggerEvent,"triggered by ".$triggerObj->m_Name);
	}
}

?>