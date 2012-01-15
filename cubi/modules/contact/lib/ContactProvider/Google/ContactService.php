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
		if(!$credential)
		{
			$credential = $this->_credential;
		}else
		{
			$this->_credential = $credential;
		}
		try {	     
	      	$client = Zend_Gdata_ClientLogin::getHttpClient(	
	      			$credential['username'], 
	      			$credential['password'],
	      			'cp');
	      	
	      	return true;
		}
		catch (Exception $e) {
			$message = $e->getMessage();
			if(preg_match("/BadAuthentication/si",$message))
			{
				return false;
			}else{
				throw new Exception($message);
			}
		}
	}	
	
	public function FetchContacts($credential = null)
	{
		if(!$credential)
		{
			$credential = $this->_credential;
		}else
		{
			$this->_credential = $credential;
		}
		
		$user = $credential['username'];
		$pass = $credential['password'];
		
		try {
	      // perform login and set protocol version to 3.0
	      $client = Zend_Gdata_ClientLogin::getHttpClient(
	        $user, $pass, 'cp');
	      $gdata = new Zend_Gdata($client);
	      $gdata->setMajorProtocolVersion(3);
	      
	      // perform query and get result feed
	      $query = new Zend_Gdata_Query(
	        'http://www.google.com/m8/feeds/contacts/default/full');
	      $query->setParam("max-results",10000);
	      $feed = $gdata->getFeed($query);	      
	     
	      // parse feed and extract contact information
	      // into simpler objects
	      $results = array();
	      foreach($feed as $entry){
	        $xml = simplexml_load_string($entry->getXML());	        
	        $obj = $this->DatatoContact($entry, $xml);
	        $results[] = $obj;  
	      }
	    } catch (Exception $e) {
	    	var_dump($e->getMessage());
	      return ;
	    }
		return $results;
	}
	
	protected function DatatoContact($entry, $xml)
	{
		//process email
		foreach ($xml->email as $e) {
          $email = (string) $e['address'];
          break;
        }

		//process phone number        
        foreach ($xml->phoneNumber as $p) {
        	switch((string)$p['rel'])
        	{
        		case 'http://schemas.google.com/g/2005#mobile':
        			$mobile = (string) $p;
        			break;
        		case 'http://schemas.google.com/g/2005#fax':
        			$fax = (string) $p;
        			break;
        		default:
        			$phone = (string) $p;
        			break;
        	}
                 
        }
        
		//process website        
        foreach ($xml->website as $w) {
          $webpage = (string) $w['href'];
          break;
        }		

		//process postaladdress        
		foreach ($xml->postalAddress as $address) {
          $address = (string) $address;
          break;
        }
        
		//process im        
        foreach ($xml->im as $im) {
            switch((string)$im['rel'])
        	{
        		case 'http://schemas.google.com/g/2005#QQ':
        			$qq = (string) $im['address'];
        			break;
        		case 'http://schemas.google.com/g/2005#SKYPE':
        			$skype = (string) $im['address'];
        			break;
        		case 'http://schemas.google.com/g/2005#ICQ':
        			$icq = (string) $im['address'];
        			break;
        		case 'http://schemas.google.com/g/2005#YAHOO':
        			$yahoo = (string) $im['address'];
        			break;
        	}
        }	

		//process photo
		foreach ($xml->link as $link) {
            switch((string)$link['rel'])
        	{
        		case 'http://schemas.google.com/contacts/2008/rel#photo':
        			if( (string)$link['type'] == 'images/*' )
        			{
        				$photo = (string)$link['href'];
        			}
        			break;        		
        	}        
        }	
        
        try{
        	$first_name = (string) $entry->name->givenName;
        	$last_name = (string) $entry->name->familyName;
        }catch (Exception $e){
        	$first_name = (string) $entry->title;
        	$last_name = "";
        }
        
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
		$contactRec['source'] 	= $this->source_name;
		return $contactRec;

	}
	public function getValidateError(){
		$credential_invaild = array(
		        		"username" => "Username or Password is incorrect.",
		        		"password" => "",
		);
		return $credential_invaild;
	}	
}
?>