<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Simple Expression - Openbiz Framework - <?php echo SITE_NAME;?></title>
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
					<h2>Simple but Powerful Language
					</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Openbiz lightwieght expression language<br/>
                        Add flexibility to metadata
					</p>									
						<p style="width:100px;padding-top:15px;">
							<a class="blue-button-go" href="#" >Download</a>
						</p>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<div>
			<h2>Simple Expression</h2>
			<p>
				Openbiz Metadata not only describes the mapping and relationship, it can also describe data validation and user interaction on a page.<br/>
				For example, when a user clicks submit button on a user registration form, the server side needs to check the email address is a valid one.<br/>
				How do we add such logic in metadata?
			</p>
		</div>
		<h3>Expression Tags</h3>		
		<p>			
			Three expression tags are supported. 
		</p>
		<ul class="three-se">
	      	<li class="blue-dot">{expr} pairs. Openbiz will do php eval on the expr string between { and }</li>
	      	<li class="blue-dot">{fx}expr{/fx} pairs. This is the verbose version of {} pairs. Openbiz will do php eval on the expr string between {fx} and {/fx}. Example, {fx}10-1{/fx} returns "9".</li>
	      	<li class="blue-dot"> {tx}expr{/tx} pairs. This pair tells Openbiz simply returns the strings without calling eval. Example, {tx}10-1{/tx} returns "10-1".</li>
		</ul>
		<br/>
		<h3>Expression Syntax</h3>

		 <h4><b>Literals</b></h4>
		 <p>The simple expression language defines the following literals:</p>
		 <ul style="padding-left:20px">
			 <li>Boolean: true and false</li>
			 <li>Integer</li>
			 <li>Float</li>
			 <li>String: with single and double quotes; " is escaped as \", ' is escaped as \', and \ is escaped as \\.</li>
			 <li>Null</li>
		 </ul>
		 <h4><b>Operators</b></h4>
		 <ul style="padding-left:20px">
			 <li>Arithmetic: +, - (binary), *, / and div, % and mod, - (unary)</li>
			 <li>Logic: and, &amp;&amp;, or, ||, not, !</li>
			 <li>Relational: ==, !=, &lt;, &gt;, ⇐, &gt;=.</li>
			 <li>Conditional: A ? B : C. Evaluate B or C, depending on the result of the evaluation of A </li>  
		 </ul>
		 <h4><b>Variables</b></h4>
		 <p>Simple expression allows developers to use variables of openbiz metadata objects</p>

		<table class="se-table" style="padding-top:0px">
			<tr>
				<th>Syntax to get metadata object variables</th>
				<th>Description</th>
				<th>Sample usage</th>
			</tr>
			<tr>
				<td>@object_name:property_name</td>
				<td>get the given property of the given object.</td>
				<td>@system.do.UserDO:m_Name</td>
			</tr>
			<tr>
				<td class="odd">@object_name:*[child_name].property_name</td>
				<td class="odd">get the given property of the given object's child element</td>
				<td class="odd">@system.do.UserDO:Field[username].Value</td>
			</tr>
			<tr>
				<td>@:property_name</td>
				<td>get the given property of this object ("this" object is the object defined in the metadata file)</td>
				<td>@:m_Name</td>
			</tr>
			<tr>
				<td class="odd">@:*[child_name].property_name</td>
				<td class="odd">get the given property of this object's child element</td>
				<td class="odd">@:Field[username].Value</td>
			</tr>
			<tr>
				<td>[field_name]</td>
				<td>get the value of a given Field of its DO or Element of its Form</td>
				<td>In UserDO, [Id] means getting the “Id” field value of UserDO.</td>
			</tr>
			<tr>
				<td class="odd">@profile:property_name</td>
				<td class="odd">get the user profile property. User profile is provided with ProfileService.</td>
				<td class="odd">ProfileService @profile:email</td>
			</tr>
			<tr>
				<td>@service_alias:method(arg1, arg2 …)</td>
				<td>invoke the registered plugin service method and get the returned value. </td>
				<td>@query:FetchField(system.do.UserDO,[email]='abc@gmail.com')</td>
			</tr>
		</table>
		<h4>Plugin Service Samples</h4>
		<p>
			@validation – Data Validation service<br/>
			@query – Data Query service<br/>
			Currently registered plugin services are @validation - validation service @query - query service. To register a service, $g_ServiceAlias can be defined as a global variable.
		</p>
		<h4>Implement GetProperty() </h4>
		<p>
			As implied from the implementation, developers can add more property support by modifying/overriding GetProperty() method. The input of GetProperty() can be either "property_name" or "*[child_name]" or something new that supported by customer code.
		</p>
		<p class="gray-background">public function getProperty($propertyName)</p><br/>
		<h4>Use PHP Vairables</h4>
		<p>
			Simple expression language also allows developers to use any global variables supported by PHP. Please read <a href="http://us2.php.net/manual/en/reserved.variables.php" target="_blank">http://us2.php.net/manual/en/reserved.variables.php </a>for details
		</p>		

		<h4><b>Functions</b></h4>			
		<p>
		   Developers can invoke any PHP functions in simple expression. A user defined functions can be invoked if the file that contains such function is included. For example, if the metadata object A is based on a customer class, the class file is A.php that includes another A_help.inc. In this case, you can invoke functions defined in A_help.inc in simple expression.
		</p>
		<p class="se-blue-dot">Examples</p>
		<p>			
    		Set SearchRule in Data Object 
		</p>
		<pre class="prettyprint" >    &lt;BizDataObj Name=&quot;FutureActivityDO&quot; SearchRule=&quot;[start]&gt;{date(&#39;Y-m-d&#39;)}&#39;&quot; ...&gt;</pre>
  		<p>Use current user ID</p>
  		<pre class="prettyprint" >    &lt;BizField Name=&quot;create_by&quot;   Column=&quot;create_by&quot;   Type=&quot;Number&quot;  ValueOnCreate=&quot;{@profile:Id}&quot;/&gt;</pre>
  		<p> Combine 2 field values</p>
  		<pre class="prettyprint" >    &lt;BizField Name=&quot;fullname&quot; Value=&quot;{[lastname]}, {@:Field[firstname].Value}&quot;/&gt;</pre>
  		<p>Set validation rule for a form input</p>
  		<pre class="prettyprint" >    &lt;Element Name=&quot;fld_email&quot;   Class=&quot;InputText&quot;  FieldName=&quot;email&quot;  Label=&quot;Email&quot;  Validator=&quot;{@validate:email(&#39;[fld_email]&#39;)}&quot;/&gt;</pre>
		<br/>
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td>
						<p>
							Download Openbiz Framework today to enjoy the flexibility of expression in metadata.
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