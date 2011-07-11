<form id='{$form.name}' name='{$form.name}'>
<div style="padding-left:25px;padding-right:40px;">
	<div>
	{if $form.icon !='' }
	<div class="form_icon"><img  src="{$image_url}/{$form.icon}" border="0" /></div>
	{/if}
	<h2>
	{$form.title}
	</h2> 
	{if $form.description !='' }
	<p class="form_desc">{$form.description}</p>
	{/if}
	</div>
	
<!-- table start -->
<div style="margin-left:15px; margin-bottom:10px">
{foreach item=row from=$dataPanel.data}
	<div style="font-weight:bold;border-bottom:1px solid #BBB;width:90%">
	Change by {$row.fld_author} on {$row.fld_time}
	</div>
	{foreach item=fld key=fldname from=$row.fld_comments}
		{if $fldname != 'comment'}
		<li style="margin-left:15px;"><b>{$fldname|capitalize}</b> changed from <i>{$fld.old}</i> to <i>{$fld.new}</i></li>
		{/if}
	{/foreach} 
	<p style="margin-left:15px;margin-bottom:5px;">{$row.fld_comments.comment}</p>
{/foreach}
</div>  

	<div>
		<div class="action_panel">
{foreach item=elem from=$actionPanel}
    	{$elem.element}
{/foreach}
		</div>

		<div class="ajax_indicator">
			<div id='{$form.name}.load_disp' style="display:none" >
				<img src="{$image_url}/form_ajax_loader.gif"/>
			</div>
		</div>	
	</div>
	<div class="v_spacer"></div>
</div>
</form>