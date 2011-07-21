<?php
/**
 * @package PluginService
 */
 
require_once(MODULE_PATH."/pdf/lib/mpdf50/mpdf.php");
define('_MPDF_PATH', MODULE_PATH."/pdf/lib/mpdf50/");
/**
 * pdfService - 
 * class pdfService is the plug-in service of printing openbiz form to pdf 
 * 
 * @package PluginService
 * @author rocky swen 
 * @copyright Copyright (c) 2003
 * @version $Id: pdfService.php,v 1.1 2006/04/07 07:59:46 rockys Exp $
 * @access public 
 */
class pdfService
{
    protected $pdfObj;
    
    public function __construct() 
    {
        $this->pdfObj = new mPDF('c'); // use default. check http://mpdf1.com/manual/index.php?tid=184
        //$this->pdfObj = new mPDF('zh-CN','A4');   // chinese example
    }
    
    public function getPDFObject()
    {
        return $this->pdfObj;
    }
   
    public function SetConfig($config=null){
    	if($config==null){
    		$config = $this->GetDefaultConfig();
    	}
    	
    	if($config['url']){
    		$this->pdfObj->SetBasePath($config['url']);
    	}else{
    		$this->pdfObj->SetBasePath(SITE_URL);
    	}
    	
    	//set page header
        if($config['page_header_type']){
    		switch($config['page_header_type']){
    			case "Html":
    				switch($config['page_header_html_even_type']){
    					case "CUSTOM":
    						$this->pdfObj->SetHTMLHeader($config['page_header_html_odd'],"O");
    						$this->pdfObj->SetHTMLHeader($config['page_header_html_even'],"E");
    						break;
    					case "SAME":
    						$this->pdfObj->SetHTMLHeader($config['page_header_html_odd'],"O");
    						$this->pdfObj->SetHTMLHeader($config['page_header_html_odd'],"E");
    						break;
    				}    				
    				break;
    			case "Text":
    				$header_odd = array(
					    'L' => array (
					      'content' => $config['page_header_text_left'],
					      'font-size' => $config['page_header_text_left_font'],
					      'font-style' => $config['page_header_text_left_style'],
					      'color'=>"#".$config['page_header_text_left_color']
					    ),
					    'C' => array (
					      'content' => $config['page_header_text_center'],
					      'font-size' => $config['page_header_text_center_font'],
					      'font-style' => $config['page_header_text_center_style'],
					      'color'=>"#".$config['page_header_text_center_color']
					    ),
					    'R' => array (
					      'content' => $config['page_header_text_right'],
					      'font-size' => $config['page_header_text_right_font'],
					      'font-style' => $config['page_header_text_right_style'],
					      'color'=>"#".$config['page_header_text_right_color']
					    ),
					    'line' => $config['page_header_text_line'],    							
    				);    	
    				$header_even["L"] = $header_odd["R"];
    				$header_even["C"] = $header_odd["C"];
    				$header_even["R"] = $header_odd["L"];
    				$header_even["line"] = $header_odd["line"];	
    						
    		    	switch($config['page_header_text_even_type']){
    		    		case "MIRROR":    		    			
    						$this->pdfObj->SetHeader($header_odd,"O");
    						$this->pdfObj->SetHeader($header_even,"E");
    						break;
    					case "SAME":
    						$this->pdfObj->SetHeader($header_odd,"O");
    						$this->pdfObj->SetHeader($header_odd,"E");
    						break;
    				}
    				break;
    		}
    	}   	
    	
    	//set page footer
		if($config['page_footer_type']){
    		switch($config['page_footer_type']){
    			case "Html":
    				switch($config['page_footer_html_even_type']){
    					case "CUSTOM":
    						$this->pdfObj->SetHTMLFooter($config['page_footer_html_odd'],"O");
    						$this->pdfObj->SetHTMLFooter($config['page_footer_html_even'],"E");
    						break;
    					case "SAME":
    						$this->pdfObj->SetHTMLFooter($config['page_footer_html_odd'],"O");
    						$this->pdfObj->SetHTMLFooter($config['page_footer_html_odd'],"E");
    						break;
    				}    				
    				break;
    			case "Text":
    				$footer_odd = array(
					    'L' => array (
					      'content' => $config['page_footer_text_left'],
					      'font-size' => $config['page_footer_text_left_font'],
					      'font-style' => $config['page_footer_text_left_style'],
					      'color'=>"#".$config['page_footer_text_left_color']
					    ),
					    'C' => array (
					      'content' => $config['page_footer_text_center'],
					      'font-size' => $config['page_footer_text_center_font'],
					      'font-style' => $config['page_footer_text_center_style'],
					      'color'=>"#".$config['page_footer_text_center_color']
					    ),
					    'R' => array (
					      'content' => $config['page_footer_text_right'],
					      'font-size' => $config['page_footer_text_right_font'],
					      'font-style' => $config['page_footer_text_right_style'],
					      'color'=>"#".$config['page_footer_text_right_color']
					    ),
					    'line' => $config['page_footer_text_line'],    							
    				);    	
    				$footer_even["L"] = $footer_odd["R"];
    				$footer_even["C"] = $footer_odd["C"];
    				$footer_even["R"] = $footer_odd["L"];
    				$footer_even["line"] = $footer_odd["line"];	
    						
    		    	switch($config['page_footer_text_even_type']){
    		    		case "MIRROR":    		    			
    						$this->pdfObj->SetFooter($footer_odd,"O");
    						$this->pdfObj->SetFooter($footer_even,"E");
    						break;
    					case "SAME":
    						$this->pdfObj->SetFooter($footer_odd,"O");
    						$this->pdfObj->SetFooter($footer_odd,"E");
    						break;
    				}
    				break;
    		}
    	}   	
    	
    	
    	//set protection
    	if($config['password'] || $config['readonly_password']){
    		$protect_array = array();
			if($config['protect_copy']){
				array_push($protect_array,"copy");
			}
    		if($config['protect_print']){
				array_push($protect_array,"print");
			}
    	    if($config['protect_modify']){
				array_push($protect_array,"modify");
			}
    		if($config['protect_annot']){
				array_push($protect_array,"annot-forms");
			}    		
			$this->pdfObj->SetProtection($protect_array,$config['readonly_password'],$config['password']);
    	}
    	
    	//watermark
    	if($config['watermark_type']){
        	if($config['watermark_alpha']>1){
    			$alpha = (float)("0.".$config['watermark_alpha']);
    		}else{
    			$alpha = $config['watermark_alpha'];
    		}    		
    		switch($config['watermark_type']){
    			case "Picture":
    				$this->pdfObj->SetWatermarkImage("file://".APP_HOME.$config['watermark_picture'],$alpha,$config['watermark_size'],$config['watermark_position']);
    				$this->pdfObj->showWatermarkImage=true;
    				break;
    			case "Text":
    				$this->pdfObj->SetWatermarkText($config['watermark_text'],$alpha);
    				$this->pdfObj->showWatermarkText=true;
    				break;
    		}
    	}
    	
    	//meta setting
    	if($config['meta_title']){
    		switch($config['meta_title']){
    			case "DEFAULT":    				
    				break;  
    			case "NONE":
    				$this->pdfObj->SetTitle("");
    				break;  
    			default:
    				$this->pdfObj->SetTitle($config['meta_title']);
    				break;    			
    		}
    	}
    	
        if($config['meta_author']){
    		switch($config['meta_author']){
    			case "DEFAULT_USERNAME":
    				$this->pdfObj->SetAuthor(BizSystem::getUserProfile("username"));
    				break;
    			case "DEFAULT_DISPLAY_NAME":
    				$this->pdfObj->SetAuthor(BizSystem::getUserProfile("profile_display_name"));
    				break;
    			case "DEFAULT":
    				$this->pdfObj->SetAuthor("Openbiz Cubi");
    				break;  
    			case "NONE":
    				$this->pdfObj->SetAuthor("");
    				break;  
    			default:
    				$this->pdfObj->SetAuthor($config['meta_author']);
    				break;				
    			
    		}
    	}    

       if($config['meta_creator']){
    		switch($config['meta_creator']){
    			case "DEFAULT":   
    				$this->pdfObj->SetAuthor("Openbiz PDF Printer"); 				
    				break;  
    			case "NONE":
    				$this->pdfObj->SetCreator("");
    				break;  
    			default:
    				$this->pdfObj->SetCreator($config['meta_creator']);
    				break;    			
    		}
    	}  

       if($config['meta_subject']){
			$this->pdfObj->SetSubject($config['meta_subject']);
        }    

       if($config['meta_keywords']){
			$this->pdfObj->SetKeywords($config['meta_keywords']);
        }         
    	
    }
   
   
    public function WriteHTML($html){
    	$this->pdfObj->WriteHTML($html);		
    }
    
