{literal}
<style type="text/css">
.fld_content {font-size: 14px; padding: 10px;}
.fld_content ul, li { padding-left:20px; }
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
		<div class="fld_content">
			<div class="label_text">{$dataPanel.fld_content.element}</div>
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