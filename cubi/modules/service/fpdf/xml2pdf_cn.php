<?php
/*
 *  XML class for FPDF
 *  Copyright (c) 2002, Patrick Prasse (patrick.prasse@gmx.net)
 *
 *  Parts of this code is (c) 2001, Edward Rudd and
 *  comes from his "XML Template to PDF Class v1.1"
 *  Credits Edward
 *
 *  Part of the code added and/or modified by Klemen Vodopivec 
 *  <klemen@vodopivec.org>. Changes:
 *  - new meta tag addfont for adding external fonts (useful for
 *    non-ascii languages)
 *  - also read string as valid XML input (useful for template
 *    engines like Smarty)
 *  - img tag for including images in PDF (support for jpg and png)
 *
 *  This library is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU Library General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU Library General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

require_once "xml_parser.php";
require_once "chinese-unicode.php";


class XML2PDF extends PDF_Unicode
{
  var $parser;         /* XML Parsed data (xml_parse object) */
  var $debug;          /* Debug ? */

  var $abort_error;   /* Abort execution because of a severe error ? */

  var $open_tags;

  var $fontstack; /* Font stack */
  var $colorstack; /* Color set history */

  var $add_fonts;

  var $indent;

  var $tablestack;
  var $trstack;
  var $tdstack;

  var $header;
  var $footer;

  var $links;

  var $filename; //XML Filename

  //Class initializer.  the XML filename and optionally enable debug (set to 1)
  //Also sends PDF content-type header;
  function XML2PDF( $debug=FALSE )
  {
    // Initialization
    $this->DebugPrint( "initializing..." );
    parent::PDF_Unicode();

    $this->debug = $debug;
    $this->abort_error = FALSE;

    $this->open_tags = array( "page" => FALSE );

    $this->fontstack = array();
    $this->colorstack = array( );

    $this->tablestack = array( );
    $this->trstack = array( );
    $this->tdstack = array( );

    $this->links = array( );
    
    $this->add_fonts = array( );
 
    $this->indent = array( "ih1" => 0, "ih2" => 5, "ih3" => 10, "ih4" => 15, "ih5" => 20, "ih6" => 25, "current" => 0 );
    
    $this->headingFont = array( "H1" => 36, "H2" => 24, "H3" => 18, "H4" => 16, "H5" => 14, "H6" => 12 );
    $this->headingSpace = array( "H1" => 5, "H2" => 4, "H3" => 3, "H4" => 2, "H5" => 1, "H6" => 0 );
    
    $this->AddUniGBFont('uGB'); 
    $this->SetFont('uGB','',12); 
  }


  //Parse through the XML once document and generate PDF (can be called multiple times)
  //Returns XML Error messages if bad XML. otherwise false.
  function Parse( $filename ) 
  {
    $this->header = array();
    $this->footer = array();
    $this->filename = $filename;
    $error = XMLParseFile ($this->parser, $this->filename, 0, "", 1, "UTF-8");  //"ISO-8859-1");
    if (strcmp ($error, "")) 
    {
      print "Parser Error: $error\n";
      return $error;
    } 
    else 
    {
      $this->WalkXML ("0"); //&$this->parser->structure, &$this->parser->positions);
      return false;
    }
  }

  //Parse through the XML once string and generate PDF (can be called multiple times)
  //Returns XML Error messages if bad XML string. otherwise false.
  function ParseString( $str ) 
  {
    $this->header = array();
    $this->footer = array();
    $error = XMLParseString ($this->parser, $str, 0, "", 1,"ISO-8859-1");
    if (strcmp ($error, "")) 
    {
      print "Parser Error: $error\n";
      return $error;
    } 
    else 
    {
      $this->WalkXML ("0"); //&$this->parser->structure, &$this->parser->positions);
      return false;
    }
  }



