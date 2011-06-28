<div style="padding-left:20px;">
<a href="javascript:"><img style="margin-top:6px;" border="0" src="{$image_url}/nav_root_icon.gif" />{t}Cubi System{/t}</a>
	{foreach item=item from=$widget.breadcrumb}
		{if $item->m_URL !=""}
		<a href="{$item->m_URL}">
		{else}
		<a href="javascript:">
		{/if}
		<img class="icon_dot" border="0" src="{$image_url}/spacer.gif" />{$item->m_Name}</a>	    
	{/foreach}
</div>