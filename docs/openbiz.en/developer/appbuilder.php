<?php include_once '../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Openbiz App Builder 应用开发工具 － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../general/js/general.js" type="text/javascript"  ></script>

<!-- fancy box - start -->
<script type="text/javascript" src="../general/js/fancybox/jquery.fancybox.pack.js?v=2.0.6"></script>
<script type="text/javascript" src="../general/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
<script type="text/javascript" src="../general/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.0"></script>
<link rel="stylesheet" href="../general/js/fancybox/jquery.fancybox.css?v=2.0.6" type="text/css" media="screen" />
<!-- fancy box - end -->

<link href="general/style/general.css" rel="stylesheet" type="text/css" />
<link href="general/style/appbuilder.css" rel="stylesheet" type="text/css" />
<script src="general/js/navigation.js" type="text/javascript" ></script>
<script type="text/javascript" >
$(document).ready(function(){	
	try{
		$(".play-video").fancybox({
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			helpers : {
				media : {}
			}
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
	<?php require_once(SITE_ROOT_PATH.'/developer/general/_include/_developer-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="developer-appbuilder-banner-wrapper" >
		<div id="appbuilder-banner-wrapper" >
			<div id="appbuilder-banner" class="banner" >
				<a class="play-video" href="#video-player"></a>
				<div class="desc" style="padding-top:70px;">
					<h1 style="height:auto;"><a href="appbuilder"><img src="appbuilder/image/banner-title.png" title="Openbiz Appbuilder"/></a></h1>
					<p>提供丰富可重用性逻辑，精美的界面。<br/>让以数据为核心的企业级应用开发效率倍升。</p>
					<img src="appbuilder/image/banner-price.png" />
					<p class="buttons">
						<a class="blue-button-go" href="#" >立即购买</a>
						<a class="gray-button" href="appbuilder" >了解详情</a>
					</p>
				</div>
			</div>
		</div>	
	</div>
	
	<div id="video-player" style="display:none;">
		<video width="480" height="360" controls="controls">
		  <source src="appbuilder/video/test-video.mp4" type="video/mp4" />
		  <source src="appbuilder/video/test-video.ogg" type="video/ogg" />
		  您的浏览器不支持 HTML5 视频播放，请您升级您的浏览器。
		</video>
		<p class="buttons">
			<a class="blue-button-go" href="#" >立即购买</a>
			<a class="gray-button" href="appbuilder" >了解详情</a>
		</p>
	</div>
	
	<div class="content">
			<table class="intro-table appbuilder-intro" style="margin-bottom: 10px;">
				<tr>
					<td >
						<div class="content-block" >
						<a class="learn-more" href="appbuilder/">了解更多</a>						
						<h3  style="margin-bottom:10px;">新App生成向导</h3>
						<table class="features new-app">
						<tr>
							<td style="width:250px;">
								<p>通过向导的方式生成出一个可独立运行的应用程序，包括数据表和所有元数据文件、模板和其它描述文件。</p>
							</td>							
						</tr>
						</table>
						</div>
					</td>
					<td>
						<div class="content-block">
						<a class="learn-more" href="appbuilder/">了解更多</a>						
						<h3  style="margin-bottom:10px;">模块关联向导</h3>
						<table class="features link-module">
						<tr>
							<td style="width:250px;">
								<p>简单几步即可在模块之间实现一对多(1-M)或 多对多(M-M) 的映射关系，并同时为您自动实现相关的用户界面。</p>
							</td>
						</tr>
						</table>
						</div>
					</td>
					<td>
						<div class="content-block" >
						<a class="learn-more" href="appbuilder/">了解更多</a>						
						<h3  style="margin-bottom:10px;">元数据编辑器</h3>
						<table class="features metadata-editor">
						<tr>
							<td style="width:250px;">
								<p>通过图形界面的方式来直观的编辑程序和数据映射关系。同时，也可以允许开发人员在线直接编辑源代码。</p>
							</td>
						</tr>
						</table>
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