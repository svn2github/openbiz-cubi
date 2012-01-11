<?xml version="1.0" standalone="no"?>
<PluginService Name="emailService" Package="service" Class="emailService">
   <Accounts>  
   			{assign var=item value=$data.PLUGINSERVICE.ACCOUNTS}
   			{if $item.ACCOUNT.ATTRIBUTES.NAME != ""}
   				<Account Name="{$item.ACCOUNT.ATTRIBUTES.NAME}" Host="{$item.ACCOUNT.ATTRIBUTES.HOST}" FromName="{$item.ACCOUNT.ATTRIBUTES.FROMNAME}" FromEmail="{$item.ACCOUNT.ATTRIBUTES.FROMEMAIL}" IsSMTP="Y" SMTPAuth="{$item.ACCOUNT.ATTRIBUTES.SMTPAUTH}" Port="{$item.ACCOUNT.ATTRIBUTES.PORT}" Username="{$item.ACCOUNT.ATTRIBUTES.USERNAME}" Password="{$item.ACCOUNT.ATTRIBUTES.PASSWORD}" />
   			{else}
	   			{foreach item=account key=accountName from=$item.ACCOUNT }
	   				<Account Name="{$account.ATTRIBUTES.NAME}" Host="{$account.ATTRIBUTES.HOST}" FromName="{$account.ATTRIBUTES.FROMNAME}" FromEmail="{$account.ATTRIBUTES.FROMEMAIL}" IsSMTP="Y" SMTPAuth="{$account.ATTRIBUTES.SMTPAUTH}" Port="{$account.ATTRIBUTES.PORT}" Username="{$account.ATTRIBUTES.USERNAME}" Password="{$account.ATTRIBUTES.PASSWORD}" />
	   			{/foreach}
			{/if}
   </Accounts>  
   <Logging Type="DB" Object="email.do.EmailLogDO" Enabled="Y" />
</PluginService>