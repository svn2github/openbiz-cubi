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

    {foreach item=row from=$dataPanel.data}
    <table style="margin-left:10px; margin-bottom:5px">
    <tr>
	<td valign="top">{$row.fld_icon}</td>
    <td valign="top">{$row.fld_title} ({$row.fld_filename}, {$row.fld_filesize} bytes) 
    <p>uploaded by {$row.fld_create_by} on {$row.fld_create_time}.</p>
	<p><i>{$row.fld_description}</i></p>
    </td>
	</tr>
    </table>
    {/foreach}
  
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
