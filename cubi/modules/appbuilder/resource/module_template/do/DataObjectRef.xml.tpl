<?xml version="1.0" standalone="no"?>
<BizDataObj Name="{$do_name}" 
		Description="{$do_desc}" 
		DataPermControl="{$do_perm_control}"
		Class="BizDataObj" 
		DBName="{$db_name}" 
		Table="{$table_name}" 
		SearchRule="" 
		SortRule="{if $sort_field}[{$sort_field}] ASC{/if}" 
		OtherSQLRule=""
		Uniqueness="{$uniqueness}" 
		Stateless="N" 
		IdGeneration="Identity" 
		CacheLifeTime="0" 
		CreateCondition="{$acl.create}" 
		UpdateCondition="{$acl.update}" 
		DeleteCondition="{$acl.delete}" >
	<BizFieldList>
{foreach from=$fields item=fld}
{if $fld.Field=='timestamp'}
   		<BizField Name="{$fld.Field}"	
	   			Description="{$fld.Description}"	
	   			Column="timestamp" />
{elseif $fld.Field=='create_by'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				Type="Number"	
				ValueOnCreate="{literal}{@profile:Id}{/literal}"/>
{elseif $fld.Field=='create_time'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				Type="Datetime"	
				ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
{elseif $fld.Field=='update_by'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				Type="Number"	
				ValueOnCreate="{literal}{@profile:Id}{/literal}"	
				ValueOnUpdate="{literal}{@profile:Id}{/literal}"/>
{elseif $fld.Field=='update_time'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				Type="Datetime"	
				ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}"	
				ValueOnUpdate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
{elseif $fld.Field=='owner_id'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				ValueOnCreate="{literal}{@profile:Id}{/literal}"	
				Required="N"	
				Type="Number"/>
{elseif $fld.Field=='group_id'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				ValueOnCreate="{literal}{@profile:default_group}{/literal}"	
				Required="N"	
				Type="Number"/>
{elseif $fld.Field=='group_perm'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				ValueOnCreate="{literal}{BizSystem::GetDefaultPerm(group)}{/literal}"	
				Required="N"	
				Type="Number"/>
{elseif $fld.Field=='other_perm'}
		<BizField Name="{$fld.Field}"	
				Description="{$fld.Description}"	
				Column="{$fld.Field}"	
				ValueOnCreate="{literal}{BizSystem::GetDefaultPerm(other)}{/literal}"	
				Required="N"	
				Type="Number"/>
{elseif $fld.Field=='id'}
		<BizField Name="Id"			
				Description="{$fld.Description}"	
				Column="id"    
				Required="N" 
				Type="Number"/>
{else}
		<BizField Name="{$fld.Field}"		
				Description="{$fld.Description}"	
				Column="{$fld.Field}" 
				Type="{$fld.FieldType}"
				{if $fld.name != "Id"}Required="{if $fld.Null }N{else}Y{/if}"{/if} 
				{if $fld.length }Length="{$fld.length}"{/if} />
{/if}
{/foreach}
	</BizFieldList>
	<TableJoins>
	</TableJoins>
	<ObjReferences>
	</ObjReferences>
</BizDataObj>