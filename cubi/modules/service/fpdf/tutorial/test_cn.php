#!/usr/bin/php -q
<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service.fpdf.tutorial
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */


define( "FPDF_FONTPATH", "../font/" );

require( "../xml2pdf_cn.php" );

if( $argc != 2 )
{
  echo "Usage {$argv[0]} <xml-file>\n";
  exit;
}

$file = $argv[1];
if( !is_file( $file ) )
{
  echo "Error: $file is not a file!\n";
  exit;
}

echo "Start create pdf from $file ...\n";

$xml2pdf = new XML2PDF( FALSE );
//$xml2pdf->AddUniGBFont('ugb'); 
//$xml2pdf->SetFont('ugb','B',12);
$xml2pdf->Open();
$xml2pdf->Parse( $file );

$outfile = str_replace(".xml","",$file).".pdf";
$xml2pdf->Output( $outfile, 'F' );


echo "Done! $outfile is created.\n";


?>