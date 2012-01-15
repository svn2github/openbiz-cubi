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
		
		if(is_file($this->_data['file']))
		{
			return true;
		}else{
			return false;
		}
	}	
	
	public function FetchContacts($credential = null)
	{
		//$data = new Spreadsheet_Excel_Reader("example.xls");
		$results = array();
		return $results;
	}
	
	protected function RowtoContact($row)
	{		        
		$contactRec = array();
		
		$contactRec['first_name'] 	= $first_name;
		$contactRec['last_name'] 	= $last_name;
		$contactRec['display_name'] = (string) $entry->title;
		$contactRec['company'] 		= (string) $xml->organization->orgName;;
		$contactRec['department'] 	= '';
		$contactRec['position'] 	= (string) $xml->organization->orgTitle;
		$contactRec['photo'] 		= $photo;
		$contactRec['phone'] 		= $phone;
		$contactRec['mobile'] 		= $mobile;
		$contactRec['fax']			= $fax;
		$contactRec['zipcode'] 		= '';
		$contactRec['province'] 	= '';
		$contactRec['city'] 		= '';
		$contactRec['street'] 		= $address;
		$contactRec['country'] 		= '';
		$contactRec['email'] 		= $email;
		$contactRec['webpage'] 		= $webpage;
		$contactRec['qq'] 			= $qq;
		$contactRec['icq']	 		= $icq;
		$contactRec['skype'] 		= $skype;
		$contactRec['yahoo'] 		= $yahoo;
				
		
		$contactRec['selected'] 	= '1';
		$contactRec['foreign_key'] 	= (string) $entry->id;;
		$contactRec['source'] 	= 'Excel2007 - '.$this->filename;
		return $contactRec;

	}
	
	public function getValidateError(){
		$credential_invaild = array(
		        		"file" => "Please upload a excel 2003 format file",
		);
		return $credential_invaild;
	}
}
?>