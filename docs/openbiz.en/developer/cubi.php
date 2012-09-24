<?php include_once '../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Openbiz Cubi Application Development Platform － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../general/js/general.js" type="text/javascript"  ></script>

<!-- fancy box - start -->
<script type="text/javascript" src="../general/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../general/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!-- fancy box - end -->

<link href="general/style/general.css" rel="stylesheet" type="text/css" />
<link href="general/style/cubi.css" rel="stylesheet" type="text/css" />
<script src="general/js/navigation.js" type="text/javascript" ></script>
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
	<?php //require_once(SITE_ROOT_PATH.'/developer/general/_include/_developer-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="developer-banner-wrapper" style="background-position: center 65px;height:350px;" >
		<div id="cubi-banner-wrapper" >
			<div id="cubi-banner" class="banner" >
				<div class="desc" >
					<h1 style="height:auto;padding-bottom:10px;"><a href="cubi/"><img src="cubi/image/cubi-banner-title.png" title="Openbiz Cubi Platform"/></a></h1>
					<p>Provide rich reusable components and fine-tuned UI<br/>Speed up data-drieven enterprise applications development</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >Download</a>
						<a class="gray-button" href="cubi" >Know more</a>
					</p>
				</div>
				<table class="screenshots">
						<tr>
							<td >
								<a rel="screenshots" href="cubi/image/screenshot-intro-1-large.png" title="Openbiz Cubi - System Admin screen">
								<img src="cubi/image/screenshot-intro-1-small.png" />
								</a>
							</td>
							<td >
								<a rel="screenshots" href="cubi/image/screenshot-intro-2-large.png" title="Openbiz Cubi - Data list view">
								<img src="cubi/image/screenshot-intro-2-small.png" />
								</a>
							</td>						
							<td>
								<a rel="screenshots" href="cubi/image/screenshot-intro-3-large.png" title="Openbiz Cubi - Data detail view">
								<img src="cubi/image/screenshot-intro-3-small.png" />
								</a>
							</td>
							<td>
								<a rel="screenshots" href="cubi/image/screenshot-intro-4-large.png" title="Openbiz Cubi - Data editing view">
								<img src="cubi/image/screenshot-intro-4-small.png" />
								</a>
							</td>
							<td>
							<p>We focus on any detail end users may care<br/>
								You impress your client with high product quality<br/>
							</p>
							<a class="cubi-banner-more" href="cubi/screenshot.php">More user interface ...</a>
							</td>
						</tr>
				</table>
			</div>
		</div>	
	</div>
	
	<div class="content" style="padding-top:10px">
			<table class="intro-table cubi-intro" style="margin-bottom: 10px;">
				<tr>
					<td>
						<div class="content-block" style="padding-bottom: 5px;width:490px;margin-right:5px;height:165px;">					
						<h3  style=" border-bottom:0px;">Key Features</h3>
						<table class="features">
						<tr>
							<td >
								<a href="cubi/" class="rapid">
								<span>Fast development</span>
								</a>
							</td>
							<td >
								<a href="cubi/create-your-brand.php" class="license">
								<span>Open Source License</span>
								</a>
							</td>
							<td >
								<a href="cubi/rich-modules.php" class="module">
								<span>Rich Components</span>
								</a>
							</td>
						</tr>
						<tr>
							<td >
								<a href="cubi/screenshot.php" class="beauty">
								<span>Cool User Interface</span>
								</a>
							</td>
							<td >
								<a href="cubi/" class="easy">
								<span>Easy Configuration</span>
								
								</a>
							</td>
							<td >
								<a href="cubi/quick-start.php" class="clean">
								<span>Solid Framework</span>
								</a>
							</td>
						</tr>
						</table>
						</div>
					</td>
					<td>
						<div class="content-block testimonials" style="height:150px;" >
							<a class="learn-more" href="cubi/testimonials.php">More...</a>						
							<h3 style="border-bottom:none;">Testimonials</h3>
							<p>Openbiz has enabled us to develop fully functional prototypes in a glimpse. This helps us to validate requirements with customers faster and cheaper. ... After our customer validates what s/he really needs, also Openbiz enables us to finish it with production quality.</p>
							<div class="sign">
							<table style="padding:0px;margin:0px;float:right;">
								<tr>
									<td>Juan Gonzalez, CEO of Innox</td>
								</tr>
							</table>
							</div>
						</div>
					</td>
				</tr>							
			</table>	
	</div>
    <!-- site footer START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-footer.php'); ?>
	<!-- site footer END -->    
</div> 
</body>
</html>