<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quality UI － Openbiz Cubi Platform － <?php echo SITE_NAME;?></title>
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
<link href="style/screenshot.css" rel="stylesheet" type="text/css" />
<script src="js/navigation.js" type="text/javascript" ></script>

<script type="text/javascript" >
$(document).ready(function(){	
	try{
		$(".screenshots a[rel=screenshots-basic]").fancybox({
			'overlayShow'	: true,
			'titlePosition' : 'over',
			'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
									return '<span id="fancybox-title-over">图片 ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
								},
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});	
		$(".screenshots a[rel=screenshots-advanced]").fancybox({
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
	<?php require_once(SITE_ROOT_PATH.'/developer/cubi/_include/_cubi-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="developer-banner-wrapper" >
		<div id="cubi-screenshot-banner-wrapper" >
			<div id="cubi-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto;"><a href="cubi/"><img src="image/screenshot/banner-title.png" title="Openbiz Cubi Platform"/></a></h1>
					<div style="padding-left:5px;">
					<h2 >Impressive professional design</h2>
					<p>Openbiz Cubi tunes look and feel on each detail <br/>You have built-in high quality user interface</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >Download</a>
					</p>
					</div>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<h2>Basic UI Styles</h2>
		<p>Let's have a quick look at the look and feel of a typical Openbiz Cubi application.</p>
		<table class="screenshots">
			<tr>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-1-large.png" title="Openbiz Cubi - application administration page">
					<img src="image/screenshot/screenshot-basic-1.png" />
					<span>Administration page</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-2-large.png" title="Openbiz Cubi - data listing view">
					<img src="image/screenshot/screenshot-basic-2.png" />
					<span>Data listing page</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-3-large.png" title="Openbiz Cubi - data detail view">
					<img src="image/screenshot/screenshot-basic-3.png" />
					<span>Data detail page</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-4-large.png" title="Openbiz Cubi - data editing view">
					<img src="image/screenshot/screenshot-basic-4.png" />
					<span>Data editing page</span>
					</a>
				</td>
			</tr>
		</table>
		<p>These pages are interfaces that end users work on everyday. The same look and feel across all pages can keep your applications with consistant user experience. Users will work more efficiently without questions and confusions.</p>
		
		<div class="page-splitter"></div>
		<h2>Advanced UI Styles</h2>
		<p>Basides consistant basic page styles, Openbiz Cubi supports a lot of advanced UI elements at platform level. <br/>
		These professional widgets will be the highlights of your applications.</p>
		<table class="screenshots">
			<tr>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-1-large.png" title="Openbiz Cubi - map">
					<img src="image/screenshot/screenshot-advanced-1-small.png" />
					<span>Map</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-2-large.png" title="Openbiz Cubi - chart">
					<img src="image/screenshot/screenshot-advanced-2-small.png" />
					<span>Chart</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-3-large.png" title="Openbiz Cubi - calendar">
					<img src="image/screenshot/screenshot-advanced-3-small.png" />
					<span>Calendar</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-4-large.png" title="Openbiz Cubi - gantt chart">
					<img src="image/screenshot/screenshot-advanced-4-small.png" />
					<span>Gantt chart</span>
					</a>
				</td>
			</tr>
			
			<tr>	
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-5-large.png" title="Openbiz Cubi - wizard">
					<img src="image/screenshot/screenshot-advanced-5-small.png" />
					<span>Multi-step wizard</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-6-large.png" title="Openbiz Cubi - card reader">
					<img src="image/screenshot/screenshot-advanced-6-small.png" />
					<span>Card reader</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-7-large.png" title="Openbiz Cubi - barcode scanner">
					<img src="image/screenshot/screenshot-advanced-7-small.png" />
					<span>Barcode scanner</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-8-large.png" title="Openbiz Cubi - data sharing">
					<img src="image/screenshot/screenshot-advanced-8-small.png" />
					<span>Data sharing</span>
					</a>
				</td>
			</tr>			
			
			<tr>	
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-9-large.png" title="Openbiz Cubi - email">
					<img src="image/screenshot/screenshot-advanced-9-small.png" />
					<span>Email integration</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-10-large.png" title="Openbiz Cubi - social network">
					<img src="image/screenshot/screenshot-advanced-10-small.png" />
					<span>Social accounts</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-11-large.png" title="Openbiz Cubi - user login">
					<img src="image/screenshot/screenshot-advanced-11-small.png" />
					<span>User login</span>
					</a>
				</td>
				<td>
				</td>
			</tr>			
						
		</table>

		<div class="page-splitter"></div>
		<h2>Fine-Tuned Details</h2>
		<p>Openbiz Cubi has strength on providing superb user experience. Openbiz designers and developers have spent long hours on adjusting pixels to make the perfect display effects. The efforts can help you win the trust from your clients. 
		</p>
		<table class="screenshots-detail">
			<tr>
				<td>
					<img src="image/screenshot/screenshot-detail-1.png" />
					<span>Collapse & expend button</span>
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-2.png" />
					<span>Sorting on grid</span>
				</td>
				<td>					
					<img src="image/screenshot/screenshot-detail-3.png" />
					<span>Auto suggestion</span>				
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-4.png" />
					<span>Paging</span>
				</td>
			</tr>
			
			<tr>
				<td>
					<img src="image/screenshot/screenshot-detail-5.png" />
					<span>Form icon</span>
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-6.png" />
					<span>Mouse click, hover effects</span>
				</td>
				<td>					
					<img src="image/screenshot/screenshot-detail-7.png" />
					<span>Image dropdown list</span>				
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-8.png" />
					<span>Context menu</span>
				</td>
			</tr>
			
			<tr>
				<td>
					<img src="image/screenshot/screenshot-detail-9.png" />
					<span>Text input effects</span>
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-10.png" />
					<span>Notification text</span>
				</td>
				<td>					
					<img src="image/screenshot/screenshot-detail-11.png" />
					<span>Tabs</span>				
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-12.png" />
					<span>Page loader</span>
				</td>
			</tr>					
						
		</table>
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td><p>Download Openbiz Cubi today to show the quality of your design work.</p>
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