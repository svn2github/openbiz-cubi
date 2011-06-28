#!/usr/bin/php -q
<?php

define( "FPDF_FONTPATH", "../font/" );

require( "../xml2pdf.php" );

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
$xml2pdf->SetFont('arial','',12);
$xml2pdf->Open();
$xml2pdf->Parse( $file );

$outfile = str_replace(".xml","",$file).".pdf";
$xml2pdf->Output( $outfile, 'F' );


echo "Done! $outfile is created.\n";


?>