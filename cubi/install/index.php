<?php ob_start(); ?>

<?php
require_once('../bin/app_init.php');
require_once('util.php');

$isInstalled = false;
if(is_file(dirname(dirname(__FILE__)).'/files/install.lock')){
	$isInstalled = true;
}

// response ajax call
if($isInstalled==false){
	if (isset($_REQUEST['action']) && !$isInstalled)
	{
	   if ($_REQUEST['action']=='create_db')
	   {
	      createDB();
	      exit;
	   }
	   if ($_REQUEST['action']=='load_modules')
	   {
	      loadModules();
	      exit;
	   }
	   if ($_REQUEST['action']=='replace_db_cfg')
	   {
	      replaceDbConfig();
	      exit;
	   }
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Openbiz Cubi Installation</title>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link rel="stylesheet" href="install.css" type="text/css" /> 
<link rel="stylesheet" href="../themes/default/css/openbiz.css" type="text/css" /> 
<script language="javascript" src="../js/prototype.js"></script>
</head>
<body>
<div id="body_warp" align="center">
	<!-- header start -->
    <div class="header_warp">
		<div class="header">
			<div class="header_icon">
                <img src="images/header_logo.jpg" />
                <img src="images/header_title.jpg" />
			</div>
            <div class="header_text">                
                Powered by <a href="http://code.google.com/p/openbiz-cubi/">Openbiz Cubi</a>
            </div>
		</div>
	</div>
    <!-- header end -->
    
    

<?php
$stepArr = array("",
				 "System Check",
				 "Database Configuration",
				 "Application Configuration",
				 "Finish"
				 );
$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : '0';

if($isInstalled){
	$step=count($stepArr)-1;
}

if((int)$step>0 && (int)$step<count($stepArr)-1){
	echo "<ul class=\"progress_bar\">";
	for($i=0;$i<count($stepArr);$i++){
		if($stepArr[$i]){
			$text = $i.". ".$stepArr[$i];
			if($i>$step){
				$text = "<a>$text</a>";				
				$style="normal";
			}elseif($i==$step){
				$text = "<a href=\"?step=$i\">$text</a>";
				$style= "current";
			}else{
				$text = "<a href=\"?step=$i\">$text</a>";
				$style= "past";
			}
			echo "<li id=\"step_$i\" class=\"$style\">$text</li>";		
		}
	}
	echo "</ul>";	
}
?>


<?php
include('view/step'.$step.'.tpl.php'); 
?>
</div>
</body>
</html>