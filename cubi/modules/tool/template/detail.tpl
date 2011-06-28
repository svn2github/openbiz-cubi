<form id={$form.name} name={$form.name} style="padding-left:10px;">
<table width=100% cellspacing=0 cellpadding=0>
<tr>
<td align=left>
   <table cellspacing=2 cellpadding=0>
   <tr>
   {foreach item=elem from=$actionPanel}
     <td>{$elem.element}</td>
   {/foreach}
   <td>
	   <div id='{$form.name}.load_disp' style="display:none">
	   <img  src="{$image_url}/form_ajax_loader.gif"/>
	   </div>
   </td>
   </tr>
   </table>
</td>
</table>
<hr/>
{if $form.elementSets}
{foreach item=setname  from=$form.elementSets}
	{if $setname != '_default_set'}
	<fieldset>
	  <legend>{$setname}</legend>
	{/if}
	<table class="input_row" width="100%" cellspacing="3" cellpadding="2" border="0">
	{foreach item=item key=itemName from=$dataPanel}
		{if $item.elementset eq $setname}
			<tr>
			<td width="120" nowrap="">
			<label style="font-size:12px; width:100%">{$item.label}</label>
			</td>
			<td>
			<div>{$item.element}</div>
			{if $item.description}
				<div style="clear:both;font-size:10px">{$item.description}</div>			
			{/if}
			</td>
			</tr>
		{/if}
	{/foreach}
	</table>
	{if $setname != '_default_set'}
	</fieldset>
	{/if}
{/foreach}
{else}
    <table class="input_row" width="100%" cellspacing="3" cellpadding="2" border="0">
	{foreach item=item key=itemName from=$dataPanel}
		{if $item.elementset eq $setname}
			<tr>
			<td width="120" nowrap="">
			<label style="font-size:12px; width:100%">{$item.label}</label>
			</td>
			<td>
			<div>{$item.element}</div>
			{if $item.description}
				<div style="clear:both;font-size:10px">{$item.description}</div>			
			{/if}
			</td>
			</tr>
		{/if}
	{/foreach}
	</table>
{/if}

<input type='hidden' id='{$form.name}_selectedId' name='_selectedId' value='{$dataPanel.ids[0]}'/>
</form>