/*******************************************************************************
 * END OF PUBLIC FUNCTIONS                             *
 *******************************************************************************/


  function WalkXML ($path) 
  {
    if (is_array($this->parser->structure[$path])) 
    {
      //Beginning Tag
      $this->startElement($path);

      for ($element = 0; $element < $this->parser->structure[$path]["Elements"];$element++)
    $this->WalkXML($path.",$element");

      //End Tag
      $this->endElement($path);
    } 
    else 
    {
      //Content
      //Find parent path
      $parentpath = substr($path,0,strrpos($path,","));
      $this->DebugPrint("PATH=".$path."-".strrpos($path,",")."-".$parentpath);
     
      /* preliminary whitespace replace */
      $data = $this->parser->structure[$path];
      $data = preg_replace( "/\s*\n\s*/", " ", $data );
      $data = preg_replace( "/(\n|\r)/", " ", $data );
      $data = preg_replace( "/^\s+/", "", $data );
      $data = preg_replace( "/(\ +)/"," ", $data );
      $data = preg_replace( "/^\s/", "", $data );

      $data = preg_replace( "/&nbsp;/", " ", $data );

      if (strlen($data)>0) 
      {
    $this->characterData($this->parser->structure[$parentpath]["Tag"],
                 $this->parser->structure[$parentpath]["Attributes"],
                 $data, $path, $parentpath );
      }
    }
  }


  //handles the "beginning" of a tag  and sets parameters appropriatly
  function startElement($path) 
  {
    $attribs = &$this->parser->structure[$path]["Attributes"];
    $tag = $this->parser->structure[$path]["Tag"];
    $this->DebugPrint( "Start: $tag\n" );
    switch ($tag) 
    {
      case 'PDF':
    $this->DebugPrint("Begining of file");
    break;
  
      case 'PAGE':
    if( $this->open_tags["page"] )
      return $this->Error( "Page already open, ignoring.", FALSE );

    $this->open_tags["page"] = TRUE;

    $this->AddPage( ((empty($attribs["ORIENTATION"]))?("P"):($attribs["ORIENTATION"])) );
    if( !empty($attribs["TOPMARGIN"]) ) 
    {
      $this->SetTopMargin( $attribs["TOPMARGIN"] );
    }
    if( !empty($attribs["LEFTMARGIN"]) ) 
    {
      $this->SetTopMargin( $attribs["LEFTMARGIN"] );
    }
    if( !empty($attribs["RIGHTMARGIN"]) ) 
    {
      $this->SetTopMargin( $attribs["RIGHTMARGIN"] );
    }
    break;

      case 'FOOTER':
    $this->footer["path"] = $path;
    $this->footer["y"] = ((empty($attribs["Y"]))?(-20):((int)$attribs["Y"]));
    break;

      case 'HEADER':
    $this->header["path"] = $path;
    $this->header["y"] = ((empty($attribs["Y"]))?(5):((int)$attribs["Y"]));
    break;

      case 'META':
    if( ! $this->open_tags["page"] )
      return $this->Error( "Page not open, ignoring.", FALSE );

    $name = $attribs["NAME"];
    if( empty( $name ) )
      return $this->Error( "META tag without name, ignoring.", FALSE );
    $value = (empty($attribs["VALUE"])?"":$attribs["VALUE"]);
    switch( strtoupper( $name ) )
    {
      case 'AUTHOR':
        $this->SetAuthor( $value );
        break;
      case 'CREATOR':
        $this->SetCreator( $value );
        break;
      case 'SUBJECT':
        $this->SetSubject( $value );
        break;
      case 'TITLE':
        $this->SetTitle( $value );
        break;
      case 'KEYWORDS':
        $this->SetKeywords( $value );
        break;

      case 'COMPRESSION':
        $this->SetCompression( ($value!='0'?TRUE:FALSE) );
        break;

      case 'BASEFONT':
        if( empty( $attribs["VALUE"] ) )
          return $this->Error( "META BASEFONT with empty value, ignoring.", FALSE );
        $font = split( ",", $attribs["VALUE"] );
        if( isset( $font[0] ) && !empty( $font[0] ) )
          $this->fontstack[0]["family"] = $font[0];
        if( isset( $font[1] ) )
          $this->fontstack[0]["style"] = $font[1];
        if( isset( $font[2] ) && !empty( $font[2] ) )
          $this->fontstack[0]["size"] = (int)$font[2];
        break;

      case 'INDENT':
        if( empty( $attribs["VALUE"] ) )
          return $this->Error( "META INDENT with empty value, ignoring.", FALSE );
        $indent = split( ",", $attribs["VALUE"] );
        foreach( $indent as $inr => $val )
        {
          $this->indent["ih".($inr+1)] = (int) $val;
        }
        break;
      
      case 'ADDFONT':
        if( empty( $attribs["VALUE"] ) )
          return $this->Error( "META ADDFONT with empty value, ignoring.", FALSE );
        
        $font = split( ",", $attribs["VALUE"] );
        if( !isset( $font[1] ) )
          $font[1] = '';
        if( !isset( $font[2] ) )
          $font[2] = 10;

        if( isset( $font[3] ) )
            $this->AddFont($font[0], $font[1], $font[3]);
        else
            $this->AddFont($font[0], $font[1]);
        $this->SetFont($font[0], $font[1], $font[2]);
        break;

      default:
        return $this->Error( "Unknown META name=\"$name\", ignoring.", FALSE );
    }
    break;

      case 'FONT':
    $this->_setfont( (empty($attribs["FAMILY"])?"":$attribs["FAMILY"]),
             (empty($attribs["STYLE"])?"":$attribs["STYLE"]),
             (! isset($attribs["SIZE"])?0:$attribs["SIZE"]) );
    break;

      case 'I':
      case 'ITALIC':
    $this->_setfont( "", "I", 0 );
    break;
      case 'B':
      case 'BOLD':
    $this->_setfont( "", "B", 0 );
    break;
      case 'U':
      case 'UNDERLINE':
    $this->_setfont( "", "U", 0 );
    break;

      case 'H1':
      case 'H2':
      case 'H3':
      case 'H4':
      case 'H5':
      case 'H6':
        $this->_setfont( "", "B", $this->headingFont[$tag] );
        $this->Ln($this->headingSpace[$tag]);
        break;

      case 'INDENT':
    if( !isset( $attribs["INDENT"] ) || $attribs["INDENT"] == 0 )
      return $this->Error( "Tag INDENT without attribute INDENT, ignoring.", FALSE );
    $this->indent["current"] = (float)$attribs["INDENT"];
    $this->SetX( $this->GetX() + $this->indent["current"] );
    break;

      case 'COLOR':
    $this->_setcolor( (empty($attribs["DRAWCOLOR"])?"":$attribs["DRAWCOLOR"]),
              (empty($attribs["FILLCOLOR"])?"":$attribs["FILLCOLOR"]),
              (empty($attribs["TEXTCOLOR"])?"":$attribs["TEXTCOLOR"]) );
    break;

      case 'TABLE':    
    break;

      case 'TR':
    if( !isset($attribs["HEIGHT"]) )
    {
      $this->Error( "TR: attribute HEIGHT not set, assuming 5.", FALSE );
      $attribs["HEIGHT"] = 5;
    }
    array_push( $this->trstack, array( "height" => $attribs["HEIGHT"] ) );
    break;
 
      case 'TD':
    if( !isset($attribs["WIDTH"]) )
    {
      $this->Error( "TD: attribute WIDTH not set, assuming 5.", FALSE );
      $attribs["WIDTH"] = 5;
    }
    array_push( $this->tdstack, array( "width" => (int)$attribs["WIDTH"],
                       "border" => (empty($attribs["BORDER"])?0:$attribs["BORDER"]),
                       "align" => (empty($attribs["ALIGN"])?"L":$attribs["ALIGN"]),
                       "filled" => (empty($attribs["FILLED"])?0:(int)$attribs["FILLED"]),
           ) );
    break;

      case 'BR':
    $this->Ln();
    if( $this->indent["current"] != 0 )
      $this->SetX( $this->GetX() + $this->indent["current"] );

    break;
    
      case 'IMG':
    if( !isset($attribs["SRC"]) )
      $this->Error( "IMG: attribute SRC not set", TRUE );
    if( !isset($attribs["WIDTH"]) || !is_numeric($attribs["WIDTH"]) )
    {
      $this->Error( "IMG: attribute WIDTH not set, assuming 10", FALSE );
      $attribs["WIDTH"] = 10;
    }
    if( !isset($attribs["HEIGHT"]) || !is_numeric($attribs["HEIGHT"]) )
      $this->Error( "IMG: attribute HEIGHT not set, auto calculating", FALSE );

    $curr_x = $this->GetX();
    $curr_y = $this->GetY();

    if( !isset($attribs["HEIGHT"]) || !is_numeric($attribs["HEIGHT"]) )
      $this->Image($attribs["SRC"], $curr_x, $curr_y, $attribs["WIDTH"]);
    else
      $this->Image($attribs["SRC"], $curr_x, $curr_y, $attribs["WIDTH"], $attribs["HEIGHT"]);

    break;

      case 'A':
    /* a has 2 meanings: with attribute name it is a target for a link
     *           with attribute href it is a reference source */
    $name = (empty($attribs["NAME"])?"":trim( strtolower( $attribs["NAME"] ) ));
    $href = (empty($attribs["HREF"])?"":trim( strtolower( $attribs["HREF"] ) ));
    if( !empty( $name ) )
    {
      if( !isset( $this->links[$name] ) )
        $this->links[$name] = $this->AddLink( );

      $this->SetLink( $this->links[$name], -1, -1 );
    }

    if( !empty( $href ) )
    {
      if( substr($href,0,1) == "#" )  /* relative link */
      {
        if( !isset( $this->links[$href] ) )
          $this->links[$href] = $this->AddLink( );

        $this->links[0] = $this->links[$name];
      }
      else
      {
        $this->links[0] = $href; /* Absolute link (URL or something extern) */
      }
    }
    break;


      default:
    return $this->Error( "Unknown tag: $tag, ignoring.", FALSE );
    break;
    } /* switch */

  }

  //handles the "end" of a tag and (un)sets parameters appropriatly
  function endElement($path) 
  {
    $attribs = &$this->parser->structure[$path]["Attributes"];
    $tag = $this->parser->structure[$path]["Tag"];
    $this->DebugPrint( "End: $tag\n" );
    switch ($tag) 
    {
      case 'PDF':
    $this->DebugPrint("End of document");
    // $this->Close( );
    break;
 
      case 'PAGE':  
    // Nothing to do.
    break;
/*
      case 'IH1':
      case 'IH2':
      case 'IH3':
      case 'IH4':
      case 'IH5':
    $this->indent["current"] = 0;
*/
      case 'I':
      case 'B':
      case 'U':
      case 'ITALIC':
      case 'BOLD':
      case 'UNDERLINE':
      case 'FONT':
    $this->_restorefont( );
    break;
    
      case 'H1':
      case 'H2':
      case 'H3':
      case 'H4':
      case 'H5':
    $this->Ln();
    $this->Ln($this->headingSpace[$tag]);
    $this->_restorefont( );
    break;
    
      case 'INDENT':
    $this->indent["current"] = 0;
    break;

      case 'COLOR':
    $this->_restorecolor( );
    break;

      case 'TABLE':
    array_pop( $this->tablestack );
    break;

      case 'TR':
    array_pop( $this->trstack );
    $this->Ln();
    break;

      case 'TD':
    array_pop( $this->tdstack );
    break;


      default:
    break;
    }

  } //end Element
    

  function characterData( $tag, $attribs, $data, $path, $parentpath )
  {
    $this->DebugPrint( "CharData tag=$tag data=\"$data\"" );

    if( count( $this->tdstack ) > 0 )
    {
    $tr = $this->trstack[count($this->trstack)-1];
    $td = $this->tdstack[count($this->tdstack)-1];
    $this->Cell( $td["width"], $tr["height"], $data, $td["border"], 0, $td["align"], $td["filled"] );
    return;
    }

    if( $tag == "A" )
      $this->Write( 5, $data, $this->links[0] );
    else
      $this->Write( 5, $data );

  }


  function Error( $text, $abort=FALSE )
  {
    if( ! $this->abort_error )
      $this->abort_error = $abort;

    print "Error: $text\n";
    return 0;
  }


  function Header( )
  {
    if( isset( $this->header["path"] ) && isset( $this->header["y"] ) )
    {
      $this->DebugPrint( "Walking header path \"{$this->header["path"]}\"..." );
      $this->SetY( $this->header["y"] );
      $this->WalkXML( $this->header["path"] );
      $this->DebugPrint( "Finished walking header path" );
    }
  }

  function Footer( )
  {
    if( isset( $this->footer["path"] ) && isset( $this->footer["y"] ) )
    {
      $this->DebugPrint( "Walking footer path \"{$this->footer["path"]}\"..." );
      $this->SetY( $this->footer["y"] );
      $this->WalkXML( $this->footer["path"] );
      $this->DebugPrint( "Finished walking footer path" );
    }
  }


  //DebugPrint wrapper..Only prints when debug==1
  function DebugPrint($message) 
  {
    if (!$this->debug)
      return;
//    print "<font size=2>".htmlentities($message)."</font><br/>\n";
    print "$message\n";
  }

  
  function _setfont( $family=-1, $style=-1, $size=-1 )
  {
    $i = count( $this->fontstack );
    if( $i != 0 )
    {
      if( $family == -1 )
    $family = $this->fontstack[$i-1]["family"];
      if( $style == -1 )
    $style = $this->fontstack[$i-1]["style"];
      if( $size <= 0  )
    $size = $this->fontstack[$i-1]["size"];
    }
    
    $this->fontstack[$i] = array( "family" => $family, "style" => $style, "size" => $size );
    $this->SetFont( $family, $style, $size );
  }

  function _restorefont( )
  {
    $i = count( $this->fontstack ) - 1;
    if( $i < 0 )  return;
    $font = $this->fontstack[$i-1];
    unset( $this->fontstack[$i] );
    $this->SetFont( $font["family"], $font["style"], $font["size"] );
  }


  function _color( $color )
  {
    if( ! is_string( $color ) )
      return $color;
 
    if( strlen( $color ) == 3 )
    {
      return array( "r" => (int)substr( $color, 1, 2 ), "g" => -1, "b" => -1 );
    }
    else if( strlen( $color ) == 7 )
    {
      return array( "r" => (int)substr( $color, 1, 2 ), 
            "g" => (int)substr( $color, 3, 2 ), 
            "b" => (int)substr( $color, 5, 2 ) );
    }
    else
    {
      $this->Error( "Unknown colorspec \"$color\", ignoring." );
      return -1;
    }
  }

  function _setcolor( $drawcolor, $fillcolor, $textcolor )
  {
    $i = count( $this->colorstack );
    if( $i != 0 )
    {
      if( empty( $drawcolor ) )
    $drawcolor = $this->colorstack[$i-1]["drawcolor"];
      if( empty( $fillcolor ) )
    $fillcolor = $this->colorstack[$i-1]["fillcolor"];
      if( empty( $textcolor ) )
    $textcolor = $this->colorstack[$i-1]["textcolor"];
    }
    
    $drawcolor = $this->_color( $drawcolor );
    $fillcolor = $this->_color( $fillcolor ); 
    $textcolor = $this->_color( $textcolor );
    if( !is_array( $drawcolor ) || !is_array( $fillcolor ) || !is_array( $textcolor ) )
    { /* error processing colors -> use old colors */
      $this->colorstack[$i] = $this->colorstack[$i - 1];
      return;
    }
    else
    {
      $this->colorstack[$i] = array( "drawcolor" => $this->_color( $drawcolor ), 
                     "fillcolor" => $this->_color( $fillcolor ), 
                     "textcolor" => $this->_color( $textcolor )  );
    }
   
     $this->SetDrawColor( $drawcolor );
     $this->SetFillColor( $fillcolor );
     $this->SetTextColor( $textcolor );
  }

  function _restorecolor( )
  {
    $i = count( $this->colorstack ) - 1; 
    if( $i < 0 )  return;
    $color = $this->colorstack[$i-1];
    unset( $this->colorstack[$i] );
    $this->SetDrawColor( $color["drawcolor"] );
    $this->SetFillColor( $color["fillcolor"] );
    $this->SetTextColor( $color["textcolor"] );
  }




}

?>