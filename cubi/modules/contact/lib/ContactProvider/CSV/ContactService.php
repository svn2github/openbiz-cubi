<?php 
/*
 * Google Contact API Reference
 * http://code.google.com/googleapps/domain/shared_contacts/gdata_shared_contacts_api_reference.html
 */

class ContactService{
	protected $_data = array();
	public $source_name = "CSV";
	
	public function __construct($credential = null)
	{		
		$this->_data = $credential;
		return ;
	}
	
	
	public function ValidateCredential($credential = null){
		if(!$credential)
		{
			$credential = $this->_data;
		}else
		{
			$this->_data = $credential;
		}
		
		if(is_file(APP_HOME.$this->_data['file_csv']))
		{
			return true;
		}else{
			return false;
		}
	}	
	
	public function FetchContacts($credential = null)
	{
		$filename = APP_HOME.$this->_data['file_csv'];
		$data = file_get_contents($filename); 
		
		$rows = explode("\n",$data);		
		$results = array();		
		$row_num = count($rows);		
		if($row_num>=2){
			for($i=2;$i<=$row_num;$i++){
				$row = explode(",", $rows[$i]);
				if(count($row)>3){
					$results[] = $this->RowtoContact($row,$i);
				}
			}
		}
		unlink($filename);
		return $results;
	}
	
	protected function RowtoContact($row,$id)
	{		        		
		$contactRec = array();		
		$contactRec['first_name'] 	= $this->getValue($row[0]);
		$contactRec['last_name'] 	= $this->getValue($row[1]);			
		$contactRec['display_name'] = $this->getValue($row[2]);
		$contactRec['company'] 		= $this->getValue($row[3]);
		$contactRec['department'] 	= $this->getValue($row[4]);
		$contactRec['position'] 	= $this->getValue($row[5]);			
		$contactRec['email'] 		= $this->getValue($row[6]);
		$contactRec['phone'] 		= $this->getValue($row[7]);
		$contactRec['mobile'] 		= $this->getValue($row[8]);
		$contactRec['fax']			= $this->getValue($row[9]);
		$contactRec['zipcode'] 		= $this->getValue($row[10]);
		$contactRec['province'] 	= $this->getValue($row[11]);
		$contactRec['city'] 		= $this->getValue($row[12]);
		$contactRec['street'] 		= $this->getValue($row[13]);
		$contactRec['country'] 		= $this->getValue($row[14]);	
		$contactRec['webpage'] 		= $this->getValue($row[15]);
		$contactRec['qq'] 			= $this->getValue($row[16]);
		$contactRec['icq']	 		= $this->getValue($row[17]);
		$contactRec['skype'] 		= $this->getValue($row[18]);
		$contactRec['yahoo'] 		= $this->getValue($row[19]);
		$contactRec['photo'] 		= "";		
		$contactRec['selected'] 	= '1';
		$contactRec['foreign_key'] 	= $this->getRawFileName().'-'.$id;
		$contactRec['source'] 	= 'CSV - '.$this->getRawFileName();		
		return $contactRec;

	}
	protected function getValue($field)
	{
		preg_match('/\"(.*?)\"/si',$field,$match);
		return $match[1];
	}
	protected function getRawFileName()
	{
		$filename = basename($this->_data['file']);
		preg_match("/[0-9]*\-(.*)/si",$filename,$match);		
		return $match[1];
	}
	
	public function getValidateError(){
		$credential_invaild = array(
		        		"file" => "Please upload a CSV (UTF-8) format file",
		);
		return $credential_invaild;
	}
}
?>