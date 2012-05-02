<?xml version="1.0" standalone="no"?>
<BizDataObj Name="{$do_name}" Description="{$do_desc}" 
			Class="BizDataObj" 
			DBName="{$db_name}" Table="{$table_name}" 
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
{if $fld.name=='timestamp'}
   		<BizField Name="timestamp" Column="timestamp" />   		
{elseif $fld.name=='create_by'}
		<BizField Name="{$fld.name}" Column="{$fld.col}" Type="Number" ValueOnCreate="{literal}{@profile:Id}{/literal}"/>
{elseif $fld.name=='create_time'}
		<BizField Name="{$fld.name}" Column="{$fld.col}"  Type="Datetime" ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
{elseif $fld.name=='update_by'}
		<BizField Name="{$fld.name}" Column="{$fld.col}" Type="Number" ValueOnCreate="{literal}{@profile:Id}{/literal}" ValueOnUpdate="{literal}{@profile:Id}{/literal}"/>		
{elseif $fld.name=='update_time'}
		<BizField Name="{$fld.name}" Column="{$fld.col}" Type="Datetime" ValueOnCreate="{literal}{date('Y-m-d H:i:s')}{/literal}" ValueOnUpdate="{literal}{date('Y-m-d H:i:s')}{/literal}"/>
{else}
        <BizField Name="{$fld.name}" Column="{$fld.col}" {if $fld.length }Length="{$fld.length}"{/if}   {if $fld.name != "Id"}Required="{if $fld.nullable }N{else}Y{/if}"{/if} Type="{$fld.type}"/>
{/if}
{/foreach}
	</BizFieldList>
    <TableJoins>
    </TableJoins>
    <ObjReferences>
    </ObjReferences>
</BizDataObj>