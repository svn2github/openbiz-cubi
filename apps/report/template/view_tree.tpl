{php}
$header_background_image='/report/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

BizSystem::clientProxy()->includeCKEditorScripts();
$this->assign('system_loader', 		'system_loader.tpl.html');
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n".'
<script type="text/javascript" src="'.$this->_tpl_vars['js_url'].'/FusionCharts/FusionCharts.js"></script>
<script type="text/javascript" >focusSelectRecord=true;</script>
';
$this->_tpl_vars['scripts'] = $includedScripts;
$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['scripts'] = $includedScripts;
$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
{/php}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<meta name="description" content="{$description}"/>
<meta name="keywords" content="{$keywords}"/>
<link rel="stylesheet" href="{$css_url}/general.css" type="text/css" />
<link rel="stylesheet" href="{$css_url}/system_backend.css" type="text/css" />
<link rel="stylesheet" href="{$css_url}/system_backend_tabs.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$js_url}/jstree.css" />
<link rel="stylesheet" type="text/css" href="{$js_url}/jstree/tree_component.css" />
{$style_sheets}
{$scripts}
<script type="text/javascript" src="{$js_url}/jstree/_lib.js"></script>
<script type="text/javascript" src="{$js_url}/jstree/tree_component.js"></script>
<script type="text/javascript" src="{$theme_js_url}/general_ui.js"></script>
<script type="text/javascript" src="{$js_url}/cookies.js"></script>

</head>

<body>
<script>var $j = jQuery.noConflict();</script>

{assign var='folderTree' value='report.folder.form.FolderTree'}

<div align="center" id="body_warp">
	<div id="header_warp">
	{include file='system_header.tpl.html'}
	</div>
	<!--main warp-->
	<div id="main_warp">	
		<!--main-->
		<div id="main" >
			{include file=$system_loader}
				<table id="main_content" border="0" cellpadding="0" cellspacing="0">
					<tr><td><img src="{$image_url}/spacer.gif" style="height:15px;" /></td></tr>
					<tr>
						<td valign="top" style="width:18px;"><img src="{$image_url}/spacer.gif" style="width:18px;" /></td>
						<td valign="top" id="left_panel">
						{$forms.$folderTree}
						</td>
						<td valign="top" id="right_panel">
							<!-- right block start -->
							<div class="content_block">
								<div class="header"></div>
								<div class="content">	
									<div>
													
									{foreach key=formname item=form from=$forms}
									    {if $formname != $folderTree}
							         	<div>
							         	{$form}
							         	</div>
							         	{/if}
								    {/foreach}
								    	
									</div>									
								</div>
								<div class="footer"></div>														
							</div>
							<!-- right block end -->
						</td>
					</tr>
			  </table>		  
			</div>
			<!--main-->
		
		</div>		
		<!--main wrap end-->
		<!--footer-->
		<div  id="footer_warp">			
 		{include file='system_footer.tpl.html'}
		</div>
		<!-- footer end -->
	
	</div>
</div>

</body>
</html>