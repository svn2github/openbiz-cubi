<?php 
require_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
class collectService extends  WebsvcService
{
	protected $m_ErrorReportDO = "errorreport.do.ErrorReportDO";
	
	public function collect()
	{
		$args = $this->getInputArgs();
				
		$reportRec = array(
			"name" => $this->genReportCode(),
			"error_data" => $args['data']['error_info'],
			"server_info" => serialize($args['data']['server_info']),
			"php_version" => $args['data']['php_version'],
			"php_extension" => serialize($args['data']['php_extension']),
			"type_id" => 1
		);
		        		
		$recId = BizSystem::getObject($this->m_ErrorReportDO)->insertRecord($reportRec);		
		return $recId;
	}	    
	
	public function genReportCode()
	{
		$code = "ERROR-".date('ym').'-'.rand(111111,999999);
		$orderRec = BizSystem::getObject($this->m_ErrorReportDO)->fetchOne("[name]='$code'");
		if($orderRec){
			return $this->genReportCode();
		}else{
			return $code;
		}
	}
}
?>