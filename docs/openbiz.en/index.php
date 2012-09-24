<?php include_once 'config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-validation.php'); ?>
<title><?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="general/style/general.css" rel="stylesheet" type="text/css" />
<script src="general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="general/js/general.js" type="text/javascript"  ></script>

<!-- Input Hints -->
<script type="text/javascript" src="general/js/inputhints/jquery.inputhints.min.js"  ></script>

<!-- jQuery UI 1.8 libs-->
<script type="text/javascript" src="general/js/jquery/jquery-ui-1.8.21.custom.min.js"></script>
<link rel="stylesheet" href="general/style/ui-lightness/jquery-ui-1.8.21.custom.css" type="text/css" media="all"/>

<!-- code for slider START -->
<link rel="stylesheet" href="general/js/royal-slider/css/royalslider.css" />
<link rel="stylesheet" href="general/js/royal-slider/css/royalslider-skins/iskin/iskin.css" />
<script src="general/js/jquery/jquery.easing.1.3.min.js"></script>
<script src="general/js/royal-slider/royal-slider-8.1.min.js"></script>

<link href="frontpage/style/general.css" rel="stylesheet" type="text/css" />
<!-- fancy box - start -->
<script type="text/javascript" src="general/js/fancybox/jquery.fancybox.pack.js?v=2.0.6"></script>
<script type="text/javascript" src="general/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
<script type="text/javascript" src="general/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.0"></script>
<link rel="stylesheet" href="general/js/fancybox/jquery.fancybox.css?v=2.0.6" type="text/css" media="screen" />
<!-- fancy box - end -->
<script type="text/javascript" >
$(document).ready(function(){	
	try{
		$(".video-player-block a").fancybox({
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
	
	<div id="frontpage-banner-wrapper" class="royalSlider iskin">
	<ul class="royalSlidesContainer">
	<li class="royalSlide">
		<div class="collab-banner banner royalCaption" style=";">
			<div class="desc royalCaptionItem"  data-show-effect="fade moveright" >
				<h1  ><img src="frontpage/image/banner-collab-title.png" /></h1>
				<p>Collaboration将商学管理与软件科技高度融合<br/>
                为提高核心发展能力而设计的智能办公管理平台
				</p>
				<img class="price" src="frontpage/image/banner-collab-price.png" />
				<p class="buttons" style="height:40px;">
					<a class="blue-button-go" href="#" >立即购买</a>
					<a class="gray-button" href="enterprise/collab.php" >了解详情</a>
				</p>
				<div style="padding-top:30px;">
					<img src="frontpage/image/banner-collab-lt.png" />
				</div>
			</div>
		</div>
	</li>
	
	<li class="royalSlide">	
		<div class="appbuilder-banner banner royalCaption" style=";">
			<div class="desc royalCaptionItem"  data-show-effect="fade moveright">
				<h1><img src="frontpage/image/banner-appbuilder-title.png" /></h1>
				<p>通过向导生成企业级应用雏形<br/>
				创建完整企业应用只需轻松的3步
				</p>
				<img class="price" src="frontpage/image/banner-appbuilder-price.png" />
				<p class="buttons">
					<a class="blue-button-go" href="#" >立即购买</a>
					<a class="gray-button" href="developer/appbuilder.php" >了解详情</a>
				</p>
			</div>
		</div>
	</li>
	
	<li class="royalSlide">	
		<div class="appcloud-banner banner royalCaption" style=";">
			<div class="desc royalCaptionItem"  data-show-effect="fade moveright">
				<h1><img src="frontpage/image/banner-appcloud-title.png" /></h1>
				<p>低风险 轻量级 满足小型及微型企业应用<br/>
				预装Openbiz Cubi系统的应用云解决方案</p>
				<table class="product-hightlight">
					<tr>
						<td>存储容量</td>
						<td ><div class="progressbar" id="appcloud-storage"></div></td>
						<td>20 GB</td>
					</tr>
					<tr>
						<td>应用承载量</td>
						<td><div class="progressbar" id="appcloud-apps"></div></td>
						<td>≤ 30 应用</td>
					</tr>
					<tr>
						<td>用户承载量</td>
						<td><div class="progressbar" id="appcloud-users"></div></td>
						<td>≤ 25 用户</td>
					</tr>
				</table>				
				<script>
					$(".appcloud-banner #appcloud-storage").progressbar({ value: 30 });
					$(".appcloud-banner #appcloud-apps").progressbar({ value: 40 });
					$(".appcloud-banner #appcloud-users").progressbar({ value: 35 });
				</script>
				<img class="price" src="frontpage/image/banner-appcloud-price.png" />
				<p class="buttons">
					<a class="blue-button-go" href="#" >立即购买</a>
					<a class="gray-button" href="developer/appcloud.php" >了解详情</a>
				</p>
			</div>
		</div>
	</li>
	
	<li class="royalSlide">	
		<div class="appserver-banner banner royalCaption" style=";">
			<div class="desc royalCaptionItem"  data-show-effect="fade moveright">
				<h1 ><img src="frontpage/image/banner-appserver-title.png" /></h1>
				<p>专为中小企业打造的轻量级应用服务器<br/>
				提供高性价比的低实施风险的简单易用的入门解决方案</p>
				<table class="product-hightlight">
					<tr>
						<td>存储容量</td>
						<td ><div class="progressbar" id="appserver-storage"></div></td>
						<td>465 GB</td>
					</tr>
					<tr>
						<td>应用承载量</td>
						<td><div class="progressbar" id="appserver-apps"></div></td>
						<td>≤ 100 应用</td>
					</tr>
					<tr>
						<td>用户承载量</td>
						<td><div class="progressbar" id="appserver-users"></div></td>
						<td>≤ 50 用户</td>
					</tr>
				</table>				
				<script>
					$(".appserver-banner #appserver-storage").progressbar({ value: 75 });
					$(".appserver-banner #appserver-apps").progressbar({ value: 60 });
					$(".appserver-banner #appserver-users").progressbar({ value: 40 });
				</script>
				<img class="price" src="frontpage/image/banner-appserver-price.png" />
				<p class="buttons">
					<a class="blue-button-go" href="#" >立即购买</a>
					<a class="gray-button" href="hardware/appserver.php" >了解详情</a>
				</p>
			</div>
		</div>
	</li>
	
	<li class="royalSlide">	
		<div class="certification-banner banner royalCaption" style=";">
			<div class="desc royalCaptionItem"  data-show-effect="fade moveright">
				<h1><img src="frontpage/image/banner-certification-title.png" /></h1>
				<ul>
					<li><a href="certification/product-expert.php">Openbiz 产品专家认证</a></li>
					<li><a href="certification/enterprise-developer.php">Openbiz 企业研发工程师认证</a></li>					
					<li><a href="certification/business-partner.php">Openbiz 全球合作伙伴认证</a></li>
				</ul>				
				<a class="gray-button" href="developer/appbuilder.php" >了解详情</a>
			</div>
		</div>		
	</li>
	</ul>
	</div>
	<script>
	$(document).ready(function() {
	  var myslider= $("#frontpage-banner-wrapper").royalSlider({
	        captionShowEffects:["moveleft", "fade"],
	        directionNavAutoHide: true,
	        keyboardNavEnabled:true,
	        slideshowEnabled: true, 
	        slideshowDelay:5000,
	        slideshowPauseOnHover: true, 
	        slideshowAutoStart:false
	    }).data("royalSlider");;  

	    
	});
	</script>


	<div id="video-collab" class="player" style="display:none;">
		<h1>智能企业办公系统</h1>
		<video width="480" height="360" poster="enterprise/collab/video/collab-intro.png" controls="controls">
		  <source src="enterprise/collab/video/collab-intro.mp4" type="video/mp4" />
		  <source src="enterprise/collab/video/collab-intro.ogg" type="video/ogg" />
		  您的浏览器不支持 HTML5 视频播放，请您升级您的浏览器。
		</video>
		<p class="buttons">
			<a class="blue-button-go" href="#" >立即购买</a>
			<a class="gray-button" href="enterprise/collab.php" >了解详情</a>
		</p>
	</div>
	
	<div id="video-appbuilder" class="player" style="display:none;">
		<h1>Openbiz App Builder</h1>
		<video width="480" height="360" controls="controls">
		  <source src="developer/appbuilder/video/test-video.mp4" type="video/mp4" />
		  <source src="developer/appbuilder/video/test-video.ogg" type="video/ogg" />
		  您的浏览器不支持 HTML5 视频播放，请您升级您的浏览器。
		</video>
		<p class="buttons">
			<a class="blue-button-go" href="#" >立即购买</a>
			<a class="gray-button" href="developer/appbuilder.php" >了解详情</a>
		</p>
	</div>	
	
	<div id="video-asset" class="player" style="display:none;">
		<h1>Openbiz Asset </h1>
		<video width="480" height="360" controls="controls">
		  <source src="developer/appbuilder/video/test-video.mp4" type="video/mp4" />
		  <source src="developer/appbuilder/video/test-video.ogg" type="video/ogg" />
		  您的浏览器不支持 HTML5 视频播放，请您升级您的浏览器。
		</video>
		<p class="buttons">
			<a class="blue-button-go" href="#" >立即购买</a>
			<a class="gray-button" href="enterprise/asset.php" >了解详情</a>
		</p>
	</div>		

	<div id="site-page-content">
		
		<div class="content" style="padding-top:10px;">
			<table class="video-table">
				<tr>
					<td >
						<div class="content-block intro-collab" >
						<h3>企业智能办公管理平台</h3>
						<p class="video-player-block video-player-collab"><a class="play-button" href="#video-collab"></a></p>
						</div>
					</td>
					<td>
						<div class="content-block intro-appbuilder">
						<h3>App Builder 快速开发工具</h3>
						<p class="video-player-block video-player-appbuilder"><a class="play-button" href="#video-appbuilder"></a></p>
						</div>
					</td>
					<td>
						<div class="content-block intro-asset">
						<h3>Asset 企业资产管理系统</h3>
						<p class="video-player-block video-player-asset"><a class="play-button" href="#video-asset"></a></p>
						</div>
					</td>
					<td>
						<div class="content-block intro-certification" style="width:190px;" >
						<h2 >Openbiz认证有效性查询</h2>
						<img style="padding-bottom:4px;padding-left:12px;" src="frontpage/image/certification-validator.png" />
						<div class="form"  >
							<form action="certification/validation.php" method="get" id="certification-validator">
								<input type="text" name="code" class="input-text" style="float:left;margin-right:4px;" title="请输入证书编码..." />
								<a href="javascript:;" style="float:left;margin-top:1px;" onclick="$('#certification-validator').submit()" class="gray-button-small">查询</a>
								<div style="display:none;"><input type="submit"  /></div>
							</form>
						</div>
						</div>
					</td>
				</tr>							
			</table>			
		</div>
		

	</div>	
	
    <!-- site footer START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-footer.php'); ?>
	<!-- site footer END -->    
</div> 
</body>
</html>