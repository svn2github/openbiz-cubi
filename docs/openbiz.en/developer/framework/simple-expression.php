<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>简单表达式 － Openbiz Framework － <?php echo SITE_NAME;?></title>
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
<link href="style/simple-expression.css" rel="stylesheet" type="text/css" />
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
		<div id="framework-se-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/simpleexpression/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>轻便灵活的内建描述语言
					</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Openbiz特有的轻量级表达式<br/>
                        让元数据对象更加灵活轻便的组织在一起
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
			<h2>元数据简单表达式（Simple Expression）</h2>
			<p>
				Openbiz的元数据不仅可以描述数据间的关系映射，而且能描述数据的有效性校验方法和用户在页面上的交互行为。<br/>
				比如当用户在用户注册表单上点击“提交”按钮时，服务器端需要验证用户输入的是有效的邮件地址。<br/>
				这样的逻辑通常是将用户输入送给邮件地址验证的函数，该函数会返回true或false。那么这种逻辑如何用元数据表达呢？
			</p>
		</div>
		<h4>表达式标签</h4>		
		<p>			
			系统目前支持三种表达式标签
		</p>
		<ul class="three-se">
	      	<li class="blue-dot">{expr}标签对.</li>
	   		<li>Openbiz将执行php的eval方式来解析{}之间的expr表达式字符串</li>
	      	<li class="blue-dot">{fx}expr{/fx}标签对.</li>
	    	<li>这是一个详细版的{}表达式实现。Openbiz 同样将执行php的eval方式来解析{fx}和{/fx}之间的expr表达式字符串。例如{fx}10-1{/fx}将返回结果”9”。</li>
	      	<li class="blue-dot">{tx}expr{/tx}标签对.</li> 
	      	<li>这对标签告诉Openbiz只需要返回字符串本身，而不对其进行处理计算，例如：{tx}10-1{/tx} 将返回字符串 “10-1”。</li>
		</ul>
		<h4>表达式的语法结构</h4>
		<ul class="three-se">
		     <li class="blue-dot">数据类型</li>
		     <li>简单表达式定义了如下几组数据类型:</li>
		     <li>布尔类型: true 或 false</li>
		     <li>整数数字。</li>
		     <li>浮点数。</li>
		     <li>字符串: 单引号和双引号括起来的字符; ” 将被转义为 \”, '将被转义为\', \将被转义为\\.</li>
		     <li>空: null</li>
		     <li class="blue-dot">操作符</li>
		     <li>数学: +, -, *, /, % 和 mod, -(负数)</li>
		     <li>逻辑: and, &amp;&amp;, or, ||, not, !</li>
		     <li>关系: ==, !=, &lt;, &gt;, ⇐, &gt;=.</li>
		     <li>条件: A ? B : C.根据 A 的返回结构执行B或C语句. </li>   
		     <li class="blue-dot">变量</li>
		     <li>简单表达式允许开发人员调用Openbiz元数据对象中的变量</li>
		</ul>
		<table class="se-table">
			<tr>
				<th>调用元数据对象中变量的语法</th>
				<th>描述</th>
				<th>适用范例</th>
			</tr>
			<tr>
				<td>@object_name:property_name</td>
				<td>获取指定对象的指定属性</td>
				<td>@system.do.UserDO:m_Name</td>
			</tr>
			<tr>
				<td class="odd">@object_name:*[child_name].property_name</td>
				<td class="odd">获取指定对象的子元素的指定属性</td>
				<td class="odd">@system.do.UserDO:Field[username].Value</td>
			</tr>
			<tr>
				<td>@:property_name</td>
				<td>获取当前对象的指定属性</td>
				<td>@:m_Name</td>
			</tr>
			<tr>
				<td class="odd">@:*[child_name].property_name</td>
				<td class="odd">获取当前对象的子元素的指定属性</td>
				<td class="odd">@:Field[username].Value</td>
			</tr>
			<tr>
				<td>[field_name]</td>
				<td>从当前数据对象或表单对象中获取指定字段的<br/></>数值</td>
				<td>In UserDO, [Id] means getting the “Id” field value of UserDO.</td>
			</tr>
			<tr>
				<td class="odd">@profile:property_name</td>
				<td class="odd">获取用户档案中的制定属性</td>
				<td class="odd">ProfileService提供	@profile:email</td>
			</tr>
			<tr>
				<td>@service_alias:method(arg1, arg2 …)</td>
				<td>用户档案是由调用注册的插件服务器方法的<br/></>返回值</td>
				<td>@query:FetchField(system.do.UserDO,[email]='abc@gmail.com')</td>
			</tr>
		</table>
		<h4>当前注册插件服务范例：</h4>
		<p>
			@validation – 数据有效性校验服务<br/>
			@query – 数据查询服务<br/>
			如果要注册一个服务, 可以在/cubi/bin/app_init.php 的 $g_ServiceAlias 全局变量中添加该服务名字的注册。<br/>
			扩展对象获取属性<br/>
			开发人员可以通过修改或重载对象的GetProperty()方法来添加更多的属性支持。
		</p>
		<p class="gray-background">public function getProperty($propertyName)</p><br/>
		<p>
			GetProperty() 函数的输入参数既可以是”property_name” 也可以是 “*[child_name]” 或者一些其它的被用户自定义代码支持的参数。
			调用全局变量简单表达式语言业允许开发人员来调用任何PHP所支持的全局变量，关于PHP全局变量请阅读
		</p>		
		<a href="http://us2.php.net/manual/en/reserved.variables.php" target="_blank">http://us2.php.net/manual/en/reserved.variables.php 了解详情</a>
		<p class="se-blue-dot">函数</p>			
		<p>
		    开发人员可以在简单表达式中调用任意PHP函数，如果文件中已经包含了函数的定义，那么即便是用户自定义函数也可以被调用。<br/>
		    例如：如果元数据A是基于用户自定义类的基础上创建的，类的代码文件是A.php，且该文件包含了A_help.inc,<br/>
		    在这种情况下您就可以安全的调用在A_help.inc文件中定义的自定义函数。
		</p>
		<p class="se-blue-dot">范例</p>
		<p>			
    		给数据对象设定查询规则（SearchRule）
		</p>
		<pre class="prettyprint" >    &lt;BizDataObj Name=&quot;FutureActivityDO&quot; SearchRule=&quot;[start]&gt;{date(&#39;Y-m-d&#39;)}&#39;&quot; ...&gt;</pre>
  		<p>给数据对象的字段自动赋值为当前用户的ID</p>
  		<pre class="prettyprint" >    &lt;BizField Name=&quot;create_by&quot;   Column=&quot;create_by&quot;   Type=&quot;Number&quot;  ValueOnCreate=&quot;{@profile:Id}&quot;/&gt;</pre>
  		<p> 给数据对象的字段的值设为另两个字段值的组合</p>
  		<pre class="prettyprint" >    &lt;BizField Name=&quot;fullname&quot; Value=&quot;{[lastname]}, {@:Field[firstname].Value}&quot;/&gt;</pre>
  		<p>给表单对象的控件设置输入验证</p>
  		<pre class="prettyprint" >    &lt;Element Name=&quot;fld_email&quot;   Class=&quot;InputText&quot;  FieldName=&quot;email&quot;  Label=&quot;Email&quot;  Validator=&quot;{@validate:email(&#39;[fld_email]&#39;)}&quot;/&gt;</pre>
		<br/>
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							Openbiz Framework特有的轻量级表达式让元数据对象更加灵活轻便的组织在一起<br/>
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