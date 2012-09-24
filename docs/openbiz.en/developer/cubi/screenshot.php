<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>漂亮的用户界面 － Openbiz Cubi Platform － <?php echo SITE_NAME;?></title>
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
					<h2 >给客户留下专业清爽之感</h2>
					<p>我们关注了让用户感受到的每一个小细节，<br/>让您在客户面前留下一个专业高品质的印象。</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >免费获取</a>
					</p>
					</div>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<h2>基础功能样式</h2>
		<p>快速了解一下基于Openbiz Cubi平台创建的应用程序究竟是什么样子。</p>
		<table class="screenshots">
			<tr>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-1-large.png" title="Openbiz Cubi - 系统管理员截面">
					<img src="image/screenshot/screenshot-basic-1.png" />
					<span>系统管理员界面</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-2-large.png" title="Openbiz Cubi - 数据列表视图">
					<img src="image/screenshot/screenshot-basic-2.png" />
					<span>数据列表界面</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-3-large.png" title="Openbiz Cubi - 数据详情视图">
					<img src="image/screenshot/screenshot-basic-3.png" />
					<span>数据详情界面</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-basic" href="../cubi/image/screenshot-intro-4-large.png" title="Openbiz Cubi - 数据编辑视图">
					<img src="image/screenshot/screenshot-basic-4.png" />
					<span>数据编辑界面</span>
					</a>
				</td>
			</tr>
		</table>
		<p>这些界面将是我们每天都与之打交道的界面，它有自己统一的风格和使用习惯，这样的设计是为了让用户可以快速上手一个新的应用。因为每个应用的界面和操作习惯都是尽可能保持一致，不会让您的用户觉得无从下手。</p>
		
		<div class="page-splitter"></div>
		<h2>高级特性样式</h2>
		<p>除了基本风格统一的基础特性之外，Openbiz Cubi 应用平台还为扩展应用领域支持了更多高级展现逻辑。<br/>
		这将会成为您的应用系统的绝对亮点，让您的应用限的格外专业。</p>
		<table class="screenshots">
			<tr>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-1-large.png" title="Openbiz Cubi - 地图特性">
					<img src="image/screenshot/screenshot-advanced-1-small.png" />
					<span>地图特性</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-2-large.png" title="Openbiz Cubi - 图表特性">
					<img src="image/screenshot/screenshot-advanced-2-small.png" />
					<span>图表特性</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-3-large.png" title="Openbiz Cubi - 日历特性">
					<img src="image/screenshot/screenshot-advanced-3-small.png" />
					<span>日历特性</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-4-large.png" title="Openbiz Cubi - 甘特图特性">
					<img src="image/screenshot/screenshot-advanced-4-small.png" />
					<span>甘特图特性</span>
					</a>
				</td>
			</tr>
			
			<tr>	
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-5-large.png" title="Openbiz Cubi - 多步向导特性">
					<img src="image/screenshot/screenshot-advanced-5-small.png" />
					<span>多步向导特性</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-6-large.png" title="Openbiz Cubi - 读卡器控件">
					<img src="image/screenshot/screenshot-advanced-6-small.png" />
					<span>读卡器控件</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-7-large.png" title="Openbiz Cubi - 条码扫描枪控件">
					<img src="image/screenshot/screenshot-advanced-7-small.png" />
					<span>条码扫描枪控件</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-8-large.png" title="Openbiz Cubi - 数据共享特性">
					<img src="image/screenshot/screenshot-advanced-8-small.png" />
					<span>数据共享特性</span>
					</a>
				</td>
			</tr>			
			
			<tr>	
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-9-large.png" title="Openbiz Cubi - 电子邮件集成特性">
					<img src="image/screenshot/screenshot-advanced-9-small.png" />
					<span>电子邮件集成特性</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-10-large.png" title="Openbiz Cubi - 社交账号绑定">
					<img src="image/screenshot/screenshot-advanced-10-small.png" />
					<span>社交账号绑定</span>
					</a>
				</td>
				<td>
					<a rel="screenshots-advanced" href="image/screenshot/screenshot-advanced-11-large.png" title="Openbiz Cubi - 用户登陆">
					<img src="image/screenshot/screenshot-advanced-11-small.png" />
					<span>用户登陆</span>
					</a>
				</td>
				<td>
				</td>
			</tr>			
						
		</table>

		<div class="page-splitter"></div>
		<h2>精致的细节</h2>
		<p>这是Openbiz宣称注重用户体验的绝佳体现。
			为了取悦您和最终用户的眼睛，我们在这几个像素的细节效果上花费了数年的精力去不断完善。这也许是您看不到，甚至不在意的，但细节所带您和用户的感受，我们相信将成为决胜未来的关键因素。 
		</p>
		<table class="screenshots-detail">
			<tr>
				<td>
					<img src="image/screenshot/screenshot-detail-1.png" />
					<span>帮助菜单的按钮</span>
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-2.png" />
					<span>表格按列排序</span>
				</td>
				<td>					
					<img src="image/screenshot/screenshot-detail-3.png" />
					<span>日历特性</span>				
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-4.png" />
					<span>列表翻页细节</span>
				</td>
			</tr>
			
			<tr>
				<td>
					<img src="image/screenshot/screenshot-detail-5.png" />
					<span>帮助菜单的按钮</span>
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-6.png" />
					<span>表格按列排序</span>
				</td>
				<td>					
					<img src="image/screenshot/screenshot-detail-7.png" />
					<span>日历特性</span>				
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-8.png" />
					<span>列表翻页细节</span>
				</td>
			</tr>
			
			<tr>
				<td>
					<img src="image/screenshot/screenshot-detail-9.png" />
					<span>帮助菜单的按钮</span>
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-10.png" />
					<span>表格按列排序</span>
				</td>
				<td>					
					<img src="image/screenshot/screenshot-detail-11.png" />
					<span>日历特性</span>				
				</td>
				<td>
					<img src="image/screenshot/screenshot-detail-12.png" />
					<span>列表翻页细节</span>
				</td>
			</tr>					
						
		</table>
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td><p>Openbiz Cubi的系统界面设计关注每一个小细节，给人清爽、专业、细腻之感，让您在客户面前留下的高品质的印象。<br/>
						赶快下载Openbiz Cubi，专为企业级应用开发而设计。</p>
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