<?php include_once '../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Openbiz App Cloud 企业应用云 － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../general/js/general.js" type="text/javascript"  ></script>

<!-- jQuery UI 1.8 libs-->
<script type="text/javascript" src="../general/js/jquery/jquery-ui-1.8.21.custom.min.js"></script>
<link rel="stylesheet" href="../general/style/ui-lightness/jquery-ui-1.8.21.custom.css" type="text/css" media="all"/>

<link href="appcloud/style/appcloud.css" rel="stylesheet" type="text/css" />
<link href="general/style/general.css" rel="stylesheet" type="text/css" />
<script src="general/js/navigation.js" type="text/javascript" ></script>

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
	
	<div id="developer-banner-wrapper" style="height:360px;background-position:center bottom;">
		<div id="appcloud-banner" >
			<div class="appcloud-desc desc" style="width:880px;height:310px;">
				<h1 style="height:auto;"><a href="appserver.php"><img src="appcloud/image/banner-title.png" title="Openbiz App Cloud"/></a></h1>
				<h2 style="color:#666666;">低风险 轻量级 应用云解决方案</h2>
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
					$("#appcloud-banner #appcloud-storage").progressbar({ value: 30 });
					$("#appcloud-banner #appcloud-apps").progressbar({ value: 40 });
					$("#appcloud-banner #appcloud-users").progressbar({ value: 35 });
				</script>
				<div >
				
				<p class="learn-more">＊预装 Openbiz Cubi 企业应用平台。<a href="cubi/">了解详情</a></p>
				 
				</div>
				<img class="price" src="appcloud/image/banner-price.png" title="应用云 价格"/>
				<p class="buttons">
					<a class="blue-button-go" href="#" >立即订购</a>
				</p>
			</div>
		</div>
	</div>
	
	<div id="site-page-content">
	<div class="page-splitter"></div>	
	<div class="prodcut-content">
		<h2>Openbiz App Cloud</h2>
		<p>应用云是为了满足小型及微型企业应用而设计的预装Openbiz Cubi系统的云主机服务。</p>
		<p style="padding:0px">它的设计目标正是为这些企业提供高性价比的低实施风险的简单易用的入门解决方案。让这些高级的管理系统不再成为大型企业或科技企业的专属，App Cloud使它们可以降低门槛，让真正更需要信息化管理的小型企业能够轻松上手。</p>
		<p style="padding-bottom:10px">您完全不用担心实施风险，他甚至不占地方也不费电。相信灵活的Openbiz App Cloud将为您带来不一样的网络办公体验。</p>
	</div>
	
	<div class="page-splitter"></div>
	<div class="prodcut-content">
		<h2>预装 Openbiz Cubi 平台</h2>
		<p style="padding-bottom:0px">Openbiz Cubi平台是搭载所有企业Openbiz企业级应用的开放平台，您可以通过Cubi平台的应用市场(App Market)功能来下载到您感兴趣的企业办公应用系统。对！他就象您在使用iPhone一样轻松方便的获得更多扩展应用。只需要轻轻一点，相应的办公系统就自动为您安装搭建好了。再也不用雇上个月薪几千元的IT人员为此忙活个好几天了。</p>
		<p style="padding-bottom:10px">Openbiz Cubi平台是开源免费的，这意味着您将会看到可以在Cubi的应用市场上免费下载到更多企业管理相关的应用或试用。</p>
	</div>
	
	<div class="page-splitter"></div>
	<div class="prodcut-content">
		<h2>按需灵活扩展</h2>
		<p style="padding-bottom:0px">如果有一天我的企业规模发展大了，这个“应用云”承载不了怎么办？<br/>
