<?php 
class BarcodeGenForm extends EasyForm
{
	public function fetchDataSet()
	{
		$result = array();
		for($i=0;$i<$this->m_Range;$i++)
		{			
			$code = $this->genCode();
			$record = array(
				"Id"=>$code,
				"barcode"=>$code
			);
			$result[] = $record;
			
		}
		return $result;
	}
	
	public function genCode()
	{
		$code = rand(1000000000000,9999999999999);
		if($this->checkCodeExists($code))
		{
			return $this->genCode();
		}
		else
		{
			return $code;
		}
	}
	
	public function checkCodeExists($code)
	{
		$do = BizSystem::getObject("asset.do.AssetDO");
		$rec = $do->fetchOne("[barcode]='$code'");
		if($rec)
		{
			return true;
		}
		else{
			return false;
		}
	}
}
?>