{php}
$this->assign('template_file', 'system_right_detailform_elementset.tpl.html');
$this->assign('default_label_text_width', 'width:450px;');
{/php}
{include file=$template_file}
<script>
{literal}
if($('fld_watermark_type_Text')!=undefined){
	if($('fld_watermark_type_Text').checked){
		change_type('Text');
	}else{
		change_type('Picture');
	}
}else{
	$('fld_watermark_type_radio_container').hide();
	if($('fld_watermark_type_radio_Text').checked){
		change_type('Text');
	}else{
		change_type('Picture');
	}	
}
{/literal}
</script>