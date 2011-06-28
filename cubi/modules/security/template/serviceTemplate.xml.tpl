<?xml version="1.0" standalone="no"?>
<PluginService Name="{$data.PLUGINSERVICE.ATTRIBUTES.NAME}" Package="{$data.PLUGINSERVICE.ATTRIBUTES.PACKAGE}" Class="{$data.PLUGINSERVICE.ATTRIBUTES.CLASS}">
   <Security Mode="{$data.PLUGINSERVICE.SECURITY.ATTRIBUTES.MODE}">
   {foreach item=item key=itemName from=$data.PLUGINSERVICE.SECURITY }
   		{if $itemName != 'ATTRIBUTES'}
   		<{$itemName} Mode="{$item.ATTRIBUTES.MODE}" >
   			{if $item.RULE.ATTRIBUTES.NAME != ""}
   				<Rule Name="{$item.RULE.ATTRIBUTES.NAME}" Action="{$item.RULE.ATTRIBUTES.ACTION}" Match="{$item.RULE.ATTRIBUTES.MATCH}" EffectiveTime="{$item.RULE.ATTRIBUTES.EFFECTIVETIME}" Status="{$rule.ATTRIBUTES.STATUS}" />
   			{else}
	   			{foreach item=rule key=ruleName from=$item.RULE }
	   				<Rule Name="{$rule.ATTRIBUTES.NAME}" Action="{$rule.ATTRIBUTES.ACTION}" Match="{$rule.ATTRIBUTES.MATCH}" EffectiveTime="{$rule.ATTRIBUTES.EFFECTIVETIME}" Status="{$rule.ATTRIBUTES.STATUS}" />
	   			{/foreach}
			{/if}
   		</{$itemName}>
   		{/if}
   {/foreach}
   </Security>
</PluginService>