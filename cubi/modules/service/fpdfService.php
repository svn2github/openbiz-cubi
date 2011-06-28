<?php
/**
 * @package PluginService
 */
 
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
class fpdfService
{
    protected $lang = "";
    
    public function __construct($lang="") 
    {
        $this->lang = $lang;
    }
   
   /**
    * pdfService::xml2pdf() - use fpdf xml2pdf class to convert xml to pdf
    * 
    * @return mixed 
    */
    public function xml2pdf($xml, $pdfName, $dest)
    {
        define( "FPDF_FONTPATH", "fpdf/font/" );
        if ($lang == "CN") {
            require_once("fpdf/xml2pdf_cn.php");
        }
        else {
            require_once("fpdf/xml2pdf.php");
        }
        
        $xml2pdf = new XML2PDF( FALSE );
        $xml2pdf->Open();
        $xml2pdf->ParseString( $xml );

        /* output destination I, D, F, S
            I: standard output
            D: download file
            F: save to local file
            S: string
        */
        return $xml2pdf->Output( $pdfName, $dest );
    }
}
?>