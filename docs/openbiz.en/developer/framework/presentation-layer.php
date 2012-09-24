<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>图形表现层 － Openbiz Framework － <?php echo SITE_NAME;?></title>
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
					<h2>处理视图与表单对象的底层关联</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						丰富的图形表现形势<br/>
						轻松满足企业应用中的各种需求
					</p>									
						<p style="width:100px;padding-top:15px;">
							<a class="blue-button-go" href="#" >免费获取</a>
						</p>
				</div>
			</div>
		</div>	
	</div>
	
	<div class="content">
		<div class="page-splitter"></div>	
		<div>
			<h2>图形表现层介绍</h2>
			<p>
				Openbiz的图形表现层主要分为 视图对象 表单对象 和 表单控件对象。<br/>
				其主要表现逻辑封装于 Openbiz Cubi 应用平台中，作为框架底层在 Openbiz Framework中负责处理这些对象之间的调用关系，而不负责对其样式和外观进行风格化。<br/> 
				例如在父子表单联动的案例中，Openbiz负责的部分是当父表单触发了 SelectRecord方法后自动刷新与其关联的子表单。但这两个表单具体外观是什么样子是由Smarty模板定义的。在Openbiz Cubi中为开发人员提供了支持全部特性的模板。
			</p>			
		</div>		
		<div class="page-splitter"></div>
		<div class="" style="padding-top: 10px;padding-bottom:10px;">
			<h2>视图对象</h2>
			<p>
				Openbiz的视图对象相当于整个页面，它负责定义该页面如何装载表单、菜单和其他小部件。
				以及适应在各种设备上显示页面。在MVC结构中它与表单对象的实现类文件共同作为控制器(Controller)。
			</p>
			<img class="image-border" src="image/presentationlayer/pic-vo-1.png"></img>
			<img class="image-border" src="image/presentationlayer/pic-vo-2.png" style="margin:0px 10px 0px 10px;"></img>
			<img class="" src="image/presentationlayer/pic-vo-ipad.png"></img>
		</div>
		<div class="page-splitter"></div>
		<div class="" style="padding-top: 10px;padding-bottom:10px;">
			<h2>表单对象</h2>
			<p>
				Openbiz 表单对象是系统的主要数据逻辑部分，它负责数据的展示逻辑，通常每个表单对象都会绑定一个数据对象。<br/>
				常见的表单对象有 列表、详情、编辑、新建、复制几种类型，表单对象可以被潜入在视图中也可以作为内嵌或弹出窗口（层）来使用。
			</p>
			<img class="image-border" src="image/presentationlayer/pic-fo-1.png"></img>
			<img class="image-border" src="image/presentationlayer/pic-fo-2.png" style="margin:0px 10px 0px 10px;"></img>
			<img class="image-border" src="image/presentationlayer/pic-fo-3.png"></img>
		</div>
		<div class="page-splitter"></div>
		<h2>表单控件对象 - Elements</h2>
		<p>
				Openbiz 的表单控件对象是用于在表单对象中绑定数据对象字段使用的。通常每个表单控件会映射到该表单对象所绑定的数据对象的某个列上。
				不同的表单控件提供了不同的数据展示或输入逻辑，除了标准的Web表单控件（文本框、单选菜单、多选菜单、复选框）外，
				Openbiz Framework 还提供了高级控件的支持，例如：条码扫瞄控件、智能卡读卡控件、颜色选择控件、富文本编辑控件等。
				表单控件通常还可以触发事件，事件的定义与HTML控件事件相似，事件行为可以是触发服务器端的对象自定义方法、在表单之间或者客户端Javascript代码 
		</p>
		<h2>Openbiz的高级表单控件展示</h2>
		<table class="present-features screenshots" cellspacing="0" style="padding-top:10px;">
		<tr>
			<td style="width:85px;">
				<a rel="screenshots" href="image/presentationlayer/pic-card.png" title="Openbiz Framework - 智能卡读卡器控件截面">
				<img src="image/presentationlayer/pic-card-small.png" />
				</a>
			</td>
			<td  style="width:330px;">
				<h4>智能卡读卡器控件</h4>
				<p>该控件直接支持键盘口的智能卡读卡器设备，可以捕获设备在浏览器窗口防围内传入的任何自负序列，常用于开发智能卡应用系统使用。例如会员卡管理系统。</p>
			</td>
			<td  style="width:85px;">
				<a rel="screenshots" href="image/presentationlayer/pic-on-off.png" title="Openbiz Framework - 开关按钮截面">
				<img src="image/presentationlayer/pic-on-off-small.png" />
				</a>
			</td>
			<td>
				<h4>开关按钮</h4>
				<p>可以通过直观的开关方式更有好的展示布尔形数据字段</p>
			</td>
		</tr>			
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-scanner.png" title="Openbiz Framework - 条码扫描枪截面">
				<img src="image/presentationlayer/pic-scanner-small.png" />
				</a>
			</td>
			<td>
				<h4>条码扫描枪</h4>
				<p>该控件可以直接读取键盘口的条码扫描枪，可以捕获设备在浏览器窗口防围内传入的任何自负序列，
				常用于开发条码应用系统使用，例如产品库存管理等</p>
			</td>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-sort.png" title="Openbiz Framework - 表格数据排序截面">
				<img src="image/presentationlayer/pic-sort-small.png" />
				</a>
			</td>
			<td>
				<h4>表格数据排序</h4>
				<p>常用于列表表单，可以让用户对表单数据的排序权重进行快捷调整。</p>
			</td>
		</tr>		
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-color.png" title="Openbiz Framework - 颜色选择控件截面">
				<img src="image/presentationlayer/pic-color-small.png" />
				</a>
			</td>
			<td>
				<h4>颜色选择控件</h4>
				<p>框架集成了jQuery ColorPicker控件，可以让用户更加直观的进行颜色选择，该特性在Openbiz的商业产品的按类型定义颜色特性中有大量使用。</p>
			</td>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-search.png" title="Openbiz Framework - 自动提示文本框截面">
				<img src="image/presentationlayer/pic-search-small.png" />
				</a>
			</td>
			<td>
				<h4>自动提示文本框</h4>
				<p>常用于列表表单，可以根据用户已经输入的部分文字自动匹配相关选项</p>
			</td>
		</tr>
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-list.png" title="Openbiz Framework - 带图标的下拉菜单截面">
				<img src="image/presentationlayer/pic-list-small.png" />
				</a>
			</td>
			<td>
				<h4>带图标的下拉菜单</h4>
				<p>比浏览器自带的下拉菜单更加精美的下拉菜单方式，允许开发人员在每个选项上增加图标样式。</p>
			</td>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-bar.png" title="Openbiz Framework - 进度条控件截面">
				<img src="image/presentationlayer/pic-bar-small.png" />
				</a>
			</td>
			<td>
				<h4>进度条控件</h4>
				<p>常用于列表表单，可以直观的展现某项数据的进度，用于绑定整数型字段</p>
			</td>
		</tr>
		<tr>
			<td>
				<a rel="screenshots" href="image/presentationlayer/pic-text.png" title="Openbiz Framework - 富文本编辑控件截面">
				<img src="image/presentationlayer/pic-text-small.png" />
				</a>
			</td>
			<td>
				<h4>富文本编辑控件</h4>
				<p>框架友好的集成了CKEditor的富文本编辑器，可以让用户通过直观既得的方式编辑HTML代码或文档。</p>
			</td>
		</tr>				
		</table>			
	
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							Openbiz Framework图形表现层，处理视图与表单对象的底层关联，满足企业中的各种需求。<br/>
							赶快下载Openbiz Framework感受企业应用系统的动力之源。
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