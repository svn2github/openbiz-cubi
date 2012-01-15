<?php 
/*
 * Google Contact API Reference
 * http://code.google.com/googleapps/domain/shared_contacts/gdata_shared_contacts_api_reference.html
 */
require_once dirname(__FILE__).'/excel_reader2.php';

class ContactService{
	protected $_data = array();
	public $source_name = "Excel2003";
	
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
		if(is_file(APP_HOME.$this->_data['file']))
		{
			return true;
		}else{
			return false;
		}
	}	
	
	public function FetchContacts($credential = null)
	{
		$filename = APP_HOME.$this->_data['file'];
		$data = new Spreadsheet_Excel_Reader($filename);
		$results = array();		
		$row_num = $data->rowcount();		
		if($row_num>=3){
			for($i=3;$i<=$row_num;$i++){
				$results[] = $this->RowtoContact($data,$i);
			}
		}
		unlink($filename);
		return $results;
	}
	
	protected function RowtoContact(Spreadsheet_Excel_Reader $data,$row)
	{		        
		$contactRec = array();		
		$contactRec['first_name'] 	= $data->value($row, 1);
		$contactRec['last_name'] 	= $data->value($row, 2);				
		$contactRec['display_name'] = $data->value($row, 3);
		$contactRec['company'] 		= $data->value($row, 4);
		$contactRec['department'] 	= $data->value($row, 5);
		$contactRec['position'] 	= $data->value($row, 6);				
		$contactRec['email'] 		= $data->value($row, 7);
		$contactRec['phone'] 		= $data->value($row, 8);
		$contactRec['mobile'] 		= $data->value($row, 9);
		$contactRec['fax']			= $data->value($row, 10);
		$contactRec['zipcode'] 		= $data->value($row, 11);
		$contactRec['province'] 	= $data->value($row, 12);
		$contactRec['city'] 		= $data->value($row, 13);
		$contactRec['street'] 		= $data->value($row, 14);
		$contactRec['country'] 		= $data->value($row, 15);		
		$contactRec['webpage'] 		= $data->value($row, 16);
		$contactRec['qq'] 			= $data->value($row, 17);
		$contactRec['icq']	 		= $data->value($row, 18);
		$contactRec['skype'] 		= $data->value($row, 19);
		$contactRec['yahoo'] 		= $data->value($row, 20);
		$contactRec['photo'] 		= "";		
		$contactRec['selected'] 	= '1';
		$contactRec['foreign_key'] 	= $this->getRawFileName().'-'.$row;
		$contactRec['source'] 	= 'Excel2003 - '.$this->getRawFileName();		
		return $contactRec;

	}
	
	protected function getRawFileName()
	{
		$filename = basename($this->_data['file']);
		preg_match("/[0-9]*\-(.*)/si",$filename,$match);		
		return $match[1];
	}
	
	public function getValidateError(){
		$credential_invaild = array(
		        		"file" => "Please upload a excel 2003 format file",
		);
		return $credential_invaild;
	}
}
?>