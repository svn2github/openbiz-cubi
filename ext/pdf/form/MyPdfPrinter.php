<?php 
class MyPdfPrinter extends EasyForm{

	public $m_Options_Pattern;
	public function readMetadata($xmlArr){
		$this->m_Options_Pattern = array(
			"page_header"=>array("/page_header_.*/si"),
			"page_footer"=>array("/page_footer_.*/si"),
			"protection"=>array("/protect_.*/si","/password/si","/readonly_password/si"),
			"watermark"=>array("/watermark_.*/si"),
			"meta"=>array("/meta_.*/si"),
		);
		return parent::readMetadata($xmlArr);		
	}
	
	public function PrintPDF(){
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        //$this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        $url = $recArr["url"];

	    try
        {
            if($url=='http://' || !preg_match("/^http:\/\//si",$url)){
        		$this->m_ValidateErrors["fld_url"] = "Please fill in a vaild URL to print";
        		throw new ValidationException($this->m_ValidateErrors);
        	}
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }        
        
		if (ini_get('allow_url_fopen')) {
		    $html = file_get_contents($url);
		}
		else 
		{
		    $ch = curl_init($url);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		    curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
		    $html = curl_exec($ch);
		    curl_close($ch);			
		}       
		
		$config = $this->GetConfig();
		$config['url']=$url;
		$urlArr = parse_url($url);

		if($urlArr['path']){
			$download_filename = $urlArr['path'];
		}else{
			$download_filename = $urlArr['host'];
		}
		$svcobj = BizSystem::getService(PDF_SERVICE);
		$svcobj->SetConfig($config);
		$svcobj->WriteHTML($html);
		$file = $svcobj->Output();
		
		$file_download = str_replace(APP_FILE_URL, "", $file);

		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$download_filename.'.pdf"');		
		readfile(APP_FILE_PATH.'/'.$file_download);
	
	}

    public function fetchData()
    {
    	if ($this->m_ActiveRecord != null)
            return $this->m_ActiveRecord;
            
        // load default values if new record value is empty
        $defaultRecArr = array();
        foreach ($this->m_DataPanel as $element)
        {
            if ($element->m_FieldName)
            {
                $defaultRecArr[$element->m_FieldName] = $element->getDefaultValue();
            }
        }
        $this->m_RecordId = '1';
        $this->setActiveRecord($defaultRecArr);
        return $defaultRecArr;
    }

    public function GetConfig(){
    	$recArr = $this->readInputRecord();
    	
    	$system_config = array();
    	$user_config = array();
    	$config = array();
    	
    	$systemConfigArr = BizSystem::getObject("pdf.do.PdfDO",1)->directfetch();
    	foreach($systemConfigArr as $item){    		
    		$system_config[$item['name']]=$item['value'];
    	}

        $userConfigArr = BizSystem::getObject("myaccount.do.PreferenceDO",1)->directfetch("[section]='PDF' and [user_id]='".BizSystem::getUserProfile("Id")."'");
    	foreach($userConfigArr as $item){    		
    		$user_config[$item['name']]=$item['value'];
    	}    	
    	
    	
    	foreach($recArr as $option_section=>$option_type)
    	{
			if($option_section=='url'){
				continue;
			}
    		foreach($this->m_Options_Pattern[$option_section] as $pattern)
    		{
		    	switch($option_type){
		    		case "SYSTEM":
		    	    	foreach($system_config as $key=>$value){
		    				if(preg_match($pattern,$key)){
		    					$config[$key]=$value;
		    				}
		    			}    			
		    			break;
		    		case "MY":
		    	    	foreach($system_config as $key=>$value){
		    				if(preg_match($pattern,$key)){
		    					$config[$key]=$value;
		    				}
		    			}      			
		    			foreach($user_config as $key=>$value){
		    				if(preg_match($pattern,$key)){
		    					$config[$key]=$value;
		    				}
		    			}
		    			break;    			
		    		case "NONE":
		    			foreach($user_config as $key=>$value){
		    				if(preg_match($pattern,$key)){
		    					$config[$key]="";
		    				}
		    			}
		    			break;
		    	}
    		}
    	}
 	
    	return $config;
    }
}
?>