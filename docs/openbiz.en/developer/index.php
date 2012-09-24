<?php include_once '../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>面向研发人员 － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../general/js/general.js" type="text/javascript"  ></script>

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
	
	<div id="developer-banner-wrapper" style="background-position: center 65px;height:400px;" >
		<div id="developer-frontpage-banner-wrapper" >
			<div id="developer-banner" class="banner" >
				<div class="desc" >
					<h1 style="height:auto;padding-bottom:10px;"><a href="cubi/"><img src="appbuilder/image/banner-title-big.png" title="Openbiz Appbuilder"/></a></h1>
					<h2 style="color:#333333;font-size:20px;padding-bottom:15px;">快速创建企业级应用程序</h2>
					<p>通过向导生成企业级应用雏形<br/>创建完整企业应用只需轻松的3步</p>
					<img src="appbuilder/image/banner-price-big.png" style="padding-top:10px;padding-bottom: 10px;" />
					<p class="buttons">
						<a class="blue-button-go" href="#" >立即购买</a>
						<a class="gray-button" href="appbuilder.php" >了解详情</a>
					</p>
				</div>				
			</div>
		</div>	
	</div>
	
	<div id="site-page-content">
			
			<div class="page-splitter"></div>
			<div class="prodcut-content" style="padding-top:5px;padding-bottom:15px;">	
				
				<table>
					<tr>
						<td>
							<div class="related-product-block" >
								<table>
									<tr>
									<td class="preview">
										<a href="appbuilder.php"><img src="appbuilder/image/product-pic-small.png" title="Openbiz App Builder"/></a>
									</td>
									<td>
										<h2><a href="appbuilder.php"><img src="appbuilder/image/product-title-small.png" title="Openbiz App Builder"/></a></h2>
										<p>通过向导生成企业级应用雏形</p>
										<img src="appbuilder/image/product-price-small.png" title="Openbiz App Builder 价格"/>
										<div class="action">
										<a class="gray-button-buy" href="#">购买</a>
										<a class="gray-button-small" href="appbuilder.php">详情</a>
										</div>
									</td>
									</tr>
								</table>
							
							
							</div>
						</td>
						
						<td>
							<div class="related-product-block" >
								<table>
									<tr>
									<td class="preview">
										<a href="cubi.php"><img src="cubi/image/product-pic-small.png" title="Openbiz Cubi Platform"/></a>
									</td>
									<td>
										<h2><a href="cubi.php"><img src="cubi/image/product-title-small.png" title="Openbiz Cubi Platform"/></a></h2>
										<p>为商业应用设计的快速开发平台</p>
										
										<img src="cubi/image/product-price-small.png" style="padding-top:3px;padding-bottom:3px;" title="Openbiz Cubi Platform 价格"/>
										<div class="action">
										<a class="gray-button-buy" href="#">获取</a>
										<a class="gray-button-small" href="cubi.php">详情</a>
										</div>
									</td>
									</tr>
								</table>
							</div>
						</td>
						
						<td>
							<div class="related-product-block" >
								<table>
									<tr>
									<td class="preview">
										<a href="framework.php"><img src="framework/image/product-pic-small.png" title="Openbiz Framework"/></a>
									</td>
									<td>
										<h2><a href="framework.php"><img src="framework/image/product-title-small.png" title="Openbiz Framework"/></a></h2>
										<p>企业应用系统动力之源</p>
										
										<img src="framework/image/product-price-small.png" style="padding-top:3px;padding-bottom:3px;" title="Openbiz Framework 价格"/>
										<div class="action">
										<a class="gray-button-buy" href="#">获取</a>
										<a class="gray-button-small" href="framework.php">详情</a>
										</div>
									</td>
									</tr>
								</table>
							</div>
						</td>							
					</tr>
					
					
					<tr>
						<td>
							<div class="related-product-block" >
								<table>
									<tr>
									<td class="preview">
										<a href="appcloud.php"><img style="padding-top:10px" src="appcloud/image/product-pic-small.png" title="Openbiz App Cloud"/></a>
									</td>
									<td>
										<h2 style="padding-top:0px"><a href="appcloud.php"><img src="appcloud/image/product-title-small.png" title="Openbiz App Cloud"/></a></h2>
										<p>最低成本与最小风险体验应用平台</p>
										
										<img src="appcloud/image/product-price-small.png" style="padding-top:3px;padding-bottom:3px;" title="Openbiz App Cloud 价格"/>
										<div class="action">
										<a class="gray-button-buy" href="#">购买</a>
										<a class="gray-button-small" href="appcloud.php">详情</a>
										</div>
									</td>
									</tr>
								</table>
							</div>
						</td>
						
						<td>
							<div class="related-product-block" >
								<table>
									<tr>
									<td class="preview">
										<a href="../hardware/appserver.php"><img style="padding-top:10px"  src="appserver/image/product-pic-small.png" title="Openbiz App Server"/></a>
									</td>
									<td>
										<h2 style="padding-top:0px"><a href="../hardware/appserver.php"><img src="appserver/image/product-title-small.png" title="Openbiz App Server"/></a></h2>
										<p>无需部署,高性价比企业应用服务器</p>
										
										<img src="appserver/image/product-price-small.png" style="padding-top:3px;padding-bottom:3px;" title="Openbiz App Server 价格"/>
										<div class="action">
										<a class="gray-button-buy" href="#">购买</a>
										<a class="gray-button-small" href="../hardware/appserver.php">详情</a>
										</div>
									</td>
									</tr>
								</table>
							</div>
						</td>	
						
						<td>
							<div class="related-product-block" >
								<table>
									<tr>
									<td class="preview">
										<a href="t-shirt.php"><img style="padding-top:10px"  src="t-shirt/image/product-pic-small.png" title="Openbiz T-Shirt"/></a>
									</td>
									<td>
										<h2 style="padding-top:10px" ><a href="t-shirt.php">限量版纪念T-shirt</a></h2>
										<p>Openbiz 10周年纪念版</p>
										
										<img src="t-shirt/image/product-price-small.png" style="padding-top:3px;padding-bottom:3px;" title="Openbiz T-Shirt 价格"/>
										<div class="action">
										<a class="gray-button-buy" href="#">购买</a>
										<a class="gray-button-small" href="t-shirt.php">详情</a>
										</div>
									</td>
									</tr>
								</table>
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