{php}
$header_background_image='/report/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);


BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$this->_tpl_vars['scripts'] = $includedScripts;
$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
//$left_menu = "menu.widget.MainLeftReportMenu";
//$this->assign('left_menu', $left_menu);
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
<link rel="stylesheet" href="{$css_url}/system_menu_icons.css" type="text/css" />
<link rel="stylesheet" href="{$css_url}/collaboration_menu_icons.css" type="text/css" />
<link rel="stylesheet" href="{$css_url}/system_dashboard_icons.css" type="text/css" />
<link rel="stylesheet" href="{$css_url}/appbuilder.css" type="text/css" />
{$style_sheets}
{$scripts}
<script type="text/javascript" src="{$js_url}/cookies.js"></script>
<script type="text/javascript" src="{$theme_js_url}/general_ui.js"></script>

</head>

<body>
<div align="center" id="body_warp">
	<div id="header_warp">
	{include file='system_header.tpl.html'}
	</div>
	<!--main warp-->
	<div id="main_warp">	
		<!--main-->
		<div id="main" >
			{include file='system_loader.tpl.html'}
			<table id="main_content" border="0" cellpadding="0" cellspacing="0">
				<tr><td><img src="{$image_url}/spacer.gif" style="height:15px;" /></td></tr>
				<tr>
					<td valign="top" style="width:18px;"><img src="{$image_url}/spacer.gif" style="width:18px;" /></td>
					<td valign="top" id="left_panel">
						{include file='system_left_panel.tpl.html'}
					</td>
					<td valign="top" id="right_panel" style="width:720px">
						<!-- right block start -->
                		<div class="content_block">
                    		<div class="header"></div>
                    		{assign var='dbform' value='report.admin.form.ReportDbListForm'}
                    		{assign var='doform' value='report.admin.form.ReportDoListForm'}
                    		{assign var='fieldform' value='report.admin.form.ReportDoFieldListForm'}
                    		<div class="content">	
                    		    <table style="width:720px">
                    		    <tr>
                    		    <td valign="top">{$forms.$dbform}</td>
                    		    <td valign="top">{$forms.$doform}</td>
                    		    </tr>
                    		    <tr>
                    		    <td valign="top" colspan="2">{$forms.$fieldform}</td>
                    		    </tr>
                    		    </table>
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

{literal}
<script>
$('main_loader_bg').style.height = $('main_content').offsetHeight+'px';
</script>
{/literal}
</body>
</html>