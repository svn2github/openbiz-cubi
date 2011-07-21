{php}
$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "\n"."
<link rel=\"stylesheet\" href=\"".RESOURCE_PHP."?f=$css_url/general.css,$css_url/system_backend.css,$css_url/system_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

BizSystem::clientProxy()->includeColorPickerScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts .= "
<script type=\"text/javascript\" src=\"".RESOURCE_PHP."?f=$js_url/cookies.js,$theme_js_url/general_ui.js\"></script>
";
$includedScripts.="\n".
"
<script>var \$j = jQuery.noConflict();</script>
<style >
table.input_row label{
	width:120px;
}
table.input_row .label_text label{
	width:120px;
	color:#666666;
	margin-right:0px;
}
</style>
<script>
function change_header_type(value){
	switch(value){
		case 'Text':			
			$('element_set_1').hide();
			$('element_set_2').show();
			break;
		case 'Html':
			$('element_set_2').hide();
			$('element_set_1').show();	
			change_header_html_type();
			break;  
	}
	
}

function change_header_html_type(){
	if($('fld_page_header_html_even_type_CUSTOM')!=undefined){
		if($('fld_page_header_html_even_type_CUSTOM').checked){
			$('fld_page_header_html_even_container').show();
		}else{
			$('fld_page_header_html_even_container').hide();
		}
	}else{
		$('fld_page_header_html_even_type_radio_container').hide();
		if($('fld_page_header_html_even_type_radio_CUSTOM').checked){
			$('fld_page_header_html_even_container').show();
		}else{
			$('fld_page_header_html_even_container').hide();
		}	
	}

}
</script>

";

$this->_tpl_vars['scripts'] = $includedScripts;

$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}