<?xml version="1.0" standalone="no"?>
<PluginService Name="userEmailService" Package="service" Class="userEmailService" 
				BizDataObj="email.do.EmailQueueDO" 
				SendtoQueue="Y" >	   
   			{assign var=item value=$data.PLUGINSERVICE}
   			{if $item.TEMPLATE.ATTRIBUTES.NAME != ""}
   				<Template   Name="{$item.TEMPLATE.ATTRIBUTES.NAME}" 
								Title="{$item.TEMPLATE.ATTRIBUTES.TITLE}" 
								EmailAccount="{$item.TEMPLATE.ATTRIBUTES.EMAILACCOUNT}" 
								Template="{$item.TEMPLATE.ATTRIBUTES.TEMPLATE}" />
   			{else}
	   			{foreach item=template key=templateName from=$item.TEMPLATE }
	   				<Template   Name="{$template.ATTRIBUTES.NAME}" 
								Title="{$template.ATTRIBUTES.TITLE}" 
								EmailAccount="{$template.ATTRIBUTES.EMAILACCOUNT}" 
								Template="{$template.ATTRIBUTES.TEMPLATE}" />
	   			{/foreach}
			{/if}   
</PluginService>