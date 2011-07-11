<?php

include_once MODULE_PATH.'/websvc/lib/WebsvcService.php';

class TicketService extends WebsvcService
{
    protected $ticketDO = "trac.ticket.do.TicketDO";
    
    public function foo($args)
    {
        return 'ok';
    }
    
    public function fetch($args)
    {
        $searchRule = $args['searchrule'];
        $limit = $args['limit'];
        $ticketDo = BizSystem::getObject($this->ticketDO);
        $dataSet = $ticketDo->directFetch($searchRule,$limit);
        $resultArray = $dataSet->toArray();
        return $resultArray;
    }
}
?>