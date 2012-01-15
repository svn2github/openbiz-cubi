<?php 
/*
 * Google Contact API Reference
 * http://code.google.com/googleapps/domain/shared_contacts/gdata_shared_contacts_api_reference.html
 */
class ContactService{
	protected $_credential = array();
	public $source_name = "Google";
	
	public function __construct($credential = null)
	{
		$this->_credential = $credential;
		return ;
	}
	
	
	public function ValidateCredential($credential = null){
		return true;
	}	
	
	public function FetchContacts($credential = null)
	{
		
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
}
?>