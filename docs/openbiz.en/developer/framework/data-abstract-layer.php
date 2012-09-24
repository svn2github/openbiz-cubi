<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>数据抽象层 － Openbiz Framework － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>

<!-- code prettify -->
<script src="../../general/js/codeprettify/prettify.js" type="text/javascript"  ></script>
<link href="../../general/js/codeprettify/prettify.css" rel="stylesheet" type="text/css" />

<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/data-abstract-layer.css" rel="stylesheet" type="text/css" />
<script src="js/navigation.js" type="text/javascript" ></script>

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
		<div id="framework-dalayer-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/dalayer/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>处理数据底层映射逻辑关系</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						通过元数据的方式描述数据表<br/>
						到对象的关系映射
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
			<h2>数据抽象层</h2>
			<p>
				Openbiz 数据对象可以通过Zend_DB来连接各种类型的关系型数据库，Zend_DB为Openbiz底层提供了在PDO和本地数据库客户端工具之上的数据抽象层。
				开发人员可以使用Openbiz数据对象API来实现大部分的数据库操作，或直接调用Zend_DB API来完成高级功能。
				如果需要连接不同类型的数据库，用户只需要在应用程序根目录的application.xml中指定数据库连接即可。
				Openbiz 数据对象将调用正确的数据库驱动程序去连接数据库服务器。Openbiz当前支持的数据库类型有MySQL, MSSQL, Oracle, PostgreSQL, SQLlite 等。
				每个Openbiz数据对象可以有它自己的数据库引用。此功能可以帮助您实现在一个应用程序中同时连接多个数据库。甚至在同一张网页上也可以连接多个数据源。
			</p>			
		</div>		
		<div class="page-splitter"></div>
		<div class="dalayer-list" style="padding-top: 10px;padding-bottom:10px;">
			<h2>对象关系映射</h2>
			<p>
				Openbiz 实现了必要的“对象关系映射”功能，允许将数据库中的数据和关系映射的数据对象上。Openbiz的数据对象的核心类称为“BizDataObj”。该类的元数据定义了数据表和对象的映射。它能够通过其元数据来生成相应的SQL，实现了查询、保存、删除、读取对象的功能。
				以下列表是Openbiz对象关系映射所实现的功能。
			</p>
			<h4>灵活的映射</h4>
			<ul class="three-se">				
			     <li>支持数据表与对象映射，如：单数据表和一个对象，多数据表和一个对象的映射方式。</li>
			     <li>支持关系映射，多对一，一对多，多对多，一对一、自我相关引用模式。</li>			
			</ul>
			<h4>查询工具</h4>
			<ul class="three-se">
			     <li>支持类 SQL 查询语言</li>
			     <li>支持 SQL 函数和操作符</li>
			     <li>支持 SQL 统计功能</li>
			     <li>支持 group by, having 和 order by</li>
     		</ul>
			<h4>元数据工具</h4>
			<ul class="three-se">
		     	<li>Openbiz用BizDataObj的元数据（XML）来描述映射关系。</li>
		    </ul>
			<h4>对持久类对象进行CRUD操作的API</h4>
			<ul class="three-se">
		     	<li>Openbiz的BizDataObj类提供了丰富的数据查询、保存、删除、读取的API。</li>
			</ul>
		</div>
		<div class="page-splitter"></div>
		<h2>数据对象API</h2>
			<p>
				Openbiz数据对象为增删读改(CURD)操作提供了直观的高级API。
				为了帮助开发人员避免直接编写复杂的SQL语句，Openbiz建议使用Openbiz支持的查询语言。
				更多详情 ＝》 
			</p>
			<a href="http://docs.openbiz.cn/cn/openbiz-book/openbizdo" target="_blank" style="padding-bottom:20px;display:block;">http://docs.openbiz.cn/cn/openbiz-book/openbizdo</a>			
		<div class="page-splitter"></div>
		<div style="padding-bottom: 20px;">
			<h2>数据字段默认值</h2>
			<p>
				有时人们希望在创建或更新的时候自动设置某些列的值，例如，当一个记录被创建时，
				我们系统设置当前的时间给”create_time”列，同样当这条记录被更新时，
				我们也希望设置当前的系统时间给”update_time”列。Openbiz的数据对象的字段元数据表属性将会帮您解决此类问题。 
				* ValueOnCreate 可以在记录被创建时提供默认值 * ValueOnUpdate 可以在记录被更新时提供默认值
			</p>			
		</div>
		<div class="page-splitter"></div>
		<h2>数据对象触发器(DO Trigger)</h2>
		<p>
			当数据对象执行创建、更新、删除操作的时候，Openbiz数据对象触发器服务将提供一个“钩子”来触发自定义的行为。
			一旦触发器在数据对象的元数据中被定义，它将在数据对象的行为成功完成后被立即执行。
			数据对象触发器有两部分组成，触发事件和被触发的行为。这些信息都在触发器服务的元数据文件中被定义。
			当用户通过数据对象来创建、更新、删除一条记录时，Openbiz将在同一目录下查找以这个数据对象名为前缀数据对象触发器定义文件，
			即 DOName_trigger.xml 。例如EventDO的触发器元数据文件就是在同一个目录下的文件 EventDO_trigger.xml。    
		</p>
		<div class="page-splitter"></div>
		<div class="dalayer-list" style="padding-top: 10px;padding-bottom:10px;">
			<h2>数据有效性校验</h2>
			<p>
				数据有效性校验可以在数据对象的元数据中被设定。它主要用于检测当数据记录被创建或更新时所输入的数据。
				针对数据对象字段的有效性校验包括了 
			</p>
			<ul class="three-se">				
			     <li>唯一性校验</li>
			     <li>必要性校验</li>
			     <li>校验表达式</li>			
			</ul>
			<p>如果校验失败，数据对象将会抛出一个异常给它的调用者。 </p>
		</div>
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							Openbiz Framework数据抽象层，通过元数据的方式描述数据表到对象的关系映射。<br/>
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