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
<ul style="margin-left:30px; margin-bottom:10px">
{foreach item=row from=$dataPanel.data}
	<li style="margin:3px;">
	{$row.fld_filename} ({$row.fld_size} bytes) uploaded by {$row.fld_author} on {$row.fld_time}.
	<p><i>{$row.fld_description}</i></p>
	</li>     
{/foreach}
</ul>  

	<div>	
		<div class="action_panel">
{foreach item=elem from=$actionPanel}
    	{$elem.element}
{/foreach}
		</div>
	
	</div>
	<div class="v_spacer" style="clear:both"></div>
</div>

</form>
