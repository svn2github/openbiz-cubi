{literal}
<style type="text/css">
.fld_help_content {font-size: 14px; padding: 10px;}
.fld_help_content ul { padding-left:20px; }
.fld_help_content p { padding-bottom:10px; }
</style>
{/literal}
<div style="margin:20px;">
<form id="{$form.name}" name="{$form.name}">

<div style="padding-left:25px; ">

	<div>
		<div style="padding-bottom: 10px"><h2>{$dataPanel.fld_title.element}</h2></div>
		<div class="fld_content">
			<div class="label_text"><b>{$dataPanel.fld_description.element}</b></div>
		</div>
		<div class="fld_help_content">
			<div class="label_text">{$dataPanel.fld_help_content.element}</div>
		</div>
	</div>
		
	<div style="height:10px;"></div>
	<p class="input_row">
		
		{foreach item=elem from=$actionPanel}
			{$elem.element}
		{/foreach}
	</p>
	
</div>

</form>
</div>