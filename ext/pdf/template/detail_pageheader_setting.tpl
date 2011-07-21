{php}
$this->assign('template_file', 'system_right_detailform_elementset.tpl.html');
$this->assign('default_label_text_width', 'width:450px;');
$this->assign('default_label_textarea_width', 'width:655px;');
{/php}
{include file=$template_file}
<script>
{literal}
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
if($('fld_page_header_type_Html')!=undefined){
	if($('fld_page_header_type_Html').checked){
		change_header_type('Html');
	}else{
		change_header_type('Text');
	}
}else{
	$('fld_page_header_type_radio_container').hide();
	if($('fld_page_header_type_radio_Html').checked){
		change_header_type('Html');
	}else{
		change_header_type('Text');
	}	
}
{/literal}
</script>