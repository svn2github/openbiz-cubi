<form id="{$form.name}" name="{$form.name}">

<div style="padding-left:25px; padding-right:40px;">
{include file="system_appbuilder_btn.tpl.html"}
	
	<table><tr><td>
		{if $form.icon !='' }
		<div class="form_icon"><img  src="{$image_url}/{$form.icon}" border="0" /></div>
		{/if}
	
		<div style="float:left; width:600px;">
			<h2>
			{$form.title}
			</h2> 
			{if $form.description}
			<p class="input_row" style="line-height:20px;padding-bottom:20px;">		
			<span>{$form.description}</span>
			</p>
			{else}
			<div style="height:15px;"></div>
			{/if}
		</div>
	</td></tr></table>
	
	<div style="padding-left:30px;" >
	{assign var=es_counter value=0}
	{foreach item=setname name=elemsets  from=$form.elementSets}
		{if $smarty.foreach.elemsets.first}
		<div id="element_set_{$es_counter}" class="underline upline">
		{else}
		<div id="element_set_{$es_counter}" class="underline">
		{/if}
		<h2>{$setname}</h2>
		{foreach item=item key=itemName from=$dataPanel}
			{if $item.elementset eq $setname}
			{if $item.type eq 'CKEditor' or $item.type eq 'RichText' 
				or $item.type eq 'Textarea' or $item.type eq 'LabelTextarea'
				or $item.type eq 'LabelTextarea' or $item.type eq 'LabelImage'
				 or $item.type eq 'RawData'
			}
				<table  id="{$itemName}_container" class="input_row">
				<tr>
				<td style="width:80px;">	
					<label style="text-align:left">{$item.label}</label>
				</td>
				<td>
					{if $errors.$itemName}
					<span class="input_error_msg" style="width:240px;">{$errors.$itemName}</span>
					{elseif $item.description}
					<span class="input_desc" style="width:240px;">{$item.description}</span>			
					{/if}
				</td>
				</tr>
				<tr><td colspan="2" align="center" >
					<span class="label_textarea" style="{if $default_label_textarea_width}{$default_label_textarea_width}{else}width:655px;{/if}">{$item.element}</span>
								
				</td></tr>
				</table>		
			{else}
				{if $item.type eq 'Hidden' }
				<table  id="{$itemName}_container" class="input_row" style="display:none">
				{else}
				<table  id="{$itemName}_container" class="input_row">
				{/if}					
				<tr>
				<td >	
					<label style="text-align:left">{$item.label}</label>
				</td>
				<td>
					{if $itemName eq 'fld_url' }
					<span class="label_text" style="float:left;width:210px;">{$item.element}</span>
					{else}
					<span class="label_text" style="float:left;width:450px;">{$item.element}</span>
					{/if}
					{if $errors.$itemName}
					<span class="input_error_msg" style="width:240px;">{$errors.$itemName}</span>
					{elseif $item.description}
					<span class="input_desc" style="width:240px;">{$item.description}</span>			
					{/if}
				</td>
				</tr>
				</table>
			{/if}			
			{/if}
		{/foreach}
		</div>
	{assign var=es_counter value=$es_counter+1}			
	{/foreach}
		<div style="height:10px;"></div>
	 
		<p class="input_row">
			
			{foreach item=elem from=$actionPanel}
				{$elem.element}
			{/foreach}
		</p>

	{if $errors}
	    <div id='errorsDiv' class='innerError errorBox'>
	    {foreach item=errMsg from=$errors}
	        <div>{$errMsg}</div>
	    {/foreach}
	    {literal}<script>setTimeout("$('errorsDiv').fade( {from: 1, to: 0});",3000);</script>{/literal}
	    </div>
	{/if}
	
	{if $notices}
	    <div id='noticeDiv' class='noticeBox' >
	    {foreach item=noticeMsg from=$notices}
	        <div>{$noticeMsg}</div>
	    {/foreach}
	    </div>
	    {literal}<script>setTimeout("$('noticeDiv').fade( {from: 1, to: 0});",3000);</script>{/literal}
	{/if}

	</div>
	
		<div style="height:15px;">
		<div id='{$form.name}.load_disp' style="display:none;">
		<img  src="{$image_url}/form_ajax_loader.gif"/>
		</div>
		</div>
	
</div>

</form>