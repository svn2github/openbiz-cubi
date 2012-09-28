<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Presentation Layer - Openbiz Framework - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>

<!-- fancy box - start -->
<script type="text/javascript" src="../../general/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../../general/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!-- fancy box - end -->

<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/presentation-layer.css" rel="stylesheet" type="text/css" />
<script src="js/navigation.js" type="text/javascript" ></script>
<script type="text/javascript" >
$(document).ready(function(){	
	try{
		$(".screenshots a[rel=screenshots]").fancybox({
			'overlayShow'	: true,
			'titlePosition' : 'over',
			'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
									return '<span id="fancybox-title-over">图片 ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
								},
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});	
	}catch(e){};
});
</script>
<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-analytics.php'); ?>
</head>

<body>
<div align="center" id="site-page-wrapper">
	<!-- site header START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-header.php'); ?>
	<!-- site header END -->  

	<!-- site secondary navigation START -->
	<?php require_once(SITE_ROOT_PATH.'/developer/framework/_include/_framework-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="framework-intro-banner-wrapper" >
		<div id="framework-presentation-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/presentationlayer/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>Page and Form upon Data Object</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Wide collection of UI elements<br/>
						to meet all requests in your applications
					</p>									
						<p style="width:100px;padding-top:15px;">
							<a class="blue-button-go" href="#" >Download</a>
						</p>
				</div>
			</div>
		</div>	
	</div>
	
	<div class="content">
		<div class="page-splitter"></div>	
		<div>
			<h2>Presentation Layer Overview</h2>
			<p>
				Openbiz Data Object (DO) plays a data unit, and Openbiz Form plays as corresponding presentation unit. Each Form declares a DO name and mapping between DO Fields to Form Elements. Openbiz View plays as a presentation container of Forms. In web technology, View is same as a web page and Form is a logic block within a page.
			</p>			
		</div>		
		<div class="page-splitter"></div>
		<div class="" style="padding-top: 10px;padding-bottom:10px;">
			<h2>View</h2>
			<p>
				Openbiz View is same as a web page. A View is a container of Forms and Elements. It's layout is defined in its template file. A typical view layout contains header, footer, content area and navigation menus.
			</p>
			<img class="image-border" src="image/presentationlayer/pic-vo-1.png"></img>
			<img class="image-border" src="image/presentationlayer/pic-vo-2.png" style="margin:0px 10px 0px 10px;"></img>
			<img class="" src="image/presentationlayer/pic-vo-ipad.png"></img>
		</div>
		<div class="page-splitter"></div>
		<div class="" style="padding-top: 10px;padding-bottom:10px;">
			<h2>Form</h2>
			<p>
				Openbiz Form presents the data of Data Object to web pages. Usually a Form links with Data Object. It defines how data displayed to users.</p>
			<p>
				In most data-driven applications, data is presented in different form types including List form, Detail form, Edit form, New form and Copy form. A Form can be in a View or in a popup dialog.
			</p>
			<img class="image-border" src="image/presentationlayer/pic-fo-1.png"></img>
			<img class="image-border" src="image/presentationlayer/pic-fo-2.png" style="margin:0px 10px 0px 10px;"></img>
			<img class="image-border" src="image/presentationlayer/pic-fo-3.png"></img>
		</div>
		<div class="page-splitter"></div>
		<h2>Elements</h2>
			<p>
				Openbiz Form Element is a smallest display unit (such as a inputbox) or a group of display units (such as rich text editor). An Element can bind a Field defined in Form's Data Object. Different Elements provide different display and input logic. Beyond standard HTML elements (input, list, checkbox, radio, password,...), Openbiz framework brings you many advanced elements. For example, card scanner, calendar picker, color picker, rich text editor, and so on.
			</p>
		<p>	Developers can set event handler on each Element. These events are same as HTML events. The handlers is either a javascript function call or AJAX call to form method. 
		</p>
		<h2>Openbiz Avdanced Element Samples</h2>
		<table class="present-features screenshots" cellspacing="0" style="padding-top:10px;">
		<tr>
			<td style="width:85px;">
				<a rel="screenshots" href="image/presentationlayer/pic-card.png" title="Openbiz Framework - Card Reader">
				<img src="image/presentationlayer/pic-card-small.png" />
				</a>
			</td>
			<td  style="width:330px;">
				<h4>Card Reader</h4>
				<p>Card reader can read a card number as typed from keyboard. It can be used in use login with card.</p>
			</td>
			<td  style="width:85px;">
				<a rel="screenshots" href="image/presentationlayer/pic-on-off.png" title="Openbiz Framework - OnOff button">
				<img src="image/presentationlayer/pic-on-off-small.png" />
				</a>
			</td>
			<td>
				<h4>On and Off Button</h4>
				<p>It provide easy way for user to change boolean data</p>
			</td>
		</tr>			
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-scanner.png" title="Openbiz Framework - Scanner">
				<img src="image/presentationlayer/pic-scanner-small.png" />
				</a>
			</td>
			<td>
				<h4>Scanner Gun</h4>
				<p>This element can be used to read barcode in applications that manages assets.</p>
			</td>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-sort.png" title="Openbiz Framework - Column sort">
				<img src="image/presentationlayer/pic-sort-small.png" />
				</a>
			</td>
			<td>
				<h4>Column Sorter</h4>
				<p>Column Sorter provides a simple way to change the order of a record in list form</p>
			</td>
		</tr>		
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-color.png" title="Openbiz Framework - Color Picker">
				<img src="image/presentationlayer/pic-color-small.png" />
				</a>
			</td>
			<td>
				<h4>Color Picker</h4>
				<p>Color Picker is based on jQuery color picker plugin.</p>
			</td>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-search.png" title="Openbiz Framework - Auto Suggestion">
				<img src="image/presentationlayer/pic-search-small.png" />
				</a>
			</td>
			<td>
				<h4>Auto Suggestion</h4>
				<p>It is used in many places like search input, contact picker, ...</p>
			</td>
		</tr>
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-list.png" title="Openbiz Framework - Dropdown list with icon">
				<img src="image/presentationlayer/pic-list-small.png" />
				</a>
			</td>
			<td>
				<h4>Dropdown list with icon</h4>
				<p>The dropdown list can display list of values with icons</p>
			</td>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-bar.png" title="Openbiz Framework - Progress bar">
				<img src="image/presentationlayer/pic-bar-small.png" />
				</a>
			</td>
			<td>
				<h4>Progress bar</h4>
				<p>The progress bar is usually to display progress of a task, project...</p>
			</td>
		</tr>
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-text.png" title="Openbiz Framework - Rich Text Editor">
				<img src="image/presentationlayer/pic-text-small.png" />
				</a>
			</td>
			<td>
				<h4>Rich Text Editor</h4>
				<p>A CKEditor based rich text editor enable intuitive text editing</p>
			</td>
		</tr>				
		</table>			
	
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td>
						<p>
							Download Openbiz Framework today to feel the fine touch of stylish UI 
						</p>
					</td>
				</tr>
			</table>
		</div>		
		<!-- 页面底部的购买区域 结束 -->
	</div>	
    <!-- site footer START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-footer.php'); ?>
	<!-- site footer END -->    
</div> 
</body>
</html>