    public function Output($filename=null)
    {
    	if($filename){
			$file = $filename;
			touch($file);
    	}else{
			$tmpfile = APP_FILE_PATH."/tmpfiles";
	    	if(!is_dir($tmpfile)){
	    		mkdir($tmpfile);
	    	}
	
	        $this->CleanFiles($tmpfile, 100);
	        $file_tmp=tempnam($tmpfile,'tmp');
	        $file=$file_tmp.'.pdf';
	        $file=str_replace("\\","/",$file);
	        unlink($file_tmp);    		
    	}
        $this->pdfObj->Output($file);
        $path_parts = pathinfo($file);
        $file_download = APP_FILE_URL."/tmpfiles/".$path_parts['basename'];
       
        return $file_download;

    }
   
    function CleanFiles($dir, $seconds)
    {
        //Delete temporary files
        $t=time();
        $h=opendir($dir);
        while($file=readdir($h))
        {
            if(substr($file,0,3)=='tmp' && substr($file,-4)=='.pdf')
            {
                $path=$dir.'/'.$file;
                if($t-filemtime($path)>$seconds)
                    unlink($path);
            }
        }
        closedir($h);
    }
    
	public function GetDefaultConfig(){    	
    	$system_config = array();
    	$config = array();
    	
    	$systemConfigArr = BizSystem::getObject("pdf.do.PdfDO",1)->directfetch();
    	foreach($systemConfigArr as $item){    		
    		$system_config[$item['name']]=$item['value'];
    	}
    	return $config;
    }    
}
?>