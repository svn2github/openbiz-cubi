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
{if $features.extend eq 1}	
		<BizField Name="type_color" 
				Column="color"  
				Join="JoinType" />
	    <BizField Name="type_name" 
	    		Column="name" 
	    		Join="JoinType" />
{/if}
	</BizFieldList>
	<TableJoins>
{if $features.extend eq 1}
		<Join Name="JoinType" 
				Table="{$table_name}_type" 
				Column="id" 
				ColumnRef="type_id" 
				JoinType="LEFT JOIN" />
{/if}				    	
	</TableJoins>
	<ObjReferences>
{if $features.changelog eq 1}	
		<Object Name="changelog.do.ChangeLogDO" 
				Description="Reference to Change Log Records" 
				Relationship="1-M" 
				Table="changelog" 
				CondColumn='type' 
				CondValue='{$table_name}' 
				Column="foreign_id" 
				FieldRef="Id" />{/if}
{if $features.location eq 1}	
		<Object Name="location.do.LocationDO" 
				Description="Reference to Geographic Location Records" 
				Relationship="1-M" 
				Table="location" 
				CondColumn='type' 
				CondValue='{$table_name}' 
				Column="foreign_id" 
				FieldRef="Id" />{/if}
{if $features.attachment eq 1}	
		<Object Name="attachment.do.AttachmentDO" 
				Description="Reference to Attachment Records" 
				Relationship="1-M" 
				Table="attachment" 
				CondColumn='type' 
				CondValue='{$table_name}' 
				Column="foreign_id" 
				FieldRef="Id" />{/if}
{if $features.picture eq 1}	
		<Object Name="picture.do.PictureDO" 
				Description="Reference to Picture Records" 
				Relationship="1-M" 
				Table="picture" 
				CondColumn='type' 
				CondValue='{$table_name}' 
				Column="foreign_id" 
				FieldRef="Id" />{/if}
{if $features.self_reference eq 1}	
		<Object Name="{$do_full_name_ref}" 
				Description="Reference to Related Records" 
				Relationship="Self-Self" 
				Table="{$table_name}" 
				Column="id" 
				FieldRef="Id" 
				OnDelete="Cascade" 
				OnUpdate="" 
				XTable="{$table_name_related}" 
				XColumn1="{$table_ref_id}" 
				XColumn2="related_id" 
				XDataObj="{$do_full_name_related}"/>
{/if}
{if $features.extend eq 1}
		<Object Name="extend.do.ExtendDataDO" 
				Description="Reference to Extend Data Field Record"  
				Relationship="1-M" 
				Table="extend_data" 
				CondColumn='module' 
				CondValue='{$table_name}' 
				Column="type_id" 
				FieldRef="type_id" 
				Column2="record_id" 
				FieldRef2="Id" 
				onDelete="Cascade"/>
{/if}
	</ObjReferences>
</BizDataObj>