应用云具备了云主机个按序扩展特性，您可以随时选择为该云主机升级内存，磁盘和处理器配额，来满足您不断变换的性能需求。
		</p>
		<p style="padding-bottom:10px">Openbiz Cubi平台还提供了方便的备份还原向导，以便于您可以轻松的将平台切换到Openbiz App Server“应用服务器”之上。</p>
	</div>
	<div class="page-splitter"></div>
	<div style="text-align: left; padding-top:20px;">
		<h2>Openbiz应用云优势</h2>
	</div>
	<table class="table-2-columns" >
			<tr>
				<th><a href="#"><img src="appcloud/image/icon-software.png"/></a></th>					
				<td>
				<h3>软件众多</h3>
					<p >						
						Openbiz的应用云平台提供一系列企业办公自动化应用软件，比如资产管理、日程安排、项目管理、智能办公平台、智能报表等等。用户可以随时根据业务需求选择适合自身的企业办公应用软件。
					</p>
				</td>
			</tr>
			<tr>
				<th><a href="#"><img src="appcloud/image/icon-easy-create.png"/></a></th>					
				<td>
				<h3>开通快捷</h3>
					<p >						
						用户仅需要短短几分钟时间注册即可马上拥有您企业专属的应用云平台。
					</p>
				</td>
			</tr>
			<tr>
				<th><a href="#"><img src="appcloud/image/icon-auto-backup.png"/></a></th>					
				<td>
				<h3>自动更新</h3>
					<p >						
						Openbiz是一个来自美国的已经成长了超过十年成熟的框架体系。来自全球各地的技术支持者和众多的开发工程师在不断的为其更新和完善。Openbiz 的应用云用户可以长期享受到免费更新，和世界最顶尖的开发技术的商业化应用。拥有Openbiz应用云，您就拥有了一个为您企业应用
					</p>
				</td>
			</tr>
			<tr>
				<th><a href="#"><img src="appcloud/image/icon-easy-access.png"/></a></th>					
				<td>
				<h3>访问便捷</h3>
					<p>						
						Openbiz的应用云支持跨平台访问，用户可以通过任何能够访问网络的设备：笔记本、台式机、iphone、ipod、安卓手机都可以随时随地访问您的Openbiz应用云。
					</p>
				</td>
			</tr>
			<tr>
				<th><a href="#"><img src="appcloud/image/icon-safe.png"/></a></th>					
				<td>
				<h3>安全稳定</h3>
					<p>						
						使用Openbiz应用云的企业，不需要在担心服务器的部署、更新、维护，也不用担心数据的备份，还原，也不用担心更多技术细节，一切都由我们帮您维护。
					</p>
				</td>
			</tr>
			<tr>
				<th><a href="#"><img src="appcloud/image/icon-save-money.png"/></a></th>					
				<td>
				<h3>更低门槛</h3>
					<p>						
						使用Openbiz应用云让您接收了服务器的硬件成本，也节省了每年6000元的服务器托管费用，还节省了您宝贵的办公室资源，一切都由Openbiz应用云帮您解决。
					</p>
				</td>
			</tr>	
	</table>
	<!-- 
	<div class="page-splitter"></div>
	<div class="prodcut-content" style="padding-top:5px;">			
				<table>
				<tr>
					<td>
					
					<table class="product-specification" cellspacing="0">
						<tr>
							<td colspan="2"><h2>主板参数</h2></td>
						</tr>
						<tr class="odd">
							<th>主板品牌</th>
							<td>Intel</td>
						</tr>
						<tr>
							<th>主板型号</th>
							<td>BOXD945GCLF2</td>
						</tr>						
						<tr class="odd">
							<th>CPU</th>
							<td>Atom330</td>
						</tr>
						<tr>
							<th>风扇</th>
							<td>自带</td>
						</tr>
						<tr class="odd">
							<th>主频</th>
							<td>533/400MHZ</td>
						</tr>
						<tr>
							<th>CPU技术</th>
							<td>Hyper-Threading Technology</td>
						</tr>
						<tr class="odd">
							<th>北桥</th>
							<td>Inter 945GC</td>
						</tr>
						<tr>
							<th>南桥</th>
							<td>Inter ICH7</td>
						</tr>
						<tr class="odd">
							<th>内存接口</th>
							<td>1*240pin</td>
						</tr>
						<tr>
							<th>内存标准</th>
							<td>DDR2 667</td>
						</tr>
						<tr class="odd">
							<th>内存最大</th>
							<td>2GB</td>
						</tr>
						<tr>
							<th>扩展PCI</th>
							<td>1</td>
						</tr>
						<tr class="odd">
							<th>PATA</th>
							<td>1*ATA 100 2 Dev Max</td>
						</tr>
						<tr>
							<th>SATA</th>
							<td>2*SATA 3.0Gb/s</td>
						</tr>
						<tr class="odd">
							<th>显卡芯片</th>
							<td>Intel GMA950</td>
						</tr>
						<tr>
							<th>声卡芯片</th>
							<td>6 Channels</td>
						</tr>
						<tr class="odd">
							<th>网卡速度</th>
							<td>10/100/1000Mbps</td>
						</tr>
						
						<tr>
							<th>PS/2</th>
							<td>2</td>
						</tr>
						<tr class="odd">
							<th>COM</th>
							<td>1</td>
						</tr>
						<tr>
							<th>LPT</th>
							<td>1</td>
						</tr>
						<tr class="odd">
							<th>Video</th>
							<td>D-Sub</td>
						</tr>
						<tr>
							<th>S-Video</th>
							<td>1</td>
						</tr>
						<tr class="odd">
							<th>USB1.1/2.0</th>
							<td>2 * USB 2.0</td>
						</tr>
						<tr>
							<th>Audio Ports</th>
							<td>3   Ports</td>
						</tr>
						<tr class="odd">
							<th>Onboard USB</th>
							<td>4 * USB 2.0</td>
						</tr>
						<tr>
							<th>Form Factor</th>
							<td>Mini ITX</td>
						</tr>	
													
					</table>										
					</td>
					<td>
					<table class="product-specification" cellspacing="0">
						<tr>
							<td colspan="2"><h2>物理参数</h2></td>
						</tr>
						<tr class="odd">
							<th>外形尺寸</th>
							<td>长×宽×高：200*215*78mm（含脚垫8mm）</td>
						</tr>
						<tr>
							<th>材质</th>
							<td>铝制机箱</td>
						</tr>				
					</table>				
					<table class="product-specification" cellspacing="0">
						<tr>
							<td colspan="2"><h2>硬盘参数</h2></td>
						</tr>
						<tr class="odd">
							<th>型号</th>
							<td>ST95005620AS</td>
						</tr>
						<tr>
							<th>接口</th>
							<td>SATA</td>
						</tr>
						<tr class="odd">
							<th>转速</th>
							<td>7200</td>
						</tr>
						<tr>
							<th>多段缓存</th>
							<td>32</td>
						</tr>
						<tr class="odd">
							<th>寻道时间</th>
							<td>11.0  ms</td>
						</tr>
						<tr>
							<th>写入时间</th>
							<td>13.0  ms</td>
						</tr>
						<tr class="odd">
							<th>硬盘容量</th>
							<td>500GB</td>
						</tr>
					</table>
					<table class="product-specification" cellspacing="0">
						<tr>
							<td colspan="2"><h2>环境参数</h2></td>
						</tr>
						<tr class="odd">
							<th>工作温度</th>
							<td>0℃-85℃</td>
						</tr>
						<tr>
							<th>储存温度</th>
							<td>-20℃-80℃</td>
						</tr>
						<tr class="odd">
							<th>湿度</th>
							<td>相对湿度5%-55%（无凝结）</td>
						</tr>						
					</table>					
					</td>
				</tr>
				</table>
					
			</div>
			 -->	
	</div>	
	<div style="height:20px;"></div>
	
    <!-- site footer START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-footer.php'); ?>
	<!-- site footer END -->    
</div> 
</body>
</html>